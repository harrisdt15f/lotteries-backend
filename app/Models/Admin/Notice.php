<?php

namespace App\Models\Admin;


use Illuminate\Support\Facades\Validator;

class Notice extends Base
{
    // 如果未设置 默认是蛇形复数形式的表明
    protected $table = "sys_notice";


    public $rules = [];

    static $types = [
        1 => "普通公告",
        2 => "维护公告"
    ];

    /**
     * @param $c
     * @param $pageSize
     * @return mixed
     */
    static function getList($c, $pageSize = 20) {
        $query = self::orderBy('id', 'desc');
        if (isset($c['type']) && $c['type'] && $c["type"] != 'all') {
            $query->where('type', '=', $c['type']);
        }

        $currentPage    = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $menus  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    // 保存
    public function saveItem($adminId = 0) {
        $data       = request()->all();
        $validator  = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $this->type         = $data['type'];
        $this->title        = $data['title'];
        $this->content      = $data['content'];
        $this->start_time   = strtotime($data['start_time']);
        $this->end_time     = strtotime($data['end_time']);
        $this->admin_id     = $adminId;

        $this->save();

        return true;
    }

    /**
     * 获取素有公告 - 从缓存
     * @return mixed
     */
    static function getDataFromCache() {
        if (self::hasCache('notice')) {
            return self::getCacheData('notice');
        } else {
            $allCache = self::getAllNotice();
            if ($allCache) {
                self::saveCacheData('notice', $allCache);
            }

            return $allCache;
        }
    }

    /**
     * 数据库获取所有可用公告
     * @return mixed
     */
    static function getAllNotice() {
        $res = self::where('status', 1)->orderBy("top_score", 'desc')->get();
        $data = [];
        foreach ($res as $_item) {
            $data[] = ['title' => $_item->title, 'content' => $_item->content];
        }
        return $data;
    }

    /**
     * 获取置顶的单条公告内容
     * @return string
     */
    static function getListForApi() {
        $data = self::getDataFromCache();
        return $data && isset($data[0]) ? $data[0]['content'] : "";
    }
}

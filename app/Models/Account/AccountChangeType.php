<?php

namespace App\Models\Account;


use App\Models\Base;

class AccountChangeType extends Base
{
    protected $table = 'account_change_type';

    static function getList($c, $pageSize = 20) {
        $query = self::orderBy('id', 'desc');


        $currentPage    = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $menus  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    // 保存
    public function saveItem() {
        $data       = \Request::all();
        $validator  = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $this->cn_name          = $data['cn_name'];
        $this->en_name          = $data['en_name'];
        $this->series_id        = $data['series_id'];
        $this->max_trace_number = intval($data['max_trace_number']);
        $this->issue_format     = $data['issue_format'];

        $this->is_fast          = isset($data['is_fast']) ? 1 : 0;
        $this->auto_open        = isset($data['auto_open']) ? 1 : 0;

        $this->save();
        return true;
    }


    /**
     * 获取具体详情
     * @param $sign
     * @return array|mixed
     */
    static function getTypeBySign($sign) {
        $data = self::getDataListFromCache();
        if (isset($data[$sign])) {
            return $data[$sign];
        }

        return [];
    }

    // 获取所有配置 缓存
    static function getDataListFromCache($cacheKey = 'account_change_type') {

        if (self::_hasCache($cacheKey)) {
            return self::_getCacheData($cacheKey);
        } else {
            $allCache = self::getDataFromDb();
            if ($allCache) {
                self::_saveCacheData($cacheKey, $allCache);
            }

            return $allCache;
        }
    }

    // 获取所有数据 无缓存
    static function getDataFromDb() {
        $items = self::orderBy('id', 'desc')->get();

        $data = [];
        foreach ($items as $item) {
            $data[$item->sign] = $item->toArray();
        }

        return $data;
    }
}

<?php

namespace App\Models\Stat;

use App\Models\Base;
use Illuminate\Support\Facades\DB;

class ActivityList extends Base {
    protected $table = 'activity_list';


    /**
     * 获取列表
     * @param $c
     * @param int $pageSize
     * @return array
     */
    static function getList($c, $pageSize = 15) {
        $query = self::orderBy('id', 'desc');

        // 用户名
        if(isset($c['username'])) {
            $query->where('username', $c['username']);
        }

        // 日期
        if(isset($c['parent_id'])) {
            $query->where('parent_id', $c['parent_id']);
        }

        // 日期 开始
        if(isset($c['start_day'])) {
            $query->where('day', ">=", $c['start_day']);
        }

        // 日期 结束
        if(isset($c['end_day'])) {
            $query->where('day', "<=", $c['end_day']);
        }

        $currentPage    = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $menus  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    /**
     * 初始化2天数据
     * @param $user
     * @return bool
     */
    static function initData($user) {
        $data = [
            [
                'user_id'   => $user->id,
                'username'  => $user->username,
                'top_id'    => $user->top_id,
                'parent_id' => $user->parent_id,
                'rid'       => $user->rid,
                'day'       => date("Ymd"),
            ],
            [
                'user_id'   => $user->id,
                'username'  => $user->username,
                'top_id'    => $user->top_id,
                'parent_id' => $user->parent_id,
                'rid'       => $user->rid,
                'day'       => date("Ymd", time() + 86400),
            ],
        ];

        return DB::table('stat_user_day')->insert($data);
    }
}

<?php

namespace App\Models\Account;


use App\Models\Base;

class AccountChangeReport extends Base
{
    protected $table = 'account_change_report';

    static function getList($c, $pageSize = 20) {
        $query = self::orderBy('id', 'desc');

        // 用户名
        if (isset($c['username']) && $c['username']) {
            $query->where('username', trim($c['username']));
        }

        // 用户名
        if (isset($c['user_id']) && $c['user_id']) {
            $query->where('user_id', trim($c['user_id']));
        }

        // 类型
        if (isset($c['type']) && $c['type'] && $c['type'] != 'all') {
            $query->where('type_sign', $c['type']);
        }

        // 平台
        if (isset($c['sign']) && $c['sign'] && $c['sign'] != 'all') {
            $query->where('sign', $c['sign']);
        }

        // project id
        if (isset($c['project_id']) && $c['project_id']) {
            $query->where('project_id', $c['project_id']);
        }

        // issue id
        if (isset($c['issue']) && $c['issue']) {
            $query->where('issue', $c['issue']);
        }

        // start time
        if (isset($c['start_time']) && $c['start_time']) {
            $query->where('process_time', ">=", strtotime($c['start_time']));
        }

        // end time
        if (isset($c['end_time']) && $c['end_time']) {
            $query->where('process_time', "<=", strtotime($c['end_time']));
        }

        // 页数
        if (isset($c['pageSize']) && $c['pageSize'] && intval($c['pageSize']) == $c['pageSize']) {
            $pageSize = intval($c['pageSize']) > 25 ? 25 : intval($c['pageSize']);
        }

        $currentPage    = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $menus  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    static function getSumBySign($userId, $day = "") {

        $R = db()->table('account_change_report')->select(
            'type_sign',
            'user_id',
            db()->raw('SUM(amount) as amount')
        );

        $R->where("user_id", $userId);
        if ($day) {
            $R->where("day", $day);
        }

        $R->groupBy("type_sign");
        return $R->get();

    }
}

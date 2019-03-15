<?php

namespace App\Models\Admin;


class Configure extends Base
{
    // 如果未设置 默认是蛇形复数形式的表明
    protected $table = 'sys_configures';

    /**
     * @param $condition
     * @param $pageSize
     * @return \Illuminate\Support\Collection
     */
    static function getConfigList($condition, $pageSize = 20) {
        $query = self::orderBy('id', 'desc');
        if (isset($condition['pid'])) {
            $query->where('pid', '=', $condition['pid']);
        } else {
            $query->where('pid', '=', 0);
        }

        $currentPage    = isset($condition['pageIndex']) ? intval($condition['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $menus  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

}

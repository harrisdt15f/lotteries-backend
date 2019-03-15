<?php

namespace App\Models\Game;

class Method extends BaseGame
{
    protected $table = 'methods';

    // 获取列表
    static function getList($condition, $pageSize = 20) {
        $query = self::orderBy('id', 'desc');

        if (isset($condition['lottery_id']) && $condition['lottery_id']) {
            $query->where('lottery_id', '=', $condition['lottery_id']);
        } else {
            $query->where('lottery_id', '=', 'cqssc');
        }

        if (isset($condition['method_id']) && $condition['method_id']) {
            $query->where('method_id', '=', $condition['method_id']);
        }

        $currentPage    = isset($condition['pageIndex']) ? intval($condition['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $menus  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    static function  checkIsWin($methodId, $code) {

    }
}

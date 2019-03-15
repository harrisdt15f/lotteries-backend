<?php

namespace App\Models\Admin;


class City extends Base
{
    // 如果未设置 默认是蛇形复数形式的表明
    protected $table = 'sys_city';

    /**
     * @param $provinceId
     * @return \Illuminate\Support\Collection
     */
    static function getCityList($provinceId = 0) {
        $query = self::orderBy('id', 'desc');
        if ($provinceId) {
            $query::where('pid', '=', $provinceId);
        }
        $res    = $query->get();

        $data   = [];
        foreach ($res as $item) {
            $data[$item->pid][] = $item;
        }

        return $item;
    }

}

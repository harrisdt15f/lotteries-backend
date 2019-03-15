<?php

namespace App\Models\Admin;
use Illuminate\Support\Facades\Config;

class Province
{

    /**
     * 获取省份数据
     * @return \Illuminate\Support\Collection
     */
    static function getProvince() {
        return Config::get("web.province", []);
    }

    /**
     * 获取城市数据
     * @return \Illuminate\Support\Collection
     */
    static function getCity() {
        return Config::get("web.province", []);
    }

}
<?php

namespace App\Models\Admin;


class Cache extends Base
{
    protected $table = 'sys_configures';

    static function getList() {
        $config = config("web.main.cache");

        $data = [];
        foreach ($config as $key => $config) {
            $config['data'] = self::_getCacheData($key);
            $data[$key]     = $config;
        }

        return $data;
    }

}

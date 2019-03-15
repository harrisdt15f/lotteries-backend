<?php namespace App\Lib;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class MyCache
{
    /**
     * 获取cache
     * @param $type
     * @param array $option
     * @param bool $focus
     * @return array
     */
    static function getCache($type, $option = [],  $focus = false) {
        $cacheConfig = Config::get('web.cache.' . $type);

        // 是否存在
        if (!$cacheConfig) {
            return [];
        }

        if (!class_exists($cacheConfig['class'])) {
            return [];
        }

        if (!method_exists($cacheConfig['class'], $cacheConfig['method'])) {
            return [];
        }

        // 强制刷新
        if ($focus) {
            return $cacheConfig['class']::{$cacheConfig['method']}($option);
        }

        $key = self::getKey($type, $option);

        if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            $data = $cacheConfig['class']::{$cacheConfig['method']}($option);
            Cache::put($key, $data, $cacheConfig['expire']);
            return $data;
        }
    }

    /**
     * 获取对应的key
     * @param $type
     * @param $option
     * @return int|string
     */
    static function getKey($type, $option) {
        if (!$option) {
            return $type;
        }

        $key = $type;

        foreach ($option as $_k => $_v) {
            $key .= "_" . $_v;
        }

        return $key;
    }
}

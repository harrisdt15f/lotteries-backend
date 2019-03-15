<?php

namespace App\Models;

use App\Lib\T;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;


class Base extends Model {

    /** ========== 缓存处理 ========== */

    /**
     * 获取缓存
     * @param $key
     * @return \Illuminate\Contracts\Cache\Repository
     * @throws \Exception
     */
    static function _getCacheData($key) {
        $cacheConfig = self::_getCacheConfig($key);
        return cache()->get($cacheConfig['key'], []);
    }

    /**
     * 保存
     * @param $key
     * @param $value
     * @throws \Exception
     */
    static function _saveCacheData($key, $value) {
        $cacheConfig = self::_getCacheConfig($key);
        if ($cacheConfig['expire_time'] <= 0) {
            return Cache::forever($cacheConfig['key'], $value);
        } else {
            $expireTime = Carbon::now()->addSeconds($cacheConfig['expire_time']);
            return cache()->put($cacheConfig['key'], $value, $expireTime);
        }
    }

    /**
     * @param $key
     * @return bool
     * @throws \Exception
     */
    static function _flushCache($key) {
        $cacheConfig = self::_getCacheConfig($key);
        return cache()->forget($cacheConfig['key'], []);
    }

    /**
     * 获取缓存
     * @param $key
     * @return mixed
     */
    static function _getCacheConfig($key) {
        $cacheConfig = config('web.main.cache');
        if (isset($cacheConfig[$key])) {
            return $cacheConfig[$key];
        } else {
            return $cacheConfig['common'];
        }
    }

    /**
     * @param $key
     * @return bool
     * @throws \Exception
     */
    static function _hasCache($key) {
        $cacheConfig = self::_getCacheConfig($key);
        return cache()->has($cacheConfig['key']);
    }

    /** ========== 通知处理 ========== */

    /**
     * 发送异常数据
     * @param $msg
     */
    static function errorNotice($msg) {
        return T::exceptionNotice($msg);
    }
}

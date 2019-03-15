<?php namespace App\Lib;

/**
 * Tom 2018.03
 * cache 必须支持 tags
 * Class Locker
 * @package App\Lib
 */
class Locker{

    static $tag          = "code_lock";

    // 缓存
    protected $memKey       = "";
    protected $memValue     = "";
    protected $prefix       = "_code_lock_";

    // 时间
    protected $cacheTimeout     = 5;  // 分钟
    protected $lockerTimeout    = 30; // 秒

    // 睡眠时间 目前支持秒
    protected $sleepSeconds     = 5;

    public function __construct($key, $cacheTimeout = 5, $lockerTimeout = 30, $sleepSeconds = 5) {
        $this->memKey           = $this->prefix . $key;
        $this->memValue         = $key . "_" .  date("Y-m-d H:i:s");

        $this->cacheTimeout     = $cacheTimeout;
        $this->lockerTimeout    = $lockerTimeout;

        $this->sleepSeconds     = $sleepSeconds;
    }

    // 获取锁
    public function getLock() {

        $time = time();

        while (time() - $time < $this->lockerTimeout) {

            if(cache()->tags(self::$tag)->add($this->memKey, $this->memValue, $this->cacheTimeout)) {
                return true;
            }
            sleep($this->sleepSeconds);
        }

        return false;
    }

    // 释放当前
    public function release() {

        try {
            $ret = cache()->tags(self::$tag)->forget($this->memKey);
        } catch (\Exception $e) {
            $ret = false;
        }

        return $ret;
    }

    // 释放所有
    static function releaseAll() {
        cache()->tags(self::$tag)->flush();
    }
}
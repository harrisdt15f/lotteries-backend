<?php namespace App\Lib;

use App\Models\Admin\AdminMenu;
use App\Models\Admin\TelegramChatId;
use Illuminate\Support\Facades\Cache;

class CommonCache
{
    static $tags = [
        'breadcrumb'        => "common",
        'telegram_chat_id'  => "common",
    ];

    /**
     * 获取面包屑缓存
     * @param array $default
     * @param bool $flush
     * @return mixed
     */
    static function getBreadcrumb($default = [], $flush = false) {
        $key    = "breadcrumb";
        // 强制刷新
        if ($flush) {
            self::flush('common', $key);
        }

        return Cache::tags(self::$tags[$key])->get($key, function () use($key, $default) {
            $breadcrumb    = AdminMenu::getBreadcrumb();
            if ($breadcrumb) {
                Cache::tags(self::$tags[$key])->forever($key, $breadcrumb);
                return $breadcrumb;
            } else {
                return $default;
            }
        });
    }

    /**
     * 获取 telegram chat Id
     * @param array $default
     * @param bool $flush
     * @return mixed
     */
    static function getTelegramChatId($default = [], $flush = false) {
        $key    = "telegram_chat_id";
        // 强制刷新
        if ($flush) {
            self::flush('common', $key);
        }

        return Cache::tags(self::$tags[$key])->get($key, function () use($key, $default) {
            $ids    = TelegramChatId::getAllChatId();
            if ($ids) {
                Cache::tags(self::$tags[$key])->forever($key, $ids);
                return $ids;
            } else {
                return $default;
            }
        });
    }

    /**
     * 刷新Tag下的所有
     * @param string $tag
     * @param string $key
     */
    static function flush($tag = "", $key = "") {
        if ($tag && $key) {
            Cache::tags($tag)->flush();
        } else if ($tag) {
            Cache::tags($tag)->flush();
        } else  {
            foreach (self::$tags as $key => $tag) {
                Cache::tags($tag)->flush();
            }
        }
    }
}

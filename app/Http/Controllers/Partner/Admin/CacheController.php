<?php

namespace App\Http\Controllers\Partner\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\AdminMenu;
use App\Models\Admin\SystemCache;
use Illuminate\Http\Request;
use App\Lib\Help;

class CacheController extends Controller
{
    public function index(Request $request)
    {
        // 顶部按钮
        $buttonConfig = [
            ['route' => "cacheFlushAll",  'params' => []]
        ];
        $buttons = AdminMenu::buildButtons($buttonConfig);

        $config = config("web.main.cache");

        $data = SystemCache::getList();

        return Help::adminView('system/cache/list')->with(['data' => $data, 'buttons' => $buttons, 'config' => $config]);
    }

    /**
     * 刷新缓存
     * @param $key
     * @return \Illuminate\Http\JsonResponse
     */
    public function flush($key) {
        SystemCache::flushCache($key);
        return Help::returnJson(__('cache.flush.success'), 1, ['url' => route("cacheList")]);
    }

    /**
     * 刷新所有缓存
     * @return array
     */
    public function flushAll()
    {
        $config = config("web.main.cache");
        foreach ($config as $key => $_c) {
            SystemCache::flushCache($key);
        }

        return Help::returnJson(__('cache.flush_all.success'), 1, ['url' => route("cacheList")]);
    }


}

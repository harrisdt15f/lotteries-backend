<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\AdminMenu;
use App\Models\Admin\Cache;
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

        $data = Cache::getList();

        return Help::adminView('admin/cache/list')->with(['data' => $data, 'buttons' => $buttons, 'config' => $config]);
    }

    /**
     * @param $key
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function flush($key) {
        Cache::_flushCache($key);
        return Help::returnJson(__('cache.flush.success'), 1, ['url' => route("cacheList")]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function flushAll()
    {
        $config = config("web.main.cache");
        foreach ($config as $key => $_c) {
            Cache::_flushCache($key);
        }

        return Help::returnJson(__('cache.flush_all.success'), 1, ['url' => route("cacheList")]);
    }


}

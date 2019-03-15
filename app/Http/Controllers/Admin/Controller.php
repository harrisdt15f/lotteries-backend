<?php

namespace App\Http\Controllers\Admin;


use App\Lib\CommonCache;
use App\Models\Admin\AdminAccessLog;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

    public $adminUser = '';
    public $pageSize  = 20;

    function __construct()
    {
        // 当前地址 puppet
        \View::share('currentUrl',  \Request::url());

        $this->middleware(function ($request, $next) {
            $this->adminUser =  \Auth::guard('admin')->user();
            \View::share('adminUser',  $this->adminUser);

            // 列表页的标题
            if (isset($this->listTitle)) {
                \View::share('listTitle',  $this->listTitle);
            } else {
                \View::share('listTitle',  "数据列表");
            }

            \View::share('pageSize',  $this->pageSize);

            // 记录访问日志
            AdminAccessLog::saveItem($this->adminUser);
            return $next($request);
        });

        // 面包屑深度
        \View::share('breadcrumb',  CommonCache::getBreadcrumb([], true));
    }

}

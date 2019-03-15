<?php

namespace App\Http\Controllers\Partner\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Lib\Help;
use App\Models\Admin\AdminAccessLog;

class AdminAccessLogController extends Controller
{

    public function index()
    {
        $c          = \Request::all();
        $pager      = \Request::get("pageIndex", 1);
        $pageSize   = \Request::get("pageSize", 20);
        $offset     = ($pager - 1) * $pageSize;

        $data = AdminAccessLog::getList($c, $offset, $pageSize);
        return Help::adminView("admin/admin_access_log/list")
                    ->with('data', $data);
    }
}

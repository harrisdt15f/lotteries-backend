<?php

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class AdminAccessLog extends Model
{
    protected $table = 'admin_access_logs';

    /**
     * 获取日志详情
     * @param $c
     * @param $offset
     * @param $pageSize
     * @return mixed
     */
    static function getList($c, $offset, $pageSize) {
        $query = self::orderBy('id', 'DESC');

        // 用户名
        if (isset($c['username']) && $c['username']) {
            $query->where('username', $c['username']);
        }

        // 路由
        if (isset($c['route']) && $c['route']) {
            $query->where('route', $c['route']);
        }

        $total  = $query->count();
        $items  = $query->skip($offset)->take($pageSize)->get();

        $currentPage    = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;

        return ['data' => $items, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    static function saveItem($user = null) {
        $routeName  = Route::getCurrentRoute()->getName();
        $params     = \Request::all();
        $query      = new self();

        $query->admin_username  = $user ? $user->username : "---";
        $query->admin_id        = $user ? $user->id : 0;
        $query->route           = $routeName;
        $query->ip              = \Request::getClientIp();
        $query->params          = json_encode($params);

        $query->day             = date("Ymd");
        $query->save();
        return true;
    }
}

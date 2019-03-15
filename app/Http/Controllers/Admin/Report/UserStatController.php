<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Admin\Controller;
use App\Lib\Help;
use App\Models\Stat\UserStatDay;
use Illuminate\Support\Facades\Request;


class UserStatController extends Controller
{

    public function index()
    {
        $c      = Request::all();
        $data   = UserStatDay::getList($c);
        return Help::adminView("report/user_stat/list")->with(['data' => $data,]);
    }
}

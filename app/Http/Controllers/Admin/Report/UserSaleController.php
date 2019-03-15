<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Admin\Controller;
use App\Lib\Help;
use App\Models\Stat\SaleDay;
use App\Models\Stat\UserSaleDay;
use Illuminate\Support\Facades\Request;

class UserSaleController extends Controller
{
    public function index()
    {
        $c      = Request::all();
        $data   = UserSaleDay::getList($c);
        return Help::adminView("report/user_sale/list")->with(['data' => $data,]);
    }
}

<?php
namespace App\Http\Controllers\Admin\Finance;

use App\Lib\Help;
use App\Http\Controllers\Admin\Controller;
use App\Models\Finance\RechargeLog;
use Illuminate\Http\Request;

class RechargeLogController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $c      = $request->all();
        $data   = RechargeLog::getList($c);

        return Help::adminView("finance/recharge_log/list")->with(['data' => $data, 'c' => $c]);
    }
}

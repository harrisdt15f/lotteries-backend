<?php
namespace App\Http\Controllers\Admin\Finance;

use App\Lib\Help;
use App\Http\Controllers\Admin\Controller;
use App\Models\Finance\WithdrawLog;
use Illuminate\Http\Request;

class WithdrawLogController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $c      = $request->all();
        $data   = WithdrawLog::getList($c);

        return Help::adminView("finance/withdraw_log/list")->with(['data' => $data, 'c' => $c]);
    }
}

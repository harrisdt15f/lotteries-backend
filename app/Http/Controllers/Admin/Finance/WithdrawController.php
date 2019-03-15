<?php
namespace App\Http\Controllers\Admin\Finance;

use App\Lib\Help;
use App\Http\Controllers\Admin\Controller;
use App\Models\Finance\Withdraw;
use App\Models\Finance\WithdrawLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WithdrawController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data   = Withdraw::getList($request->all());
        
        return Help::adminView("finance/withdraw/list")->with(['data' => $data]);
    }

    public function logDetail($id) {
        $order = Withdraw::find($id);
        if (!$order) {
            return Help::AdminErrorView("对不起, 不存在的提现记录!", 0);
        }

        $log = WithdrawLog::where('order_id', $order->id)->first();

        return Help::adminView("finance/withdraw/log")->with(['item' => $log]);
    }

    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hand($id)
    {
        $item = Withdraw::find($id);
        if (!$item) {
            return Help::AdminErrorView("对不起, 不存在的充值记录!", 0);
        }

        if (!in_array($item->status, [0, 1, 2, 3, -3])) {
            return Help::AdminErrorView("对不起, 订单状态不正确!", 0);
        }

        if (\Request::isMethod('post')) {
            $type       = \Request::get("type");
            $amount     = \Request::get("amount");
            $reason     = \Request::get("reason");
            $fundPass   = \Request::get("fund_password");

            if (!$fundPass || !Hash::check($fundPass, $this->adminUser->fund_password)) {
                return Help::returnJson('对不起, 无效的资金密码!', 0);
            }

            if (!$amount) {
                return Help::returnJson("对不起, 无效的金额!", 0);
            }

            if ($amount * 10000 > $item->amount) {
                return Help::returnJson("对不起, 资金不能超过充值资金!", 0);
            }

            if ($type == 1) {
                $item->status           = -3;
                $item->fail_reason      = $reason;
                $item->admin_id         = $this->adminUser->id;
                $item->callback_time    = time();
                $item->save();
            } else {

                $res = $item->process($amount * 10000, $this->adminUser->id, $reason);
                if ($res !== true) {
                    return Help::returnJson($res, 0);
                }
            }

            return Help::returnJson("恭喜, 人工处理成功!", 1, ['url' => route("withdrawList")]);
        }


        return Help::adminView("finance/withdraw/hand")->with(['model' => $item]);
    }
}

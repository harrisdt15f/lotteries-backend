<?php
namespace App\Http\Controllers\Admin\Finance;

use App\Lib\Help;
use App\Http\Controllers\Admin\Controller;
use App\Models\Finance\Recharge;
use App\Models\Finance\RechargeLog;
use Illuminate\Http\Request;

class RechargeController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $c      = $request->all();
        $data   = Recharge::getList($c);

        return Help::adminView("finance/recharge/list")->with(['data' => $data, 'c' => $c]);
    }

    public function logDetail($id) {
        $order = Recharge::find($id);
        if (!$order) {
            return Help::AdminErrorView("对不起, 不存在的充值记录!", 0);
        }

        $log = RechargeLog::where('order_id', $order->id)->first();

        return Help::adminView("finance/recharge/log")->with(['item' => $log]);
    }

    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hand($id)
    {
        $item = Recharge::find($id);
        if (!$item) {
            return Help::AdminErrorView("对不起, 不存在的充值记录!", 0);
        }

        if ($item->status != 1 && $item->status != 0) {
            return Help::AdminErrorView("对不起, 订单状态不正确!", 0);
        }

        if (\Request::isMethod('post')) {
            $type       = \Request::get("type");
            $amount     = \Request::get("amount");
            $reason     = \Request::get("reason");

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

            return Help::returnJson("恭喜, 人工处理成功!", 1, ['url' => route("rechargeList")]);
        }


        return Help::adminView("finance/recharge/hand")->with(['model' => $item]);
    }
}

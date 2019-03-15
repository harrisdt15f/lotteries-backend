<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Admin\Controller;
use App\Lib\Clog;
use App\Lib\Pay\Pay;
use App\Models\Finance\Recharge;
use App\Models\Finance\RechargeLog;
use App\Models\Player\Player;


/**
 * TO M 2019
 * Class CallbackController
 * @package App\Http\Controllers\Admin\Finance
 */
class CallbackController extends Controller
{

    public function recharge($sign)
    {
        $params = \Request::all();

        Clog::rechargeCallback("common", "初始化" . $sign, $params);

        // 标识是否为空
        if (!$sign) {
            Clog::rechargeCallback("common", "error-参数平台标识不存在-" . $sign, $params);
            echo 'fail';die;
        }

        // 平台是否存在
        $platformAll = Pay::getAllPlatform();
        if (!in_array($sign, $platformAll)) {
            Clog::rechargeCallback("common", "error-参数平台标识不合法-" . $sign, $params);
            echo 'fail';die;
        }

        try {
            $handle = Pay::getHandle($sign);
            $handle->setRechargeCallbackParams($params);

            // 参数检查
            $res = $handle->checkRechargeCallbackParams();
            if ($res !== true) {
                Clog::rechargeCallback("common", "error-{$res}!", $params);
                $handle->renderFail();
            }

            $order = Recharge::where("order_id", $params["game_order_id"])->first();
            if (!$order) {
                Clog::rechargeCallback("common", "error-没有查到订单!", $params);
                $handle->renderFail();
            }

            $handle->setRechargeOrder($order);
            $handle->updateCallbackLog(['content' => json_encode($params), 'back_time' => time()]);

            $user = Player::find($order->user_id);
            if (!$user) {
                $handle->updateCallbackLog(['back_status' => 2, 'back_reason' => "无效的用户"]);
                Clog::rechargeCallback("common", "error-没有查到对应用户!", $params);
                $handle->renderFail();
            }

            $handle->setRechargeUser($user);

            // 签名检查
            if (!$handle->checkRechargeCallbackSign()) {
                Clog::rechargeCallback($sign, "error-签名不匹配", $params);
                $handle->updateCallbackLog(['back_status' => 2, 'back_reason' => "签名不匹配"]);
                $handle->renderFail();
            }

            $ret = $handle->processOrder();

            if ($ret === true) {
                $handle->updateCallbackLog(['back_status' => 1, 'back_reason' => "回调成功"]);
                $handle->renderSuccess();
                die;
            }

            $handle->updateCallbackLog(['back_status' => 2, 'back_reason' => $ret]);
            $handle->renderFail();

        } catch(\Exception $e) {
            $logData = [
                'msg'       => $e->getMessage(),
                'line'      => $e->getLine(),
                'file'      => $e->getFile(),
                'params'    => $params,
            ];
            Clog::rechargeCallback($sign, "充值回调异常!", $logData);
            echo 'fail';die;
        }



    }

    public function withdraw($platform) {


    }

}

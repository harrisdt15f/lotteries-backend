<?php namespace App\Lib;

use App\Jobs\Alarm;

/**
 * 1 通用 2 提现 3 审核 4 充值
 * Class T
 * @package App\Lib
 */
class T {

    // 后台通知
    static function adminNotice($msg) {
        $data = [
            'type'  => 1,
            'msg'   => "通用:" . $msg,
        ];
        dispatch((new Alarm('telegram', $data))->onQueue('common'));
    }

    // 异常通知
    static function exceptionNotice($msg) {
        $data = [
            'type'  => 1,
            'msg'   => "通用:" . $msg,
        ];
        dispatch((new Alarm('telegram', $data))->onQueue('common'));
    }

    /** =========== 队列函数 =========== */

    /**
     * 组类型
     * 信息
     * @param $type
     * @param $msg
     */
    static function sendMessage($type, $msg) {
        $allChatIds = CommonCache::getTelegramChatId();
        $chartIds   = $allChatIds[$type];
        foreach ( $chartIds as $id) {
            \Telegram::sendMessage([
                'chat_id'   => $id,
                'text'      => "财务-" . $msg
            ]);
        }
    }
}
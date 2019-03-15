<?php

namespace App\Models\Finance;

use App\Lib\Locker\AccountLocker;
use App\Lib\Clog;
use App\Lib\Logic\AccountChange;
use App\Lib\Pay\Pay;
use App\Models\Admin\Province;
use App\Models\Base;
use App\Models\Player\Player;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class Recharge extends Base
{
    public $rules = [
        'owner_name'        => 'required|min:2|max:128',
        'card_number'       => 'required|integer',
        'province'          => 'required|integer',
        'city'              => 'required|integer',
        'branch'            => 'required|min:4|max:128',
    ];

    protected $table = 'user_recharge';

    static $handType = [
        2 => "人工成功",
        1 => "人工失败",
    ];

    const STATUS_INIT               = 0;
    const STATUS_SEND_SUCCESS       = 1;
    const STATUS_CALLBACK_SUCCESS   = 2;
    const STATUS_MANUAL_SUCCESS     = 3;
    const STATUS_SEND_FAIL          = -1;
    const STATUS_CALLBACK_FAIL      = -2;
    const STATUS_MANUAL_FAIL        = -3;

    // 状态
    static $status = [
        0   => "初始化",
        1   => "代发成功",
        2   => "回调成功",
        3   => "人工成功",
        -1  => "代发失败",
        -2  => "回调失败",
        -3  => "人工失败",
    ];

    static function getList($c, $pageSize = 20) {
        $query = self::orderBy('id', 'desc');

        // 用ID
        if (isset($c['user_id']) && $c['user_id']) {
            $query->where('user_id', $c['user_id']);
        }


        // 用户名
        if (isset($c['username']) && $c['username']) {
            $query->where('username', $c['username']);
        }

        // 昵称
        if (isset($c['nickname']) && $c['nickname']) {
            $query->where('nickname', $c['nickname']);
        }

        // 上级
        if (isset($c['status']) && $c['status'] && $c['status'] != 'all') {
            if (is_array($c['status'])) {
                $query->whereIn('status', $c['status']);
            } else {
                $query->where('status', $c['status']);
            }

        }

        // 上级
        if (isset($c['order_id']) && $c['order_id']) {
            $query->where('order_id', trim($c['order_id']));
        }

        // 时间
        if (isset($c['start_time']) && $c['start_time']) {
            $query->where('init_time', ">=", strtotime($c['start_time']));
        }

        // 时间
        if (isset($c['end_time']) && $c['end_time']) {
            $query->where('init_time', "<=", strtotime($c['end_time']));
        }

        if (isset($c['pageSize']) && $c['pageSize'] && intval($c['pageSize']) == $c['pageSize']) {
            $pageSize = intval($c['pageSize']) > 100 ? 100 : intval($c['pageSize']);
        }

        $currentPage    = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $data  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $data, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    // 保存
    public function saveItem($adminId = 0) {
        $data       = \Request::all();
        $validator  = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $user = Player::where('username', $data['username'])->first();
        if (!$user->id) {
            return "无效的用户!";
        }

        // 卡号
        if (strlen($data['card_number']) < 15 || strlen($data['card_number']) > 19) {
            return "银行卡号只能是15位和19位之间!";
        }

        // 银行
        $banks = config("web.banks");
        if (!isset($data['bank_sign']) || !isset($banks[$data['bank_sign']])) {
            return "无效的开户行!";
        }

        // 省份
        $provinceList = Province::getProvince();
        if (!isset($data['province']) || !isset($provinceList[$data['province']])) {
            return "无效的省份!";
        }

        // 市区
        $cityList = $provinceList[$data['province']]['city'];
        if (!isset($data['city']) || !isset($cityList[$data['city']])) {
            return "无效的市区!";
        }

        $this->username             = $data['username'];
        $this->user_id              = $user->id;
        $this->bank_sign            = $data['bank_sign'];
        $this->card_number          = $data['card_number'];
        $this->branch               = $data['branch'];
        $this->owner_name           = $data['owner_name'];
        $this->province             = $provinceList[$data['province']]['name'];
        $this->city                 = $cityList[$data['city']];
        $this->admin_id             = $adminId;
        $this->save();
        return true;
    }

    static public function request($user, $money, $channel, $bankSign, $from = "web", $description = '')
    {
        $params = Request::all();
        db()->beginTransaction();
        try {
            // 加入请求
            $request = new Recharge;
            $request->user_id       = $user->id;
            $request->top_id        = $user->top_id;
            $request->username      = $user->username;
            $request->nickname      = $user->nickname;
            $request->parent_id     = $user->parent_id;
            $request->rid           = $user->rid;

            $request->channel       = $channel;             // 类型 支付宝
            $request->bank_sign     = $bankSign;

            $request->amount        = $money;               // 充值金额
            $request->init_time     = time();               // 请求时间
            $request->client_ip     = real_ip();            // 客户端IP
            $request->desc          = $description;         // 充值描述

            $request->sign          = "";                   // 附言
            $request->source        = $from;                // 来源

            $ret = $request->save();
            if(!$ret){
                db()->rollback();
                return false;
            }

            Clog::rechargeLog("生成订单之前: param" . serialize($params));
            $rechargeOrderPlus = configure("finance_recharge_order_plus", 10000000);

            $request->order_id = "HB" . ($request->id + $rechargeOrderPlus);
            $ret    = $request->save();
            if(!$ret) {
                db()->rollback();
                return false;
            }

            db()->commit();
        } catch (\Exception $e) {
            db()->rollback();
            Clog::rechargeLog("充值:初始化异常:" . $e->getMessage() . "|" . $e->getLine() . "|" . $e->getFile());
            return false;
        }

        return $request;
    }

    /**
     * 上分
     * @param $realMoney
     * @param int $adminId
     * @param string $reason
     * @return bool
     */
    public function process($realMoney, $adminId = 0, $reason = "")
    {
        if ($realMoney > $this->amount) {
            return "对不起, 无效的上分资金!!";
        }

        if ($this->status > 1) {
            return "对不起, 订单已经处理!!";
        }


        $locker = new AccountLocker($this->user_id);
        if(!$locker->getLock()){
            db()->rollback();
            return "对不起, 获取用户锁失败!!";
        }

        db()->beginTransaction();
        try {

            $user       = Player::find($this->user_id);
            $account    = $user->account();

            // 充值上分
            $params = [
                'user_id'       => $user->id,
                'amount'        => $realMoney,
                'desc'          => $adminId ? $adminId . "|" . $reason : ""
            ];

            $accountChange = new AccountChange();
            $res = $accountChange->change($account, 'recharge',  $params);
            if ($res !== true) {
                $locker->release();
                db()->rollback();
                return $res;
            }

            $this->real_amount      = $realMoney;
            $this->admin_id         = $adminId;
            $this->callback_time    = time();

            $this->status = $adminId ? self::STATUS_MANUAL_SUCCESS  : self::STATUS_CALLBACK_SUCCESS;
            $this->save();

            db()->commit();

            // 发送到统计队列
            dispatch( (new \App\Jobs\Stat('recharge',  ['user_id' => $user->id, 'record_id'  => $this->id]))->onQueue('stat_user') );
        } catch (\Exception $e) {
            db()->rollback();
            Clog::rechargeLog("充值:上分异常:" . $e->getMessage() . "-" . $e->getLine(). "-" . $e->getFile());
            return  $e->getMessage();
        }

        $locker->release();

        return true;
    }

    /**
     * 获取所有蚑渠道 走缓存
     * @return array|mixed
     */
    static function getRechargeChannel() {

        if (self::hasCache('recharge_channel')) {
            return self::getCacheData('recharge_channel');
        } else {
            $rechargeChannel = Pay::getRechargeChannel();

            $data = [];
            foreach ($rechargeChannel as $key => $channel) {
                $data[] = [
                    'chanel'        => $channel['channel_sign'],
                    'name'          => $channel['channel_name'],
                    'min_deposit'   => $channel['min'],
                    'max_deposit'   => $channel['max']
                ];
            }

            if ($data) {
                self::saveCacheData('recharge_channel', $data);
            }

            return $data;
        }
    }
}

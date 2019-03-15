<?php

namespace App\Models\Player;

use App\Lib\Clog;
use App\Lib\Locker\AccountLocker;
use App\Lib\Logic\AccountChange;
use App\Models\Account\Account;
use App\Models\Game\Issue;
use App\Models\Game\Lottery;
use App\Models\Game\Project;
use App\Models\Stat\UserStatDay;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Player extends Authenticatable  implements JWTSubject
{
    protected $table = 'users';


    const INVITE_CODE_INIT      = 2689;

    // 账户增加类型
    static $fundAddTypes = [
        1 => [
            'name'          => '普通理赔',
            'change_type'   => "system_common_claim"
        ],
        2 => [
            'name'          => '分红理赔',
            'change_type'   => "system_bonus_claim"
        ],
        3 => [
            'name'          => '充值理赔',
            'change_type'   => "system_recharge_claim"
        ],
        4 => [
            'name'          => '红包理赔',
            'change_type'   => "system_happy_claim"
        ],
        5 => [
            'name'          => '活动礼金',
            'change_type'   => "system_gift_transfer"
        ],
    ];

    // 账户减少类型
    static $fundReduceTypes = [
        1 => [
            'name'          => '系统扣减',
            'change_type'   => "system_reduce"
        ],
    ];

    // 冻结类型
    static $frozenType = [
        0 => "未冻结",
        1 => '禁止登录',
        2 => '禁止发抢',
        3 => '禁止提现',
    ];

    const PLAYER_TYPE_PARTNER       = 1;
    const PLAYER_TYPE_TOP           = 2;
    const PLAYER_TYPE_PROXY         = 3;
    const PLAYER_TYPE_PLAYER        = 4;

    static $types = [
        1 => "合作伙伴",
        2 => "直属",
        3 => "代理",
        4 => "会员"
    ];

    /** ============== JWT 实现 ================ */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 获取当前账户
     */
    public function account() {
        $account = Account::find($this->id);
        return $account;
    }

    static function getList($c, $pageSize = 10) {
        $query = Player::select(
            DB::raw('users.*'),
            DB::raw('user_accounts.balance'),
            DB::raw('user_accounts.frozen')
        )   ->leftJoin('user_accounts', 'user_accounts.user_id', '=', 'users.id')->orderBy('id', 'desc');

        // 用户名
        if (isset($c['username'])) {
            $query->where('username', $c['username']);
        }

        // 上级
        if (isset($c['parent_id'])) {
            $query->where('parent_id', $c['parent_id']);
        }

        $currentPage    = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $menus  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    // 投注
    public function bet($lottery, $data, $from = 1) {

        // @todo 冻结禁止投注状态
        // @todo 禁止两注单小于一秒

        // 彩种状态
        if (!$lottery || $lottery->status != 1) {
            return "对不起, 无效的彩种!";
        }

        // 投注内容
        if (!isset($data['balls'])) {
            return "对不起, 投注内容不存在!";
        }

        $betDetail = [];

        $_totalCost = 0;
        foreach ($data['balls'] as $item) {

            if (!isset($item['method_id']) || !isset($item['mode']) || !isset($item['prize_group']) || !isset($item['code']) || !isset($item['times']) || !isset($item['price'])) {
                return "对不起, 投注参数不合法!";
            }

            $methodId   = $item['method_id'];

            $allMethods = $lottery->methods;
            if (!$allMethods || !isset($allMethods[$methodId])) {
                return "对不起, 无效的玩法!";
            }

            // 是否开启
            $method = $lottery->getMethod($methodId);
            if (!$method ||$method['status'] != 1) {
                return "对不起, 玩法{$method['name']}未开启!";
            }

            // 玩法对象
            $oMethod    = Lottery::getMethodObjectByCache($method['series_id'], $method['method_id']);
            if (!$oMethod) {
                return "对不起, 玩法{$method['method_name']}, 未定义!";
            }

            // 模式
            $mode       = $item['mode'];
            $modes      = config('game.main.modes');
            if (!array_key_exists($mode, $modes)) {
                return "对不起, 模式{$mode}, 不存在!";
            }

            // 奖金组 - 游戏
            $prizeGroup = intval($item['prize_group']);
            if (!$lottery->isValidPrizeGroup($prizeGroup)) {
                return "对不起, 奖金组{$prizeGroup}, 游戏未开放!";
            }

            // 奖金组 - 用户
            if ($this->prize_group <  $prizeGroup) {
                return "对不起, 奖金组{$prizeGroup}, 用户不合法!";
            }

            // 投注号码
            $ball       = $item['code'];
            if (!$oMethod->regexp($ball)) {
                return "对不起, 玩法{$methodId}, 注单号码不合法!";
            }

            // 倍数
            $times      = intval($item['times']);
            if (!$lottery->isValidTimes($times)) {
                return "对不起, 倍数{$times}, 不合法!";
            }

            $price          = intval($item["price"]);
            $priceConfig    = config('game.main.price', [1, 2]);
            if (!$price || !in_array($price, $priceConfig)) {
                return "对不起, 单价{$price}, 不合法!";
            }

            $_totalCost += $mode * $times * $price;

            $betDetail[] = [
                'method_id'     => $methodId,
                'method_name'   => $method['method_name'],
                'mode'          => $mode,
                'prize_group'   => $prizeGroup,
                'times'         => $times,
                'price'         => $price,
                'total_price'   => $mode * $times * $price,
                'code'          => $ball,
            ];
        }

        // 投注期号
        $traceData = $data['trace_issue'];

        if (!$traceData)  {
            return "对不起, 奖期号不合法!";
        }

        // 检测追号奖期
        $traceData = $lottery->checkTraceData($traceData);
        if (!is_array($traceData)) {
            return $traceData;
        }

        // 获取当前奖期
        $currentIssue = Issue::getCurrentIssue($lottery->en_name);
        if (!$currentIssue) {
            return "对不起, 无效的奖期!";
        }

        // 奖期和追号
        if ($currentIssue->issue != $traceData[0]) {
            return "对不起, 奖期已过期!";
        }

        $accountLocker = new AccountLocker($this->id);
        if (!$accountLocker->getLock()) {
            return "对不起, 获取账户锁失败!";
        }

        $account = $this->account();
        if ($account->balance < $_totalCost) {
            $accountLocker->release();
            return "对不起, 当前余额不足!";
        }

        db()->beginTransaction();
        try {

            $traceData  = array_slice($traceData, 1);
            $data       = Project::addProject($this, $lottery, $currentIssue, $betDetail, $traceData, $from);


            // 帐变
            $accountChange = new AccountChange();
            $accountChange->setReportMode(AccountChange::MODE_REPORT_AFTER);
            $accountChange->setChangeMode(AccountChange::MODE_CHANGE_AFTER);

            foreach ($data['project'] as $item) {
                $params = [
                    'user_id'       => $this->id,
                    'amount'        => $item['cost'] * 10000,
                    'lottery_id'    => $item['lottery_id'],
                    'method_id'     => $item['method_id'],
                    'project_id'    => $item['id'],
                    'issue'         => $currentIssue->issue,
                ];

                $res = $accountChange->doChange($account, "bet_cost", $params);
                if ($res !== true) {
                    db()->rollback();
                    $accountLocker->release();
                    return "对不起, " . $res;
                }
            }

            $accountChange->triggerSave();

            db()->commit();
        } catch (\Exception $e) {
            db()->rollback();
            $accountLocker->release();
            Clog::userBet("投注-异常:" . $e->getMessage() . "|" . $e->getFile() . "|" . $e->getLine());
            return "对不起, " . $e->getMessage(). "|" . $e->getFile() . "|" . $e->getLine();
        }

        $accountLocker->release();

        return true;
    }

    /**
     * 添加总代
     * @param $username
     * @param $password
     * @param $prizeGroup
     * @param $isTest
     * @return bool|string
     */
    public function addTop($username, $password, $prizeGroup, $isTest = 0) {
        $res = self::checkPrizeGroup($prizeGroup);
        if ($res !== true) {
            return $res;
        }

        $res = self::checkUsername($username);
        if ($res !== true) {
            return $res;
        }

        $res = self::checkPassword($password);
        if ($res !== true) {
            return $res;
        }

        return self::_addPlayer($this, $username, $password, self::PLAYER_TYPE_TOP, $prizeGroup,  $isTest);
    }

    /**
     * 添加商户
     * @param $sign
     * @param $username
     * @param $password
     * @param $prizeGroup
     * @param $theme
     * @return bool|string
     */
    static function addPartner($sign, $username, $password, $prizeGroup, $theme) {
        $res = self::checkPrizeGroup($prizeGroup);
        if ($res !== true) {
            return $res;
        }

        $res = self::checkUsername($username);
        if ($res !== true) {
            return $res;
        }

        $res = self::checkPassword($password);
        if ($res !== true) {
            return $res;
        }

        return self::_addPlayer(null, $username, $password, self::PLAYER_TYPE_PARTNER, $prizeGroup, 0, $sign, $theme);
    }

    // 添加下级
    public function addChild($username, $password, $type, $prizeGroup) {

        $res = self::checkPrizeGroup($prizeGroup);
        if ($res !== true) {
            return $res;
        }

        $res = self::checkUsername($username);
        if ($res !== true) {
            return $res;
        }

        $res = self::checkPassword($password);
        if ($res !== true) {
            return $res;
        }

        if (!array_key_exists($type, self::$types) ) {
            return "对不起, 无效的数据类型!";
        }

        return self::_addPlayer($this, $username, $password, $type, $prizeGroup);
    }


    public function getRidStr() {
        $rid = $this->rid;
        $data = [];
        if ($rid) {
            $ids = explode("|", trim($rid, "|"));
            $users = Player::whereIn('id', $ids)->get();

            foreach ($users as $user) {
                $data[$user->id] = $user->nickname;
            }
        }
        return $data;
    }


    // @todo 事物
    static function _addPlayer($parent, $username, $password, $type, $prizeGroup, $isTest = 0, $sign = "Y1", $theme = "default") {
        db()->beginTransaction();
        try {
            // 保存用户
            $item = new self();
            $item->username         = $username;
            $item->nickname         = $username;
            $item->password         = Hash::make($password);
            $item->sign             = $parent ? $parent->sign : $sign;
            $item->type             = $type;
            $item->user_level       = $parent ? ($parent->user_level + 1) : 1;
            $item->prize_group      = $prizeGroup;
            $item->top_id           = $parent ? ($parent->top_id ? $parent->top_id : $parent->id) : 0;
            $item->parent_id        = $parent ? $parent->id : 0;
            $item->rid              = $parent ? $parent->rid : '';
            $item->is_tester        = intval($isTest);
            $item->frozen_type      = 0;
            $item->levels           = 0;
            $item->theme            = $parent ? $parent->theme : $theme;
            $item->register_ip      = real_ip();
            $item->register_time    = time();
            $item->status           = 1;
            $item->save();

            if (!$item->rid) {
                $item->rid = $item->id . "|";
            } else {
                $item->rid = $item->rid .  $item->id . "|";
            }

            $item->save();

            // 生成账户
            $account = new Account();
            $account->user_id   = $item->id;
            $account->top_id    = $item->top_id;
            $account->parent_id = $item->parent_id;
            $account->rid       = $item->rid;
            $account->status    = 1;

            // 测试账号默认 50000
            if ($item->is_tester) {
                $balance   = \C::get('user_tester_default_balance', 50000);
                $account->balance = $balance;
            }

            $account->save();

            // 初始化统计数据
            UserStatDay::initUserStatData($item);
            db()->commit();
        } catch (\Exception $e) {
            db()->rollback();
            Clog::userAddChild("添加下级-" . $e->getMessage() . "-" . $e->getFile() . "-" . $e->getLine());
            return $e->getMessage();
        }

        return $item;
    }

    /**
     * @param $mode
     * @param $type
     * @param $amount
     * @param $reason
     * @param null $testAdmin
     * @return bool|string
     */
    public function manualTransfer($mode, $type, $amount, $reason, $testAdmin = null) {
        $min    = configure("proxy_transfer_min", 1);
        $max    = configure("proxy_transfer_max", 10000);

        if ($testAdmin && $testAdmin->id == 1) {
            $max = configure("proxy_transfer_max_super", 200000);
        }

        $account    = $this->account();
        if (!$account) {
            return "对不起, 账户不存在!";
        }

        $adminUser  = auth()->guard('admin')->user();
        $adminUser  = $adminUser ? $adminUser : $testAdmin;

        if (1 == $mode) {
            if (!array_key_exists($type, Player::$fundAddTypes)) {
                return "对不起, 无效的类型!";
            }

            if ($amount < $min || $amount > $max) {
                return "对不起, 无效的金额!";
            }

            if (!$reason) {
                return "对不起, 请输入描述!";
            }

            $accountLock = new AccountLocker($this->id);
            if (!$accountLock->getLock()) {
                return "对不起, 获取账户锁失败, 请稍后再试!";
            }

            $transferConfig = Player::$fundAddTypes[$type];
            db()->beginTransaction();
            try {
                // 帐变 - 中奖
                $params = [
                    'user_id'           => $this->id,
                    'amount'            => $amount * 10000,
                    'from_admin_id'     => $adminUser->id,
                    'desc'              => $transferConfig['name'] . "|" . $reason
                ];

                $accountChange = new AccountChange();
                $res = $accountChange->change($account, $transferConfig['change_type'],  $params);
                if ($res !== true) {
                    $accountLock->release();
                    db()->rollback();
                    return $res;
                }

                // 保存记录
                $record = AdminTransferRecords::addItem($this, $mode, $type, $params['amount'], $params['desc'], $adminUser);

                db()->commit();

            } catch(\Exception $e) {
                $accountLock->release();
                db()->rollback();
                return $e->getMessage() . "|" . $e->getLine() . "|" . $e->getFile();
            }

            $accountLock->release();

            // 统计
            dispatch( (new \App\Jobs\Stat('system_claim',  ['user_id' => $this->id, 'record_id'  => $record->id]))->onQueue('stat_user') );
        } else {

            if (!array_key_exists($type, Player::$fundReduceTypes)) {
                return "对不起, 无效的类型!";
            }

            // 金额
            $amount = intval(\Request::get("amount", 0));
            if ($amount < $min || $amount > $max) {
                return "对不起, 无效的金额!";
            }

            // 描述
            if (!$reason) {
                return "对不起, 请输入描述!";
            }

            // 价差余额
            if ($account->balance < $amount * 10000) {
                return "对不起, 余额不足!";
            }

            $accountLock = new AccountLocker($this->id);
            if (!$accountLock->getLock()) {
                return "对不起, 获取账户锁失败, 请稍后再试!";
            }

            $transferConfig = Player::$fundAddTypes[$type];
            db()->beginTransaction();
            try {
                // 帐变 - 中奖
                $params = [
                    'user_id'       => $this->id,
                    'amount'        => $amount * 10000,
                    'from_admin_id' => $adminUser->id,
                    'desc'          => $transferConfig['name'] . "|" . $reason
                ];

                $accountChange = new AccountChange();
                $res = $accountChange->change($account, $transferConfig['change_type'], $params);
                if ($res !== true) {
                    $accountLock->release();
                    db()->rollback();
                    return $res;
                }

                // 保存记录
                $record = AdminTransferRecords::addItem($this, $mode, $type, $params['amount'], $params['desc'], $adminUser);

                db()->commit();
            } catch (\Exception $e) {
                $accountLock->release();
                db()->rollback();
                return $e->getMessage() . "|" . $e->getLine() . "|" . $e->getFile();
            }

            $accountLock->release();

            // 统计
            dispatch((new \App\Jobs\Stat('system_reduce', ['user_id' => $this->id, 'record_id' => $record->id]))->onQueue('stat_user'));
        }

        return true;
    }

    /**
     * 用户名检测
     * @param $username
     * @return string
     */
    static function checkUsername($username) {
        // 1. 长度是否合法
        if (!preg_match("/^[0-9a-zA-Z_]{6,16}$/i", $username)) {
            return "对不起,用户名不符合规则!";
        }

        // 2. 是否存在重复用户名
        $count = self::where('username', '=', $username)->count();
        if ($count > 0) {
            return '对不起,该用户名已被注册，请选择其他用户名!';
        }

        return true;
    }

    /**
     * 密码检测
     * @param $password
     * @return bool|string
     */
    static function checkPassword($password) {
        if (!preg_match("/^[0-9a-zA-Z]{6,16}$/i", $password) || preg_match("/^[0-9]+$/", $password) || preg_match("/^[a-zA-Z]+$/i", $password) || preg_match("/(.)\\1{2,}/i", $password)) {
            return "对不起,密码输入不正确!";
        } else {
            return true;
        }
    }

    // 检查奖金组
    static function checkPrizeGroup($prizeGroup) {
        $minGroup = \C::get('user_min_prize_group', 1800);
        $maxGroup = \C::get('user_max_prize_group', 1980);

        if ($prizeGroup < $minGroup) {
            return "对不起,奖金组不能低于{$minGroup}!";
        }

        if ($prizeGroup > $maxGroup) {
            return "对不起,奖金组不能高于{$maxGroup}!";
        }

        return true;
    }

    // 检查用户类型
    static function checkUserType($userType) {
        if (!in_array($userType, array(self::PLAYER_TYPE_TOP, self::PLAYER_TYPE_PROXY, self::PLAYER_TYPE_PLAYER))) {
            return "无效的用户类型!";
        }
        return true;
    }

    // 获取今日提现数量
    public function getTodayDrawCount() {
        $todayStart = strtotime(date("Y-m-d 00:00:00"));
        $todayEnd   = strtotime(date("Y-m-d 23:59:59"));

        $count = Withdraw::where('user_id', $this->id)->whereIn('status', [2,3])->where('process_time', ">=", $todayStart)->where('process_time', "<=", $todayEnd)->count();
        return $count;
    }

    /**
     * 冻结用户不能提现
     * @return bool
     */
    public function canWithdraw() {

        if($this->frozen_type > 0 ) {
            return false;
        }

        return true;
    }

    /**
     * 提现是否需要审核
     * @return bool
     */
    public function needWithdrawCheck() {
        // 检查是否开启审核
        $isNeedCheck = configure('finance_withdraw_need_check', 1);
        if ($isNeedCheck != 1) {
            return false;
        }

        return true;
    }

    public function haveFundChange() {

        return true;
    }

    /**
     * 提现审核
     * @param $amount
     * @param $card
     * @param string $source
     * @return bool
     */
    public function requestWithdraw($amount, $card, $source = 'web') {
        $ret = Withdraw::request($this, $amount, $card, $source);
        if (true !== $ret) {
            return $ret;
        }

        return true;
    }
}

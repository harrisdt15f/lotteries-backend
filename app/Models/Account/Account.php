<?php

namespace App\Models\Account;

use App\Lib\Clog;
use App\Models\Base;
use App\Models\Player\Player;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Account extends Base
{
    protected $table = 'user_accounts';

    const FROZEN_STATUS_OUT         = 1;
    const FROZEN_STATUS_BACK        = 2;
    const FROZEN_STATUS_TO_PLAYER   = 3;
    const FROZEN_STATUS_TO_SYSTEM   = 4;
    const FROZEN_STATUS_BONUS       = 5;


    const MODE_CHANGE_AFTER = 2;
    const MODE_CHANGE_NOW   = 1;

    public $mode    = 1;
    public $changes = [];

    public function user() {
        return Player::find($this->user_id);
    }

    static function getList($c, $pageSize = 10) {
        $query = Account::select(
            DB::raw('user_accounts.*'),
            DB::raw('users.username'),
            DB::raw('users.prize_group')
        )->leftJoin('users', 'user_accounts.user_id', '=', 'users.id')->orderBy('id', 'desc');

        // 用户名
        if (isset($c['username'])) {
            $query->where('username', $c['username']);
        }

        // 上级
        if (isset($c['parent_name'])) {
            $query->where('parent_name', $c['parent_name']);
        }

        $currentPage    = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $menus  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    // 设置模式
    public function setChangeMode($mode) {
        $this->mode = $mode;
    }

    // 执行帐变
    public function change($type, $params)
    {
        try{
            return $this->doChange($type, $params);
        }catch (\Exception $e){
            Clog::account("error-" . $e->getMessage() . "|" . $e->getLine() . "|" . $e->getFile());
            return $e->getMessage();
        }
    }

    // 帐变逻辑
    public function doChange($typeSign, $params)
    {
        $user       = $this->user();
        $typeConfig = AccountChangeType::getTypeBySign($typeSign);

        //　1. 获取帐变配置
        if (empty($typeConfig)) {
            Clog::account("error-{$user->id}-{$typeSign}不存在!");
            return "对不起, {$typeSign}不存在!";
        }

        // 2. 参数检测
        foreach ($typeConfig as $key => $value) {
            if (in_array($key, ['id', 'name', 'sign', 'type', 'froze_type'])) {
                continue;
            }

            if ($value == 1) {
                if (!isset($params[$key])) {
                    return "对不起, 参数{$key}没有传递!";
                }
            }
        }

        // 3. 检测金额
        $amount = abs($params['amount']);
        if ($amount == 0) {
            return true;
        }


        // 4. 关联用户是否存在
        $relatedUser = null;
        if (isset($params['related_id'])) {
            $relatedUser = User::findByCache($params['related_id']);
            if (!$relatedUser) {
                return "对不起, 无效的关联用户!";
            }
        }

        // 冻结类型 1 冻结自己金额 2 冻结退还　3 冻结给玩家　4 冻结给系统　5 中奖
        // 资金增减. 需要检测对应
        if ( $typeConfig['froze_type'] == 5) {
            if (!$relatedUser) {
                return "对不起, 必须存在关联用户!";
            }
            $relatedAccount = $relatedUser->account();
            $frozen         = $relatedAccount->frozen;
            if ($frozen < $amount) {
                return "对不起, 相关用户可用冻结金额不足!";
            }
        }

        // 保存记录
        $report = array(
            'user_id'       => $user->id,
            'top_id'        => $user->top_id,
            'parent_id'     => $user->parent_id,
            'rid'           => $user->rid,
            'username'      => $user->username,
            'is_tester'     => $user->is_tester,

            'type_sign'         => $typeConfig['sign'],
            'type_name'         => $typeConfig['name'],

            'related_id'        => isset($params['related_id']) ? $params['related_id'] : 0,
            'admin_id'          => isset($params['admin_id'])   ? $params['admin_id']   : 0,
            'room_id'           => isset($params['room_id'])    ? $params['room_id']    : 0,
            'project_id'        => isset($params['project_id']) ? $params['project_id'] : 0,
            'froze_type'        => $typeConfig['froze_type'],
            'desc'              => isset($params['desc']) ? $params['desc'] : 0,
            'day'               => date("Ymd"),
            'amount'            => $amount,

            'created_at'        => date('Y-m-d H:i:s'),
        );


        $beforeBalance      = $this->balance;
        $beforeFrozen       = $this->frozen;

        // 根据冻结类型处理
        switch($typeConfig['froze_type']) {
            case self::FROZEN_STATUS_OUT:
                if ($params['amount'] > $this->balance) {
                    return "对不起, 用户余额不足!";
                }
                $ret = $this->frozen($amount);
                break;
            case self::FROZEN_STATUS_BACK:
                $ret = $this->unFrozen($amount);
                break;
            case self::FROZEN_STATUS_TO_PLAYER:
            case self::FROZEN_STATUS_TO_SYSTEM:
                if ($params['amount'] > $this->frozen) {
                    Clog::account("error-{$user->id}-{$amount}-{$this->frozen}-冻结金额不足!");
                    return "对不起, 用户冻结金额不足!";
                }

                $ret = $this->unFrozenToPlayer($amount);
                break;
            default:
                if ($typeConfig['type'] == 1) {
                    $ret = $this->add($params['amount']);
                } else {
                    if ($params['amount'] > $this->balance) {
                        return "对不起, 用户余额不足!";
                    }
                    $ret = $this->cost($params['amount']);
                }
        }

        if ($ret !== true) {
            return "对不起, 账户异常!";
        }

        $balance    = $this->balance;
        $frozen     = $this->frozen;

        $report['before_balance']   = $beforeBalance;
        $report['balance']          = $balance;
        $report['frozen_balance']   = $frozen;
        $report['before_frozen_balance']    = $beforeFrozen;

        $change['updated_at']       = date('Y-m-d H:i:s');

        $this->saveData($report);

        if($beforeBalance != $balance){
            event(new \App\Events\Broadcast\User($this->user_id, "fundChange", ['balance' => number2($this->balance)]));
        }

        return true;
    }

    public function triggerSave() {
        if ($this->changes) {
            $ret = db()->table('account_change_report')->insert( $this->changes );
            info($this->changes);
            if(!$ret) {
                return false;
            }

            $this->changes = [];
        }
    }

    public function saveData($report) {
        if ($this->mode == self::MODE_CHANGE_AFTER) {
            $this->changes[] = $report;
        } else {
            $ret = db()->table('account_change_report')->insert( $report );
            if(!$ret) {
                return false;
            }

        }

        return true;
    }

    // 资金增加
    public function add($money)
    {
        $updated_at = date("Y-m-d H:i:s", time());

        $sql = "update `user_accounts` set `balance`=`balance`+'{$money}' , `updated_at`='$updated_at'  where `user_id` ='{$this->user_id}'";

        $ret= db()->update($sql) > 0 ;

        if($ret){
            $this->balance =$this->balance + $money;
        }
        return $ret;
    }

    // 消耗资金
    public function cost($money)
    {
        $updated_at = date("Y-m-d H:i:s", time());

        $ret= db()->update("update `user_accounts` set `balance`=`balance`-'{$money}' , `updated_at`='$updated_at'  where `user_id` ='{$this->user_id}' and `balance`>='{$money}'") > 0 ;

        if($ret){
            $this->balance =$this->balance - $money;
        }
        return $ret;
    }

    // 冻结资金
    public function frozen($money)
    {
        $updated_at = date("Y-m-d H:i:s", time());

        $ret= db()->update("update `user_accounts` set `balance`=`balance`-'{$money}', `frozen`=`frozen`+ '{$money}'  , `updated_at`='$updated_at' where `user_id` ='{$this->user_id}' and `balance`>='{$money}'") > 0;

        if($ret){
            $this->balance  = $this->balance - $money;
            $this->frozen   = $this->frozen + $money;
        }
        return $ret;
    }

    // 解冻
    public function unFrozen($money)
    {
        $updated_at = date("Y-m-d H:i:s", time());

        $ret= db()->update("update `user_accounts` set `balance`=`balance`+'{$money}', `frozen`=`frozen`- '{$money}' , `updated_at`='$updated_at'  where `user_id` ='{$this->user_id}'") > 0;

        if($ret){
            $this->balance  = $this->balance + $money;
            $this->frozen   = $this->frozen - $money;
        }
        return $ret;
    }

    // 解冻 - 到其他玩家头上
    public function unFrozenToPlayer($money)
    {
        $updated_at = date("Y-m-d H:i:s", time());

        $ret= db()->update("update `user_accounts` set  `frozen`=`frozen`- '{$money}' , `updated_at`='$updated_at'  where `user_id` ='{$this->user_id}'") > 0;

        if($ret){
            $this->frozen   = $this->frozen - $money;
        }
        return $ret;
    }

    static function triggerEvent($userId, $event, $data) {
        event(new \App\Events\Broadcast\User($userId,$event, $data));
    }
}

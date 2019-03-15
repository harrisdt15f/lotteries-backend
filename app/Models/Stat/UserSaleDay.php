<?php

namespace App\Models\Stat;


use App\Models\Base;
use Illuminate\Support\Facades\DB;

class UserSaleDay extends Base {
    protected $table = 'user_sale_day';


    /**
     * 获取列表
     * @param $c
     * @param int $pageSize
     * @return array
     */
    static function getList($c, $pageSize = 15) {
        $query = self::orderBy('id', 'desc');

        // 用户名
        if(isset($c['username'])) {
            $query->where('username', $c['username']);
        }

        // 日期
        if(isset($c['parent_id'])) {
            $query->where('parent_id', $c['parent_id']);
        }

        // 日期 开始
        if(isset($c['start_day'])) {
            $query->where('day', ">=", $c['start_day']);
        }

        // 日期 结束
        if(isset($c['end_day'])) {
            $query->where('day', "<=", $c['end_day']);
        }

        $currentPage    = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $menus  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    /**
     * 初始化2天数据
     * @param $user
     * @return bool
     */
    static function initData($user) {
        $data = [
            [
                'user_id'   => $user->id,
                'username'  => $user->username,
                'top_id'    => $user->top_id,
                'parent_id' => $user->parent_id,
                'rid'       => $user->rid,
                'day'       => date("Ymd"),
            ],
            [
                'user_id'   => $user->id,
                'username'  => $user->username,
                'top_id'    => $user->top_id,
                'parent_id' => $user->parent_id,
                'rid'       => $user->rid,
                'day'       => date("Ymd", time() + 86400),
            ],
        ];

        return DB::table('stat_user_day')->insert($data);
    }

    // 统计改变
    public function change($lotteryId, $methodId, $changes, $date)
    {
        $changes = array_intersect_key($changes, array_flip(self::$filters));
        if(empty($changes)) {
            return true;
        }

        $_team  = array_flip(self::$team_filters);

        $selfUpdate = '';
        $teamUpdate = '';
        $selfAdd    = '';
        $teamAdd    = '';
        foreach($changes as $field => $v) {
            $selfUpdate .= $selfAdd . "`{$field}` = `{$field}` + {$v}";
            $add = ',';

            //是 否包含团队
            if(isset($_team["team_{$field}"])){
                $teamUpdate .= $teamAdd."`team_{$field}` = `team_{$field}` + {$v}";
                $teamAdd = ',';
            }
        }

        $date_day   = date("Ymd", strtotime($date));

        // 更新自身量
        if($selfUpdate) {
            $ret = db()->update("update `user_sale` set {$selfUpdate}  where `user_id` = '{$this->userid}' and `lottery_id` = '{$lotteryId}' and `method_id` = '{$methodId}'");
            if(!$ret) {
                return true;
            }

            $ret = db()->update("update `user_sale_day` set {$selfUpdate} where `user_id` ='{$this->userid}'  and `lottery_id` = '{$lotteryId}' and `method_id` = '{$methodId}' and `day`='{$date_day}'");
            if(!$ret){
                return true;
            }
        }

        // 更新团队量
        $filter = array_filter(explode('|', $this->rid));
        if(count($filter) > 0) {
            $ids = implode("','", $filter);
            if($teamUpdate) {
                $ret = db()->update("update `user_stat` set {$teamUpdate} where `user_id` in ('{$ids}') and `lottery_id` = '{$lotteryId}' and `method_id` = '{$methodId}'");
                if(!$ret){
                    return true;
                }
                $ret = db()->update("update `user_stat_day` set {$teamUpdate} where `user_id` in ('{$ids}') and `day`='{$date_day}' and `lottery_id` = '{$lotteryId}' and `method_id` = '{$methodId}'");
                if(!$ret) {
                    return true;
                }
            }
        }

        return true;
    }
}

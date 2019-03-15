<?php

namespace App\Models\Stat;


use App\Models\Base;
use App\Models\Player\Player;
use Illuminate\Support\Facades\DB;

class UserStatDay extends Base
{
    protected $table = 'user_stat_day';

    /**
     * 获取列表
     * @param $c
     * @param int $pageSize
     * @return array
     */
    static function getList($c, $pageSize = 15)
    {
        $query = self::orderBy('id', 'desc');

        // 用户名
        if (isset($c['username'])) {
            $query->where('username', $c['username']);
        }

        // 日期
        if (isset($c['parent_id'])) {
            $query->where('parent_id', $c['parent_id']);
        }

        // 日期 开始
        if (isset($c['start_day'])) {
            $query->where('day', ">=", $c['start_day']);
        }

        // 日期 结束
        if (isset($c['end_day'])) {
            $query->where('day', "<=", $c['end_day']);
        }

        $currentPage = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;
        $offset = ($currentPage - 1) * $pageSize;

        $total = $query->count();
        $menus = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    /**
     * 初始化2天数据
     * @param $user
     * @param $time
     * @return mixed
     */
    static function initData()
    {

        $lastItem = self::orderBy('id', 'DESC')->first();

        if (empty($lastItem)) {
            $startTime  = time();
        } else {
            $startTime  = strtotime($lastItem->day) + 86400;
        }

        $endTime = time() + 86400 * 2;
        $daySet = self::getDaySet($startTime, $endTime);

        $totalPlayer = Player::where('status', 1)->count();


        $pageSize = 300;
        $totalPage = ceil($totalPlayer / $pageSize);

        $allPlayer = 0;
        $i = 1;

        do {
            $offset = $pageSize * ($i - 1);

            $res    = Player::where('status', 1)->skip($offset)->take($pageSize)->get();;

            $data   = [];
            foreach ($res as $user) {
                foreach ($daySet as $day) {
                    $data[] = [
                        'user_id'   => $user->id,
                        'top_id'    => $user->top_id,
                        'parent_id' => $user->parent_id,
                        'rid'       => $user->rid,
                        'username'  => $user->username,
                        'day'       => $day,
                    ];
                }
            }

            $allPlayer += count($data);
            self::insert($data);
            $i++;
        } while ($totalPage > $i);

        $totalDay = count($daySet);
        info("统计-Stat-Init:一共用户{$totalPlayer}个, 日期{$totalDay}天, 生成记录{$allPlayer}个!");
        return true;
    }

    /**
     * 初始化2天数据
     * @param $user
     * @param $time
     * @return mixed
     */
    static function initUserStatData($user) {

        $startTime  = time();
        $endTime    = time() + 86400 * 1;
        $daySet     = self::getDaySet($startTime, $endTime);

        $data = [];
        foreach ($daySet as $day) {
            $data[] = [
                'user_id'   => $user->id,
                'top_id'    => $user->top_id,
                'parent_id' => $user->parent_id,
                'rid'       => $user->rid,
                'username'  => $user->username,
                'day'       => $day,
            ];
        }

        self::insert($data);
        return true;
    }


    /**
     * 获取时间
     * @param $startTime
     * @param $endTime
     * @return array
     */
    static function getDaySet($startTime, $endTime) {
        $daySet = [];

        while ($startTime <= $endTime) {
            $daySet[] = date("Ymd", $startTime);
            $startTime += 86400;
        }

        return $daySet;
    }

    /**
     * 数据变更写入
     * @param $changes
     * @param $date
     * @return bool
     */
    public function change($changes, $date)
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
            $ret = db()->update("update `user_stat` set {$selfUpdate}  where `user_id` ='{$this->userid}'");
            if(!$ret) {
                return true;
            }

            $ret = db()->update("update `user_stat_day` set {$selfUpdate} where `user_id` ='{$this->userid}'  and `day`='{$date_day}'");
            if(!$ret){
                return true;
            }
        }

        // 更新团队量
        $filter = array_filter(explode('|', $this->rid));
        if(count($filter) > 0) {
            $ids = implode("','", $filter);
            if($teamUpdate) {
                $ret = db()->update("update `user_stat` set {$teamUpdate} where `user_id` in ('{$ids}')");
                if(!$ret){
                    return true;
                }
                $ret = db()->update("update `user_stat_day` set {$teamUpdate} where `user_id` in ('{$ids}') and `day`='{$date_day}'");
                if(!$ret) {
                    return true;
                }
            }
        }

        return true;
    }
}

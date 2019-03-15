<?php

namespace App\Models\Game;


use App\Models\Admin\AdminMenu;

class Issue extends BaseGame {
    protected $table = 'issues';


    /**
     * 获取列表
     * @param $c
     * @param int $pageSize
     * @return array
     */
    static function getList($c, $pageSize = 20) {
        $query = self::orderBy('id', 'desc');

        // 彩种标识
        if(isset($c['lottery_id']) && $c['lottery_id'] && $c['lottery_id'] != "all") {
            $query->where('lottery_id', $c['lottery_id']);
        }

        // 日期
        if(isset($c['issue_no']) && $c['issue_no']) {
            $query->where('issue', '=', $c['issue_no']);
        }

        // 日期 开始
        if(isset($c['start_time']) && $c['start_time']) {
            $query->where('start_time', ">=", $c['start_time']);
        }

        // 日期 结束
        if(isset($c['end_time']) && $c['end_time']) {
            $query->where('start_time', "<=", $c['end_time']);
        }

        $currentPage    = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $menus  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    // 开奖
    public function open($code) {
        // 修改录好状态
        $this->official_code    = $code;
        $this->status_encode    = 1;
        $this->encode_time      = time();
        $this->save();

        $preLostMethod = Lottery::getPreLoseMethod($this->lottery_id, $code);

        // 开奖
        $projects = Project::where('lottery_id', $this->lottery_id)->where('issue', $this->issue)->get();

        foreach ($projects as $project) {
            $result = $project->open($code);
        }
        return true;
    }

    // 获取用户
    public static function getGenIssueOptions() {
        $lotteries  = Lottery::getAllLotteries();
        $issueRule  = IssueRule::distinct('lottery_id')->get();
        $data = [];
        foreach ($issueRule as $item) {
            $lottery = $lotteries[$item->lottery_id];
            $lastIssue = Issue::where('lottery_id', $item->lottery_id)->orderBy('id', 'desc')->first();
            if (!$lastIssue) {
                $startDay = date('Y-m-d');
            } else {
                $startDay = date('Y-m-d', $lastIssue->begin_time + 86400);
            }

            $data[$item->lottery_id] = [
                'name'          => $lottery->cn_name,
                'issue_type'    => $lottery->issue_type,
                'start_day'     => $startDay,
                'last_issue'    => $lastIssue
            ];
        }
        return $data;
    }

    // 号码录入
    public function encode($code, $adminId = -1) {

        //  检查号码格式
        $lottery = Lottery::getLottery($this->lottery_id);
        if ($lottery->checkInputCodeFormat($code) ) {
            return "录入的号码,不符合格式!";
        }

        //
        $this->official_code    = $code;
        $this->encode_time      = time();
        $this->encode_id        = $adminId;
        $this->encode_username  = self::getEncodeUsername($adminId);
        $this->status_encode    = 1;
        $this->save();

        // 开奖

        // 记录日志
    }

    /**
     * 录号人姓名
     * @param $adminId
     * @return string
     */
    static function getEncodeUsername($adminId) {
        if ($adminId == -1) {
            return "机器随机";
        } else if ($adminId == -2) {
            return "开奖中心";
        } else {
            $adminUser = AdminMenu::find($adminId);
            return $adminUser ? $adminUser->username : "未知";
        }
    }

    /** =============== 功能函数 ============= */

    /**
     * 获取当前的奖期
     * @param $lotteryId
     * @return mixed
     */
    static function getCurrentIssue($lotteryId) {
        return self::where('lottery_id', $lotteryId)->where('end_time', '>', time())->orderBy('id', 'ASC')->first();
    }

    /**
     * 获取当前的奖期
     * @param $lotteryId
     * @return mixed
     */
    static function getNeedOpenIssue($lotteryId) {
        return self::where('lottery_id', $lotteryId)->where('end_time', '<', time())->where("status_encode", 0)->orderBy('id', 'asc')->get();
    }

    /**
     * 获取所有的奖期
     * @param $issueArr
     */
    public function getIssues($issueArr) {
        if (is_array($issueArr)) {
             self::whereIn("issue", $issueArr)->get();
        }
    }

    /**
     * 获取所有可投奖期
     * @param $lotteryId
     * @param int $count
     * @return mixed
     */
    static function getCanBetIssue ($lotteryId, $count = 50) {
        $time = time();
        return self::where("lottery_id", $lotteryId)->where("end_time", ">", $time)->orderBy("id", "ASC")->skip(0)->take($count)->get();
    }

    /**
     * 获取所有历史奖期
     * @param $lotteryId
     * @param int $count
     * @return mixed
     */
    static function getHistoryIssue ($lotteryId, $count = 50) {
        $time = time();
        return self::where("lottery_id", $lotteryId)->where("start_time", "<=", $time)->orderBy("id", "ASC")->skip(0)->take($count)->get();
    }
}

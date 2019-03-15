<?php

namespace App\Http\Controllers\Api;

use App\Lib\Help;
use App\Models\Game\Lottery;
use App\Models\Game\Issue;
use App\Models\Player\Player;

class ApiGameController extends ApiBaseController
{

    /**
     * 彩种列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function lotteryList() {
        $user   = auth()->guard('api')->user();
        if (!$user) {
            return Help::returnApiJson('对不起, 用户未登录!', 0, ['reason_code' => 999]);
        }

        $lotteries = Lottery::getAllLotteries(true);

        $data = [];
        foreach ($lotteries as $lottery) {
            $data[] = [
                'id'                => $lottery->en_name,
                'name'              => $lottery->cn_name,
                'min_times'         => $lottery->min_times,
                'max_times'         => $lottery->max_times,
                'valid_modes'       => $lottery->valid_modes,
                'min_prize_group'   => $lottery->min_prize_group,
                'max_prize_group'   => $lottery->max_prize_group,
                'max_trace_number'  => $lottery->max_trace_number,
                'day_issue'         => $lottery->day_issue,
            ];
        }
        return Help::returnApiJson('获取游戏列表成功!', 1, $data);
    }

    /**
     * 获取玩法列表
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function methodList() {
        $user   = auth()->guard('api')->user();
        if (!$user) {
            return Help::returnApiJson('对不起, 用户未登录!', 0, ['reason_code' => 999]);
        }

        $lotteryId      = request('lottery_id');
        $lotteries      = Lottery::getAllLotteryByCache(true);

        if (!array_key_exists($lotteryId, $lotteries)) {
            return Help::returnApiJson('对不起, 无效的彩种!', 0);
        }

        $lottery = $lotteries[$lotteryId];

        $data = [];
        foreach ($lottery->methods as $method) {
            $data[] = [
                'group' => $method['method_group'],
                'id'    => $method['method_id'],
                'name'  => $method['method_name'],
            ];
        }
        return Help::returnApiJson('获取玩法列表成功!', 1, $data);
    }

    /**
     * 投注
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function bet() {
//        $user   = auth()->guard('api')->user();
//        if (!$user) {
//            return Help::returnApiJson('对不起, 用户未登录!', 0, ['reason_code' => 999]);
//        }

        $user           = Player::find(1);

        $lotteries      = Lottery::getAllLotteries(true);
        $lotteryId      = request('lottery_id');

        if (!array_key_exists($lotteryId, $lotteries)) {
            return Help::returnApiJson('对不起, 无效的彩种!', 0);
        }

        $lottery    = $lotteries[$lotteryId];

        $params     = request()->all();

        $from       = isset($params['from']) ? isset($params['from']) : "web";

        $ret = $user->bet($lottery, $params, $from);

        return view('frontend/theme_moon/home')->with('lotteries',  $lotteries);
    }

    /**
     * 获取彩种列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function issueList() {
        $user   = auth()->guard('api')->user();
        if (!$user) {
            return Help::returnApiJson('对不起, 用户未登录!', 0, ['reason_code' => 999]);
        }

        $params     = request()->all();
        $lotteryId  = $params["lottery_id"];
        if (!$lotteryId) {
            return Help::returnApiJson('对不起, 无效的彩种ID!', 0);
        }

        $lotteries  = Lottery::getAllLotteries(true);

        $lotteryId    = request('lottery_id');
        if (!array_key_exists($lotteryId, $lotteries)) {
            return Help::returnApiJson('对不起, 无效的彩种!', 0);
        }

        $issueList = Issue::getCanBetIssue($lotteryId);

        $issueData = [];
        foreach ($issueList as $issue) {
            $issueData[] = [
                'lottery_id'            => $issue->lottery_id,
                'issue'                 => $issue->issue,
                'start_time'            => date("Y-m-d H:i:s", $issue->begin_time),
                'end_time'              => date("Y-m-d H:i:s", $issue->end_time),
                'official_open_time'    => date("Y-m-d H:i:s", $issue->official_open_time),
            ];
        }

        return Help::returnApiJson('获取游戏奖期成功!', 1, $issueData);
    }

    public function projectList() {
        $lotteries = Lottery::getAllLotteries(true);
        return Help::returnApiJson('获取游戏订单成功!', 1, $lotteries);
    }

    public function traceList() {
        $lotteries = Lottery::getAllLotteries(true);
        return Help::returnApiJson('获取游戏追号成功!', 1, $lotteries);
    }

    public function trendList() {
        $lotteries = Lottery::getAllLotteries(true);
        return Help::returnApiJson('获取成功!', 1, $lotteries);
    }
}

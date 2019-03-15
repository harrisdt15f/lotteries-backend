<?php

namespace App\Models\Game;

use Illuminate\Support\Facades\DB;

class Project extends BaseGame
{
    protected $table = 'projects';

    // 获取列表
    static function getList($condition, $pageSize = 20) {
        $query = self::orderBy('id', 'desc');
        if (isset($condition['en_name'])) {
            $query->where('en_name', '=', $condition['en_name']);
        }

        $currentPage    = isset($condition['pageIndex']) ? intval($condition['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $menus  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    /**
     * @param $user
     * @param $lottery
     * @param $currentIssue
     * @param $data
     * @param $traceData
     * @param int $from
     * @return array
     */
    static function addProject($user, $lottery, $currentIssue, $data, $traceData, $from = 1) {
        $returnData     = [];
        $traceMainData  = [];
        foreach ($data as $_item) {
            $projectData = [
                'sign'              => $user->sign,
                'user_id'           => $user->id,
                'username'          => $user->username,
                'top_id'            => $user->top_id,
                'rid'               => $user->rid,
                'parent_id'         => $user->parent_id,
                'is_tester'         => $user->is_tester,
                'series_id'         => $lottery->series_id,
                'lottery_id'        => $lottery->en_name,
                'method_id'         => $_item["method_id"],
                'method_name'       => $_item["method_name"],
                'user_prize_group'  => $user->prize_group,
                'bet_prize_group'   => $_item['prize_group'],
                'mode'              => $_item['mode'],
                'times'             => $_item['times'],
                'single_price'      => $_item['price'],
                'total_price'       => $_item['total_price'],
                'bet_number'        => $_item['code'],
                'issue'             => $currentIssue->issue,
                'ip'                => real_ip(),
                'proxy_ip'          => real_ip(),

                'bet_from'          => $from,
                'time_bought'       => time(),
            ];

            if ($traceData) {
                $traceMainData[] = [
                    'sign'              =>  $user->sign,
                    'user_id'           =>  $user->id,
                    'username'          =>  $user->username,
                    'top_id'            =>  $user->top_id,
                    'rid'               =>  $user->rid,
                    'parent_id'         =>  $user->parent_id,
                    'is_tester'         =>  $user->is_tester,
                    'series_id'         => $lottery->series_id,
                    'lottery_id'        =>  $lottery->en_name,
                    'method_id'         =>  $_item["method_id"],
                    'method_name'       =>  $_item["method_name"],
                    'bet_number'        =>  $_item['code'],

                    'user_prize_group'  =>  $user->prize_group,
                    'bet_prize_group'   =>  $_item['prize_group'],
                    'mode'              =>  $_item['mode'],
                    'times'             =>  $_item['times'],
                    'single_price'      =>  $_item['price'],
                    'total_price'       =>  $_item['total_price'],

                    'total_issues'      =>  count($traceData),
                    'finished_issues'   =>  0,
                    'canceled_issues'   =>  0,

                    'start_issue'       =>  $traceData[1],
                    'now_issue'         =>  '',
                    'end_issue'         =>  $traceData[count($traceData) - 1],
                    'stoped_issue'      =>  "",
                    'issue_process'     =>  json_encode($traceData),

                    'add_time'          =>  time(),
                    'stop_time'         =>  0,
                    'cancel_time'       =>  0,

                    'ip'                =>  real_ip(),
                    'proxy_ip'          =>  real_ip(),

                    'bet_from'          =>  $from,
                ];
            }

            $id = DB::table('projects')->insertGetId($projectData);
            $returnData['project'][] = [
                'id'            => $id,
                'cost'          => $_item['total_price'],
                'lottery_id'    => $lottery->en_name,
                'method_id'     => $_item['method_id'],
            ];
        }



        // 保存追号主
        if ($traceMainData) {
            DB::table('traces')->insert($traceMainData);
        }

        // 保存追号
        $traceListData = [];
        foreach ($traceData as $issue => $mark) {
            foreach ($data as $_item) {
                $traceListData[] = [
                    'sign'              => $user->sign,
                    'user_id'           => $user->id,
                    'username'          => $user->username,
                    'top_id'            => $user->top_id,
                    'rid'               => $user->rid,
                    'parent_id'         => $user->parent_id,
                    'is_tester'         => $user->is_tester,
                    'series_id'         => $lottery->series_id,
                    'lottery_id'        => $lottery->en_name,
                    'method_id'         => $_item["method_id"],
                    'method_name'       => $_item["method_name"],
                    'issue'             => $issue,
                    'bet_number'        => $_item['code'],
                    'mode'              => $_item['mode'],
                    'times'             => $_item['times'],
                    'single_price'      => $_item['price'],
                    'total_price'       => $_item['total_price'],

                    'user_prize_group'  => $user->prize_group,
                    'bet_prize_group'   => $_item['prize_group'],
                    'bet_number'        => $_item['code'],
                    'ip'                => real_ip(),
                    'proxy_ip'          => real_ip(),

                    'bet_from'          => $from,
                ];
            }
        }

        DB::table('trance_list')->insert($traceListData);

        return $returnData;
    }

    // 开奖
    public function open($openCode) {
        $project = $this;
        $lottery = Lottery::getLottery($project->lottery_id);
        $oMethod = Lottery::getMethodObjectByCache($project->series_id, $project->method_id);

        $openCodeArr    = $lottery->formatOpenCode($openCode);
        $result         = $oMethod->assert($project->bet_number, $openCodeArr);

        $totalBonus     = 0;
        if ($result) {
            foreach ($result as $level => $count) {
                $levelConfig = $oMethod->levels;
                if (isset($levelConfig[$level])) {
                    $prize = $levelConfig[$level]['prize'];
                    $bonus = 2000 * $project->bet_prize_group / $prize;
                    $bonus = $bonus * $count * $project->times * $project->mode;
                    if ($project->single_price == 1) {
                        $bonus = $bonus / 2;
                    }
                    $totalBonus += $bonus;
                }
            }
        }

        $project->status_count  = 1;
        $project->time_count    = time();

        if ($totalBonus > 0) {
            $project->status_prize  = 1;
            $project->is_win        = 1;
            $project->bonus         = $totalBonus;
            $project->time_prize    = time();
        }

        $project->save();

        return [
            'user_id'       => $project->user_id,
            'project_id'    => $project->id,
            'lottery_id'    => $project->lottery_id,
            'method_id'     => $project->method_id,
            'issue'         => $project->issue,
            'amount'        => $totalBonus,
        ];
    }
}

<?php
namespace App\Http\Controllers\Admin\Game;

use App\Lib\Help;
use App\Models\Admin\AdminMenu;
use App\Models\Game\Issue;
use App\Http\Controllers\Admin\Controller;
use App\Models\Game\Lottery;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $c      = $request->all();
        $data   = Issue::getList($c);

        // 顶部按钮
        $buttonConfig = [
            ['route' => "issueGen", 'params' => []]
        ];

        $buttons = AdminMenu::buildButtons($buttonConfig);

        $lotteries = Lottery::getOptions();
        return Help::adminView("game/issue/list")->with(['data' => $data, 'buttons' => $buttons, 'lotteries' => $lotteries, 'c' => $c]);
    }

    // 详情
    public function detail() {

    }

    // 生成
    public function gen() {

        if (\Request::isMethod('post')) {
            $params     = \Request::all();
            $lotteryId  = $params['lottery_id'];

            $lottery    = Lottery::where("en_name", $lotteryId)->first();

            if (!$lottery) {
                return Help::returnJson(__('issue.gen.error.lottery_not_exit'), 0);
            }

            // 生成
            $res = $lottery->genIssue($params['start_time'], $params['end_time'], $params['start_issue']);

            if(!is_array($res) || count($res) == 0) {
                return Help::returnJson($res, 0);
            } else {

                // 成功一部分
                $genRes = true;
                foreach ($res as $day => $_r) {
                    if ($_r !== true) {
                        $genRes = false;
                    }
                }

                if (!$genRes) {
                    return Help::returnJson("您好, 奖期部分完成!", 0, ['res' => $res]);
                }
            }

            return Help::returnJson(__('issue.add.success'), 1, ['url' => route("issueList")]);
        }

        $lotteries = Issue::getGenIssueOptions();

        return Help::adminView("game/issue/gen")->with(['lotteries' => $lotteries]);
    }

    // 录入号码
    public function encode($id) {

    }

    // 录入号码
    public function calculated($id) {

    }

    // 录入号码
    public function prize($id) {

    }

    // 录入号码
    public function point($id) {

    }

    // 录入号码
    public function trace($id) {

    }
}

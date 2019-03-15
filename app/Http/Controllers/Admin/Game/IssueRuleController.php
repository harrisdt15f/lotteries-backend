<?php
namespace App\Http\Controllers\Admin\Game;

use App\Lib\Help;
use App\Models\Admin\AdminMenu;
use App\Models\Game\Issue;
use App\Http\Controllers\Admin\Controller;
use App\Models\Game\IssueRule;
use App\Models\Game\Lottery;
use Illuminate\Http\Request;

class IssueRuleController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $c      = $request->all();
        $data   = IssueRule::getList($c);

        // 顶部按钮
        $buttonConfig = [
            ['route' => "issueRuleAdd", 'params' => []]
        ];

        $buttons = AdminMenu::buildButtons($buttonConfig);

        $lotteries = Lottery::getOptions();
        return Help::adminView("game/issue_rule/list")->with(['data' => $data, 'buttons' => $buttons, 'lotteries' => $lotteries, 'c' => $c]);
    }

    // 添加
    public function add($id = 0) {
        if ($id) {
            $model   = IssueRule::find($id);
            if (!$model) {
                return Help::AdminErrorView("无效的ID", 2);
            }
        } else {
            $model = new IssueRule();
        }

        if (\Request::isMethod('post')) {
            $res = $model->saveItem();
            if(true !== $res) {
                return Help::returnJson($res, 0);
            }

            return Help::returnJson(__('issue_rule.add.success'), 1, ['url' => route("issueRuleList")]);
        }

        $lotteries = Lottery::getOptions();

        return Help::adminView("game/issue_rule/add")->with([
            'model'             => $model,
            'lotteries'         => $lotteries
        ]);
    }
}

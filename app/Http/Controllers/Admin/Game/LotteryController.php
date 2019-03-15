<?php
namespace App\Http\Controllers\Admin\Game;

use App\Http\Controllers\Admin\Controller;
use App\Lib\Help;
use App\Models\Admin\AdminMenu;
use App\Models\Game\Lottery;
use Illuminate\Http\Request;

class LotteryController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data   = Lottery::getList($request->all());

        // 顶部按钮
        $buttonConfig = [
            ['route' => "lotteryAdd", 'params' => []],
            ['route' => "lotteryFlush", 'params' => []]
        ];
        $buttons = AdminMenu::buildButtons($buttonConfig);

        $lotteries  = Lottery::getOptions();
        return Help::adminView("game/lottery/list")->with(['data' => $data, 'buttons' => $buttons, 'lotteries' => $lotteries]);
    }

    // 添加
    public function add($id = 0) {
        if ($id) {
            $model   = Lottery::find($id);
            if (!$model) {
                return Help::AdminErrorView("无效的ID", 2);
            }
        } else {
            $model = new Lottery();
        }

        if (\Request::isMethod('post')) {
            $res = $model->saveItem();
            if(true !== $res) {
                return Help::returnJson($res, 0);
            }

            return Help::returnJson(__('lottery.add.success'), 1, ['url' => route("lotteryList")]);
        }

        $series = config("game.main.series");

        return Help::adminView("game/lottery/add")->with([
            'model'         => $model,
            'series'        => $series
        ]);
    }

    /**
     * 状态修改
     * @param $id
     * @return mixed
     */
    public function status($id) {
        $model   = Lottery::find($id);
        if (!$model) {
            return Help::returnJson(__('lottery.status.item_not_exit'), 0);
        }

        $model->status = $model->status  == 1 ? 0 : 1;
        $model->save();

        return Help::returnJson(__('lottery.status.success'), 1);
    }

    // 刷新游戏缓存
    public function flush() {
        Lottery::flushCache('lottery');
        return Help::returnJson(__('lottery.flush.success'), 1);
    }
}

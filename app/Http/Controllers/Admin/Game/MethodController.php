<?php
namespace App\Http\Controllers\Admin\Game;

use App\Http\Controllers\Admin\Controller;
use App\Lib\Help;
use App\Models\Game\Lottery;
use App\Models\Game\Method;
use Illuminate\Http\Request;

class MethodController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $c      = $request->all();
        $data   = Method::getList($c);

        $config     = config("game.method");
        $lotteries  = Lottery::getOptions();
        return Help::adminView("game/method/list")->with(['data' => $data, 'config' => $config, 'lotteries' => $lotteries, 'c' => $c]);
    }

    /**
     * 状态修改
     * @param $id
     * @return mixed
     */
    public function status($id) {
        $model   = Method::find($id);
        if (!$model) {
            return Help::returnJson(__('lottery.status.item_not_exit'), 0);
        }

        $model->status = $model->status  == 1 ? 0 : 1;
        $model->save();

        return Help::returnJson(__('lottery.status.success'), 1);
    }

    /**
     * 状态修改
     * @param $id
     * @return mixed
     */
    public function sort($id) {
        $model   = Lottery::find($id);
        if (!$model) {
            return Help::returnJson(__('lottery.status.item_not_exit'), 0);
        }

        $model->status = $model->status  == 1 ? 0 : 1;
        $model->save();

        return Help::returnJson(__('lottery.status.success'), 1);
    }
}

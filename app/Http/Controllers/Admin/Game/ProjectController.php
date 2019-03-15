<?php
namespace App\Http\Controllers\Admin\Game;

use App\Http\Controllers\Admin\Controller;
use App\Lib\Help;
use App\Models\Game\Lottery;
use App\Models\Game\Method;
use App\Models\Game\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // 列表
    public function index(Request $request)
    {
        $data       = Project::getList($request->all());
        $lotteries  = Lottery::getOptions();

        return Help::adminView("game/project/list")->with(['data' => $data, 'lotteries' => $lotteries]);
    }

    /**
     * 详情
     * @param $id
     * @return mixed
     */
    public function detail($id) {
        $model   = Project::find($id);
        if (!$model) {
            return Help::returnJson(__('lottery.status.item_not_exit'), 0);
        }

        $model->status = $model->status  == 1 ? 0 : 1;
        $model->save();

        return Help::returnJson(__('lottery.status.success'), 1);
    }

    /**
     * 撤单
     * @param $id
     * @return mixed
     */
    public function cancel($id) {
        $model   = Project::find($id);
        if (!$model) {
            return Help::returnJson(__('lottery.status.item_not_exit'), 0);
        }

        $model->status = $model->status  == 1 ? 0 : 1;
        $model->save();

        return Help::returnJson(__('lottery.status.success'), 1);
    }
}

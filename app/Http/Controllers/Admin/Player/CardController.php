<?php
namespace App\Http\Controllers\Admin\Player;

use App\Lib\Help;
use App\Models\Admin\AdminMenu;
use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\Province;
use App\Models\Player\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $c      = $request->all();
        $data   = Card::getList($c);

        // 顶部按钮
        $buttonConfig = [
            ['route' => "playerCardAdd", 'params' => []]
        ];

        $buttons = AdminMenu::buildButtons($buttonConfig);

        $banks  = config("web.banks");
        return Help::adminView("player/player_cards/list")->with(['data' => $data, 'buttons' => $buttons, 'banks' => $banks, 'c' => $c]);
    }

    public function add($id = 0) {
        if ($id) {
            $model  = Card::find($id);
            if (!$model) {
                return Help::AdminErrorView("无效的ID", 2);
            }
        } else {
            $model = new Card();
        }

        if (\Request::isMethod('post')) {
            $res = $model->saveItem();
            if(true !== $res) {
                return Help::returnJson($res, 0);
            }

            return Help::returnJson(__('card.add.success'), 1, ['url' => route("playerCardList")]);
        }

        $banks      = config("web.banks");
        $province   = Province::getProvince();
        return Help::adminView("player/player_cards/add")->with([
            'model'     => $model,
            'banks'     => $banks,
            'province'  => $province,
        ]);
    }

    /**
     * 状态
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($id) {
        $model   = Card::find($id);
        if (!$model) {
            return Help::returnJson("对不起, 无效的银行卡id", 0);
        }

        $model->status = $model->status  == 1 ? 0 : 1;
        $model->save();

        return Help::returnJson("恭喜, 修改状态成功!", 1);
    }

    /**
     * 删除
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function del($id) {
        $model   = Card::find($id);
        if (!$model) {
            return Help::returnJson("对不起, 无效的银行卡id", 0);
        }

        $model->status = $model->status  == 1 ? 0 : 1;
        $model->save();

        return Help::returnJson("恭喜, 删除银行卡成功!", 1);
    }

    /**
     * 修复时间
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function fixTime($id) {
        $model   = Card::find($id);
        if (!$model) {
            return Help::returnJson("对不起, 无效的银行卡id", 0);
        }

        $model->updated_at = date("Y-m-d H:i:s", time() - 8 * 3600);
        $model->save();

        return Help::returnJson("恭喜, 修正成功!", 1);
    }
}

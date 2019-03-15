<?php
namespace App\Http\Controllers\Admin\Account;

use App\Lib\Help;
use App\Http\Controllers\Admin\Controller;
use App\Models\Account\AccountChangeType;
use App\Models\Admin\AdminMenu;
use Illuminate\Http\Request;

class AccountChangeTypeController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data   = AccountChangeType::getList($request->all());

        // 顶部按钮
        $buttonConfig = [
            ['route' => "accountChangeTypeAdd",     'params' => []],
            ['route' => "accountChangeTypeFlush",   'params' => [], 'type' => 'flush']
        ];

        $buttons    = AdminMenu::buildButtons($buttonConfig);

        return Help::adminView("account/account_change_type/list")->with(['data' => $data, 'buttons' => $buttons]);
    }

    // 添加
    public function add($id = 0) {
        if ($id) {
            $model   = AccountChangeType::find($id);
            if (!$model) {
                return Help::AdminErrorView("对不起, 无效的ID", 2);
            }
        } else {
            $model = new AccountChangeType();
        }

        if (\Request::isMethod('post')) {
            $data   = \Request::all();
            $res    = $model->saveItem($data);
            if(true !== $res) {
                return Help::returnJson($res, 0);
            }

            return Help::returnJson("恭喜, 添加帐变类型成功!", 1, ['url' => route("accountChangeTypeList")]);
        }

        $series     = config("game.main.series");
        $roomType   = config("game.main.room_type");
        $packetType = config("game.main.packet_type");
        $times      = config("game.room.fix_packet_times");

        return Help::adminView("account_change_type/add")->with([
            'model'         => $model,
            'roomType'      => $roomType,
            'times'         => $times,
            'packetType'    => $packetType,
            'series'        => $series
        ]);
    }

    /**
     * 刷新缓存
     * @return \Illuminate\Http\JsonResponse
     */
    public function flush() {
        AccountChangeType::flushCache('account_change_type');
        return Help::returnJson("恭喜, 刷新帐变类型缓存成功!", 1, ['url' => route("accountChangeTypeList")]);
    }

}

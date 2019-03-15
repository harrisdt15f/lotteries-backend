<?php
namespace App\Http\Controllers\Admin\Player;

use App\Lib\Help;
use App\Models\Admin\AdminMenu;
use App\Http\Controllers\Admin\Controller;
use App\Models\Player\UserDividendConfig;
use Illuminate\Http\Request;

class UserDividendConfigController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data   = UserDividendConfig::getList($request->all());

        // 顶部按钮
        $buttonConfig = [
            ['route' => "playerDividendConfigAdd", 'params' => []]
        ];

        $buttons = AdminMenu::buildButtons($buttonConfig);

        return Help::adminView("player/dividend_config/list")->with(['data' => $data, 'buttons' => $buttons]);
    }

    public function add($id = 0) {
        if ($id) {
            $model   = UserDividendConfig::find($id);
            if (!$model) {
                return Help::AdminErrorView("无效的ID", 2);
            }
        } else {
            $model = new UserDividendConfig();
        }

        if (\Request::isMethod('post')) {
            $res = $model->saveItem();
            if(true !== $res) {
                return Help::returnJson($res, 0);
            }

            return Help::returnJson("恭喜, 添加成功", 1, ['url' => route("playerDividendConfigList")]);
        }

        return Help::adminView("player/dividend_config/add")->with([
            'model' => $model,
        ]);
    }

    public function status($id) {
        $model   = UserDividendConfig::find($id);
        if (!$model) {
            return Help::returnJson("对不起, 无效的配置ID", 0);
        }

        $model->status = $model->status  == 1 ? 0 : 1;
        $model->save();

        return Help::returnJson("对不起, 无效的配置ID", 1);
    }

    public function del($id) {
        $model   = UserDividendConfig::find($id);
        if (!$model) {
            return Help::returnJson("对不起, 无效的配置ID", 0);
        }

        $model->status = $model->status  == 1 ? 0 : 1;
        $model->save();

        return Help::returnJson("对不起, 无效的配置ID", 1);
    }
}

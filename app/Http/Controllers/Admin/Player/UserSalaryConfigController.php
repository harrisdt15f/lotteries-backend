<?php
namespace App\Http\Controllers\Admin\Player;

use App\Lib\Help;
use App\Models\Admin\AdminMenu;
use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\Province;
use App\Models\Player\UserSalaryConfig;
use Illuminate\Http\Request;

class UserSalaryConfigController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data   = UserSalaryConfig::getList($request->all());

        // 顶部按钮
        $buttonConfig = [
            ['route' => "playerSalaryConfigAdd", 'params' => []]
        ];

        $buttons    = AdminMenu::buildButtons($buttonConfig);

        $banks      = config("web.banks");
        return Help::adminView("player/salary_config/list")->with(['data' => $data, 'buttons' => $buttons, 'banks' => $banks]);
    }

    public function add($id = 0) {
        if ($id) {
            $model   = UserSalaryConfig::find($id);
            if (!$model) {
                return Help::AdminErrorView("无效的ID", 2);
            }
        } else {
            $model = new UserSalaryConfig();
        }

        if (\Request::isMethod('post')) {
            $res = $model->saveItem();
            if(true !== $res) {
                return Help::returnJson($res, 0);
            }

            return Help::returnJson("恭喜, 添加成功!", 1, ['url' => route("playerSalaryConfigList")]);
        }

        $banks      = config("web.banks");
        $province   = Province::getProvince();
        return Help::adminView("player/salary_config/add")->with([
            'model'     => $model,
            'banks'     => $banks,
            'province'  => $province,
        ]);
    }

    public function status($id) {
        $model   = UserSalaryConfig::find($id);
        if (!$model) {
            return Help::returnJson("对不起, 无效的配置ID!", 0);
        }

        $model->status = $model->status  == 1 ? 0 : 1;
        $model->save();

        return Help::returnJson("对不起, 修改状态成功!", 1);
    }

    public function del($id) {
        $model   = UserSalaryConfig::find($id);
        if (!$model) {
            return Help::returnJson("对不起, 无效的配置ID!", 0);
        }

        if ($model->status == 1) {
            return Help::returnJson("对不起, 请先禁用配置!", 0);
        }

        $model->delete();

        return Help::returnJson("对不起, 删除配置成功!", 1);
    }
}

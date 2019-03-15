<?php
namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Lib\Help;
use App\Models\Admin\AdminMenu;
use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    /**
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $data           = AdminMenu::getMenuList($request->all());
        $data['pid']    = $request->input("pid", 0);

        if ($data['pid']) {
            $related = AdminMenu::getMenuRelated($data['pid']);
        } else {
            $related = [];
        }

        // 顶部按钮
        $buttonConfig = [
            ['route' => "menuAdd", 'params' => ['pid' => $data['pid']]]
        ];
        $buttons = AdminMenu::buildButtons($buttonConfig);

        return Help::adminView("admin/adminMenu/list")->with(['data' => $data, 'related' => $related, 'buttons' => $buttons]);
    }

    public function add($pid, $id = 0) {
        if ($pid) {
            $parent = AdminMenu::find($pid);
            if (!$parent) {
                return Help::AdminErrorView("对不起, 无效的不存在的菜单!", 2);
            }
        } else {
            $parent = new AdminMenu();
        }

        // 是编辑
        if ($id) {
            $model   = AdminMenu::find($id);
            if (!$model) {
                return Help::AdminErrorView("对不起, 无效的菜单ID!", 2);
            }
        } else {
            $model = new AdminMenu();
        }

        if (\Request::isMethod('post')) {
            $data       = \request()->all();
            $adminUser  = auth()->guard('admin')->user();
            $res        = $model->saveItem($data, $parent, $adminUser);

            if ($res !== true) {
                return Help::returnJson($res, 0);
            }

            return Help::returnJson("恭喜, 保存菜单成功", 1, ['url' => route("menuList", [$pid])]);
        }

        return Help::adminView('admin/adminMenu/add')->with(['pid' => $pid, 'parent' => $parent, 'model' => $model]);
    }

    /**
     * 状态修改
     * @param $id
     * @return mixed
     */
    public function status($id) {
        $menu   = AdminMenu::find($id);
        if (!$menu) {
            return Help::returnJson(__('error.admin_menu.status.invalid_item'), 0);
        }

        $menu->status = $menu->status  == 1 ? 0 : 1;
        $menu->save();

        return Help::returnJson(__('error.admin_menu.status.success'), 1);
    }

    public function addButton() {

    }

}

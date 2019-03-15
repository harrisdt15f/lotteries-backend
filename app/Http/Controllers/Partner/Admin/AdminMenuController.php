<?php
namespace App\Http\Controllers\Partner\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Lib\Help;
use App\Models\Admin\AdminMenu;
use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    /**
     *
     * @param Request $request
     * @return $this
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
            ['route' => "menuAdd", 'params' => [$data['pid']]]
        ];
        $buttons = AdminMenu::buildButtons($buttonConfig);

        return Help::adminView("admin/adminMenu/list")->with(['data' => $data, 'related' => $related, 'buttons' => $buttons]);
    }

    public function add($pid = 0) {
        // 存在上级
        if ($pid) {
            $parent   = AdminMenu::find($pid);
            if (!$parent) {
                return Help::AdminErrorView(__('view.admin_menu.add.error.invalid_pid'), 2);
            }
        } else {
            $parent = [];
        }

        // 是编辑
        $id = \Request::input("id", 0);
        if ($id) {
            $menu   = AdminMenu::find($id);
            if (!$menu) {
                return Help::AdminErrorView(__('view.admin_menu.add.error.invalid_id'), 2);
            }
        } else {
            $menu = new AdminMenu();
        }

        if (\Request::isMethod('post')) {
            $name   = \Request::input("name");
            if (!$name) {
                return Help::returnJson(__("view.admin_menu.add.error.empty_name"), 0);
            }

            // Route
            $route   = \Request::input("route");
            if (!$route) {
                return Help::returnJson(__("view.admin_menu.add.error.empty_sign"), 0);
            }

            $_menu = AdminMenu::where('route', '=', $route)->first();
            if (!$id && $_menu) {
                return Help::returnJson(__("view.admin_menu.add.error.already_exist"), 0);
            }

            // 域
            $region  = \Request::input("region");
            if (!$region) {
                return Help::returnJson(__("view.admin_menu.add.error.empty_region"), 0);
            }

            // 类型
            $type  = \Request::input("type");
            if (!$type) {
                return Help::returnJson(__("view.admin_menu.add.error.empty_type"), 0);
            }

            // 类 可以为空
            $class  = \Request::input("css_class", '');

            $menu->parent_id    = $pid;
            $menu->route        = $route;
            $menu->name         = $name;
            $menu->region       = $region;
            $menu->type         = $type;
            $menu->css_class    = $class;
            $menu->save();

            return Help::returnJson(__("view.admin_menu.add.success"), 1, ['url' => route("menuList", [$pid])]);
        }

        return Help::adminView('admin/adminMenu/add')->with(['pid' => $pid, 'parent' => $parent, 'menu' => $menu]);
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

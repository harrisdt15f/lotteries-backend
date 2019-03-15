<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\AdminGroup;
use App\Models\Admin\AdminGroupUser;
use App\Models\Admin\AdminMenu;
use App\Models\Admin\AdminUser;
use Illuminate\Http\Request;
use App\Lib\Help;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $c      = $request->all();
        $data   = AdminUser::getAdminUserList($c);

        // 顶部按钮
        $buttonConfig = [
            ['route' => "adminUserAdd", 'params' => []]
        ];
        $buttons = AdminMenu::buildButtons($buttonConfig);

        return Help::adminView("admin/adminUser/list")->with(['data' => $data, 'buttons' => $buttons]);
    }

    /**
     * 添加或者编辑用户
     * @param int $id
     * @return mixed
     */
    public function add($id = 0) {

        $adminUser = \Auth::guard('admin')->user();
        $groupList = AdminGroup::getAdminGroupList($adminUser);
        if (!$groupList) {
            return Help::AdminErrorView("对不起, 您不能添加用户!", 2);
        }

        if ($id) {
            $user   = AdminUser::find($id);
            if (!$user) {
                return Help::AdminErrorView(__('view.admin_user.add.error.invalid_id'), 2);
            }
        } else {
            $user = new AdminUser();
        }

        // 保存
        if (\Request::isMethod('post')) {

            $res = $user->saveItem();
            if(true !== $res) {
                return Help::returnJson($res, 0);
            }

            return Help::returnJson("添加成功！", 1, ['url' => route("adminUserList", [])]);

        }

        $groupList = AdminGroup::getAdminGroupList($adminUser);
        return Help::adminView('admin/adminUser/add')->with([
            'user'          => $user,
            'groupList'     => $groupList
        ]);

    }

    public function detail() {
        return Help::adminView("admin/adminUser/detail");
    }

    public function status($id) {
        $user   = AdminUser::find($id);
        if (!$user) {
            return Help::returnJson("不存在的数据", 0);
        }

        $user->status = $user->status  == 1 ? 0 : 1;
        $user->save();

        return Help::returnJson("修改成功!!", 1);
    }

    // 密码
    public function password($id) {
        $admin     = AdminUser::find($id);

        if (\Request::isMethod('post')) {
            $mode   = \Request::get("mode");

            if (1 == $mode) {
                $password   = \Request::get("password");
                $res        = AdminUser::checkPassword($password);
                if ($res !== true) {
                    return Help::returnJson($res, 0);
                }

                $confirmPasswrod   = \Request::get("confirm_password", '');
                if ($confirmPasswrod != $password) {
                    return Help::returnJson("对不起, 密码输入不一致!", 0);
                }

                $admin->password = Hash::make($password);
                $admin->save();

                return Help::returnJson("修改登录密码成功!", 1);
            } else {
                $password   = \Request::get("fund_password");
                $res        = AdminUser::checkFundPassword($password);
                if ($res !== true) {
                    return Help::returnJson($res, 0);
                }

                $confirmPasswrod   = \Request::get("confirm_fund_password", '');
                if ($confirmPasswrod != $password) {
                    return Help::returnJson("对不起, 密码输入不一致!", 0);
                }

                $admin->fund_password = Hash::make($password);
                $admin->save();

                return Help::returnJson("恭喜, 修改资金密码成功!", 1);
            }

            return Help::returnJson("操作成功", 1);
        }

        return Help::adminView("admin/adminUser/password")->with([
            'model' => $admin,
        ]);
    }
}

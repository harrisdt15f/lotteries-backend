<?php

namespace App\Http\Controllers\Partner\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\AdminGroup;
use App\Models\Admin\AdminMenu;
use Illuminate\Http\Request;
use App\Lib\Help;

class AdminGroupController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        // 顶部按钮
        $buttonConfig = [
            ['route' => "adminGroupAdd", 'params' => []]
        ];
        $buttons    = AdminMenu::buildButtons($buttonConfig);
        $data       = AdminGroup::getAdminGroupList();
        return Help::adminView("admin/adminGroup/list")->with(['buttons' => $buttons, 'data' => $data]);
    }

    // 获取所有组
    public function json(Request $request) {
        $data       =   AdminGroup::getAdminGroupList();
        return response()->json([
            'code'      => 0,
            'msg'       => "",
            'total'     => $data['total'],
            'data'      => ['item' => $data['data']],
            "tip"       => "操作成功！"
        ]);
    }

    /**
     * 添加
     * @return $this
     */
    public function add() {
        // 是编辑
        $id = \Request::input("id", 0);
        if ($id) {
            $group   = AdminGroup::find($id);
            if (!$group) {
                return \Help::AdminErrorView(__('view.admin_group.add.error.invalid_id'), 2);
            }
        } else {
            $group = new AdminGroup();
        }
        $data['group'] = $group;

        // 上级
        $pid = \Request::input("pid", 0);
        if ($pid) {
            $parentGroup    = AdminGroup::find($pid);
            if (!$parentGroup) {
                return \Help::AdminErrorView(__('view.admin_group.add.error.invalid_pid'), 2);
            }
        } else {
            $parentGroup    = [];
        }
        $data['parentGroup'] = $parentGroup;

        // 保存
        if (\Request::isMethod('post')) {
            $name   = \Request::input("name");
            if (!$name) {
                return \Help::returnJson(__("view.admin_group.add.error.empty_name"), 0);
            }

            $group->name    = $name;
            $group->pid     = $parentGroup ? $parentGroup->id : 0;
            $group->rid     = 0;

            $group->save();
            $group->rid     = $parentGroup ? $parentGroup->rid . '|' . $group->id : $group->id;
            $group->save();

            return \Help::returnJson(__("view.admin.add.success"), 1, ['url' => route("adminGroupList", [])]);

        }

        return Help::adminView("admin/adminGroup/add")->with($data);
    }

    /**
     * 修改状态
     * @param $id
     * @return mixed
     */
    public function status($id) {
        $group = AdminGroup::find($id);
        if (!$group) {
            return \Help::returnJson(__("view.admin_group.status.error.invalid_id"), 1);
        }

        $group->status   = $group->status == 1 ? 0 : 1;
        $group->save();

        return \Help::returnJson(__("view.admin_group.status.success"), 1);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function aclEdit($id) {
        $group = AdminGroup::find($id);
        if (!$group) {
            return \Help::returnJson("无效的管理组!", 1);
        }

        if ($group->pid) {
            $parentGroup = AdminGroup::find($group->pid);
        } else {
            $parentGroup = AdminGroup::find(1);
        }

        $parentAcl      = AdminMenu::getAclIds($parentGroup);;
        $editUserAcl    = AdminMenu::getAclIds($group);

        // 提交
        if (\Request::isMethod('post')) {
            $aclIds = \Request::input("acl_id");
            info($aclIds);
            $menus  = AdminMenu::whereIn("id", $aclIds)->where("status", 1)->get();
            $acl    = [];
            foreach ($menus as $m) {
                if (!in_array($m->id, $parentAcl)) {
                    continue;
                }
                $acl[] = $m->id;
            }
            $group->acl = serialize($acl);
            $group->save();
            return redirect()->route('adminGroupList');
        }

        $canUseMenus = AdminMenu::getAclMenus($parentAcl);
        return Help::adminView("admin/adminGroup/acl_edit")->with([
            'group'             => $group,
            "currentAclIds"     => $editUserAcl,
            'allMenus'          => $canUseMenus
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function aclDetail($id) {
        $group = AdminGroup::find($id);
        if (!$group) {
            return \Help::returnJson("无效的管理组!", 1);
        }

        $ids        = AdminMenu::getAclIds($group);
        $allMenus   = AdminMenu::getAclMenus($ids);

        return Help::adminView("admin/adminGroup/acl_detail")->with(['group' => $group, 'allMenus' => $allMenus]);
    }

    /**
     * 详情
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail() {
        return Help::adminView("admin/adminGroup/detail");
    }
}

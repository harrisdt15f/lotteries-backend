<?php
namespace App\Models\Partner;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class PartnerMenu extends Model
{

    // 如果未设置 默认是蛇形复数形式的表明
    protected $table = 'partner_menus';

    /**
     * @param $condition
     * @param $pageSize
     * @return array
     */
    static function getMenuList($condition, $pageSize = 10) {
        $query = self::orderBy('id', 'desc');
        if (isset($condition['pid'])) {
            $query->where('pid', '=', $condition['pid']);
        } else {
            $query->where('pid', '=', 0);
        }

        $currentPage    = isset($condition['pageIndex']) ? intval($condition['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $menus  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    /**
     * 获取菜单层级关系
     * @param int $pid
     * @return mixed
     */
    static function getMenuRelated($pid) {
        $menu = self::find($pid);
        if (!$menu || !$menu->rid) {
            return [];
        }

        $ids    = explode('|', $menu->rid);
        $menus  = self::whereIn('id', $ids)->get();
        return $menus;
    }

    /**
     * 数据库结构是三级机构 只有type = 0 的才是菜单
     * type     = 0 菜单 type     = 1 链接
     * region   = 0 后台 region   = 1 前台
     * @return array
     */
    static function getLeftMenus() {
        $adminUser  = \Auth::guard('admin')->user();
        $group      = $adminUser->group();
        $allAcl     = AdminMenu::getAclIds($group);


        $menus  = self::where('status', '=', 1)->where('type', '=', 0)->orderBy('sort', 'ASC')->get();
        $data   = [];
        foreach ($menus as $m) {
            if ($m->pid == 0 && in_array($m->id, $allAcl)) {
                $data[$m->id]['title']      = $m->title;
                $data[$m->id]['css_class']  = $m->css_class;
            }
        }

        //  二级菜单
        foreach ($menus as $m) {
            if ($m->pid > 0 && in_array($m->id, $allAcl)) {
                $data[$m->pid]['child'][] = $m;
            }
        }

        return $data;
    }

    /**
     * 构建菜单 @TODO 权限
     * @param $buttons
     * @return array
     */
    static function buildButtons($buttons) {
        $routes = [];
        foreach($buttons as $button) {
            $routes[] = $button['route'];
        }

        $menus = self::whereIn('route', $routes)->get();
        $class = [];
        $ids   = [];
        foreach($menus as $m) {
            $class[$m->route] = ['class' => $m->css_class, 'title' => $m->title];
            $ids[] = $m->id;
        }

        $data = [];
        foreach($buttons as $button) {
            $data[] = [
                'url'       => route($button['route'], $button['params']),
                'class'     => $class[$button['route']]['class'],
                'title'     => $class[$button['route']]['title'],
                'type'      => isset($button['type']) ? $button['type'] : ''
            ];
        }
        return $data;
    }

    /**
     * 获取面包屑
     */
    static function getBreadcrumb() {
        $routeName  = Route::getCurrentRoute()->getName();
        $item   = self::where('route', $routeName)->first();
        if ($item && $item->rid) {
            $items = self::whereIn('id', explode('|', $item->rid))->orderBy('id', 'ASC')->get();
        } else {
            $items = $item ? [$item] : [];
        }

        $data = [];
        foreach ($items as $_route) {
            $data[] = [
                'route' => $_route->route,
                'title' => $_route->title,
            ];
        }

        return $data;
    }

    /**
     * 获取可用权限menu Id
     * @param $group
     * @param $hasRoute
     * @return array|mixed
     */
    static function getAclIds($group) {
        if ($group->acl == "*") {
            $menus  = self::where('status',  '=', 1)->orderBy('id',   'ASC')->get();
            $allIds    = [];
            foreach ($menus as $m) {
                $allIds[] = $m->id;
            }
        } else {
            $acl    =  $group->acl ? unserialize($group->acl) : [];
            $menus  = self::where('status',  '=', 1)->whereIn('id', $acl)->orderBy('id',   'ASC')->get();

            $allIds = [];
            foreach ($menus as $m) {
                $allIds[] = $m->id;
                if ($m->rid) {
                    $ids = explode("|", $m->rid);
                    foreach ($ids as $id) {
                        if (!in_array($id, $allIds)) {
                            $allIds[] = $id;
                        }
                    }
                }
            }
        }
        return $allIds;
    }

    /**
     * 获取菜单路由
     * @param $ids
     * @return array
     */
    static function getAllMenuRoute($ids) {
        $menus  = self::whereIn('id', $ids)->get();
        $data   = [];
        foreach ($menus as $menu) {
            $data[] = $menu->route;
        }
        return $data;
    }

    /**
     * 获取权限
     * @param array $allIds
     * @return array
     */
    static function getAclMenus($allIds = []) {

        // 带上级的
        $allMenus   = self::where('status',  '=', 1)->whereIn('id', $allIds)->orderBy('sort',   'ASC')->get();

        $aclMenus   = [];

        $parentMenus = [];
        foreach ($allMenus as $menu) {
            if (!$menu->pid) {
                if(in_array($menu->id, $allIds)) {
                    $aclMenus[$menu->id] = [
                        'title' => $menu->title,
                        'route' => $menu->route,
                        'child' => []
                    ];
                }
            }

            $aRid = explode('|', $menu->rid);

            if (count($aRid) == 3) {
                if (!isset($parentMenus[$menu->pid])) {
                    $parentMenus[$menu->pid] = [];
                }
                $parentMenus[$menu->pid][$menu->id] = [
                    'title' => $menu->title,
                    'route' => $menu->route,
                    'child' => []
                ];
            }
        }

        foreach ($allMenus as $_menu) {
            $aRid = explode('|', $_menu->rid);
            if (count($aRid) == 2) {
                $aclMenus[$_menu->pid]['child'][$_menu->id] = [
                    'title' => $_menu->title,
                    'route' => $_menu->route,
                    'child' => isset($parentMenus[$_menu->id]) ? $parentMenus[$_menu->id] : []
                ];
            }

        }


        return $aclMenus;
    }
}
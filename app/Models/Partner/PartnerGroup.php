<?php

namespace App\Models\Partner;

use Illuminate\Database\Eloquent\Model;

class PartnerGroup extends Model
{
    // 如果未设置 默认是蛇形复数形式的表明
    protected $table = 'partner_groups';

    /**
     * 后去用户可以配置的下级
     * @param string $adminUser
     * @return array
     */
    static function getAdminGroupList($adminUser = '') {
        $query          = self::orderBy('id', 'desc');

        if (!$adminUser) {
            $adminUser  = \Auth::guard('admin')->user();
        }

        $groupIds[] = $adminUser->group_id;

        $return = [];

        foreach ($groupIds as $key => $groupId) {

            // 当前登录
            $query->where('pid', $groupId);
            $data   = $query->get();
            foreach ($data as $item) {
                $return[$item->id] = [
                    'id'            => $item->id,
                    'pid'           => $item->pid,
                    'name'          => $item->name,
                    'total_childs'  => $item->total_childs,
                    'created_at'    => $item->created_at,
                    'level'         => 1,
                    'child'         => [],
                ];

                $_child = self::orderBy('id', 'desc')->where('pid', $item->id)->get();

                foreach ($_child as $_item) {
                    $return[$item->id]['child'][$_item->id] = [
                        'id'            => $_item->id,
                        'pid'           => $_item->pid,
                        'name'          => $_item->name,
                        'created_at'    => $_item->created_at,
                        'total_childs'  => $_item->total_childs,
                        'level'         => 2,
                        'child'         => [],
                    ];

                    $__child = self::orderBy('id', 'desc')->where('pid', $_item->id);;
                    foreach ($__child as $__item) {
                        $return[$item->id]['child'][$_item->id]['child'][$__item->id] = [
                            'id'            => $__item->id,
                            'pid'           => $__item->pid,
                            'name'          => $__item->name,
                            'created_at'    => $__item->created_at,
                            'total_childs'  => $__item->total_childs,
                            'level'         => 3,
                            'child'         => [],
                        ];
                    }
                }
            }
        }

        return $return;
    }

    /**
     * 检查是不是某一个平台的下级
     * @param $pid
     * @return bool
     */
    public function isChildGroup($pid) {
        $parentArr = explode('|', $this->rid);
        if(in_array($pid, $parentArr)) {
            return true;
        }
        return false;
    }
}

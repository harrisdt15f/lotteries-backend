<?php

namespace App\Models\Admin;

use App\Lib\T;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Tom 2019
 * Class AdminUser
 * @package App\Models\Admin
 */
class AdminUser extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public $rules = [
        'username'          => 'required|min:4|max:32|unique:admin_users,username',
        'email'             => 'required|email|unique:admin_users,email',
        'password'          => 'required|min:6|max:32',
        'fund_password'     => 'required|min:6|max:32',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // 如果未设置 默认是蛇形复数形式的表明
    protected $table = 'admin_users';


    /**
     * 获取与用户关联的电话号码
     */
    public function group()
    {
        return AdminGroup::find($this->group_id);
    }

    static function getAdminUserList($condition, $pageSize = 20) {
        $adminUser = \Auth::guard('admin')->user();
        $group = $adminUser->group();
        $query = self::select(
            DB::raw('admin_users.*'),
            DB::raw('admin_groups.name as group_name')
        )->leftJoin('admin_groups', 'admin_users.group_id', '=', 'admin_groups.id')
        ->where("admin_groups.rid", "like" , "{$group->rid}%")
        ->orderBy('id', 'desc');


        $currentPage    = isset($condition['pageIndex']) ? intval($condition['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $data   = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $data, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    // 获得直接下级组
    public function getChildGroup() {
        if ($this->id == 1) {
            $groups = AdminGroup::where("pid", 1)->get();
        } else {
            $groups = AdminGroup::where("pid", $this->group_id)->get();
        }

        $data = [];
        if ($groups) {
            foreach($groups as $g) {
                $data[$g->id] = $g->name;
            }
        }

        return $data;
    }

    // 活动所有下级
    public function getChildGroupAll() {
        $groups = AdminGroup::where("rid", 'like', $this->group_id  ."|%")->get();
        $_l = substr_count($this->group_id, '|');
        $data = [];
        if ($groups) {
            foreach($groups as $g) {
                $_k = substr_count($g->rid, '|');
                $_i = $_k - $_l - 1;
                $str = "";
                if ($_i > 0) {
                    for($j = 0; $j < $_i; $j ++) {
                        $str .= "&nbsp;&nbsp;&nbsp;";
                    }
                    for($j = 0; $j < $_i; $j ++) {
                        $str .= "--";
                    }
                }
                $data[$g->id] = $str . $g->name;
            }
        }

        return $data;
    }

    public function saveItem() {
        $data       = \Request::all();
        $validator  = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $this->username         = $data['username'];
        $this->email            = $data['email'];
        $this->group_id         = $data['group_id'];
        $this->register_ip      = real_ip();
        $this->status           = 1;

        if ($this->id > 0) {

        } else {
            $this->password         = bcrypt($data['password']);
            $this->fund_password    = bcrypt($data['fund_password']);
        }

        $adminUser      = \Auth::guard('admin')->user();
        $this->admin_id = $adminUser->id;
        $this->save();

        $msg = "添加管理员:" . $data['email'] . ", 操作人:" . $adminUser->email;
        T::addAdminMsg($msg);
        return true;
    }

    /**
     * 密码检测
     * @param $password
     * @return bool|string
     */
    static function checkPassword($password) {
        if (!preg_match("/^[0-9a-zA-Z_]{6,16}$/i", $password) || preg_match("/^[0-9]+$/", $password) || preg_match("/^[a-zA-Z]+$/i", $password) || preg_match("/(.)\\1{2,}/i", $password)) {
            return "对不起, 密码输入格式不正确!";
        } else {
            return true;
        }
    }

    /**
     * 密码检测
     * @param $password
     * @return bool|string
     */
    static function checkFundPassword($password) {
        if (!preg_match("/^[0-9a-zA-Z]{6,16}$/", $password)) {
            return "对不起, 资金密码格式不正确!";
        } else {
            return true;
        }
    }
}

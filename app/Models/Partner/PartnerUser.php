<?php

namespace App\Models\Partner;

use App\Lib\Logic\OpenPartner;
use App\Models\Base;
use App\Models\Player\Player;

use Illuminate\Support\Facades\Validator;

class PartnerUser extends Base {
    protected $table = 'partner_users';

    static $rules = [
        "username"          => "required|min:6,max:32",
        "password"          => "required|min:4,max:32",
        "fund_password"     => "required|min:4,max:32",
        "email"             => "required|email",
        "prize_group"       => "required",
        "platform_name"     => "required|min:4,max:32",
        "sign"              => "required|min:2,max:32",
        "theme"             => "required|min:2,max:32",
    ];

    /**
     * 获取列表
     * @param $c
     * @param int $pageSize
     * @return array
     */
    static function getList($c, $pageSize = 15) {
        $query = self::orderBy('id', 'desc');

        // 用户名
        if(isset($c['username'])) {
            $query->where('username', $c['username']);
        }

        // 日期
        if(isset($c['parent_id'])) {
            $query->where('parent_id', $c['parent_id']);
        }

        // 日期 开始
        if(isset($c['start_day'])) {
            $query->where('day', ">=", $c['start_day']);
        }

        // 日期 结束
        if(isset($c['end_day'])) {
            $query->where('day', "<=", $c['end_day']);
        }

        $currentPage    = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $items  = $query->skip($offset)->take($pageSize)->get();


        return ['data' => $items, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    /**
     * 保存
     * @param $data
     * @param int $adminId
     * @return bool
     */
    static function saveItem($data, $adminId  = 0) {
        $validator  = Validator::make($data, self::$rules);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $username           = $data["username"];
        $password           = $data["password"];
        $fundPassword       = $data["fund_password"];
        $email              = $data["email"];
        $prizeGroup         = $data["prize_group"];
        $platformName       = $data["platform_name"];
        $sign               = $data["sign"];
        $theme              = $data["theme"];

        $res = OpenPartner::addPartner($username, $email, $password, $fundPassword, $sign, $platformName, $adminId);
        if(true !== $res) {
           return $res;
        }

        // 添加用户
        $top = Player::addPartner($sign, $username, $password, $prizeGroup, $theme);
        if (!is_object($top)) {
            return $top;
        }

        return true;
    }

    /**
     * 获取伙伴选项
     * @return array
     */
    static function getPartnerOptions() {
        $items = self::orderBy('id', 'desc')->get();
        $data = [];
        foreach ($items as $item) {
            $data[$item->sign] = $item->platform_name;
        }
        return $data;
    }
}

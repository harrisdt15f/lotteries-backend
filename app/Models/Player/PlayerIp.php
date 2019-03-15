<?php

namespace App\Models\Player;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class PlayerIp extends Model
{
    protected $table = 'user_ip_list';

    public $rules = [
        'user_id'           => 'required|min:1|max:32',
        'ip'                => 'required|ip',
    ];

    /**
     * 获取用户列表
     * @param $c
     * @param $offset
     * @param $pageSize
     * @return mixed
     */
    static function getList($c, $offset, $pageSize) {
        $query = self::orderBy('id', 'DESC');

        // 用户名
        if (isset($c['username']) && $c['username']) {
            $query->where('username', $c['username']);
        }

        // status
        if (isset($c['status']) && $c['status']) {
            $query->where('status', $c['status']);
        }

        $total  = $query->count();
        $items  = $query->skip($offset)->take($pageSize)->get();

        $currentPage    = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;

        return ['data' => $items, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    public function saveItem()
    {
        $data       = \Request::all();
        $validator  = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $user = User::find($data['user_id']);
        if (!$user->id) {
            return __("error.client_ip.add.user.not_exist");
        }

        $this->user_id      = $data['user_id'];
        $this->username     = $user->username;
        $this->game_name    = $user->game_name;
        $this->ip           = $data['ip'];
        $this->save();
        return true;
    }

    /**
     * 获取select选项 ip
     * @param $userId
     * @return array
     */
    static function getIpListByUserId($userId) {
        $items = self::where("status", 1)->where('user_id', $userId)->get();
        $data = [];
        foreach($items as $item) {
            $data[] = $item->ip;
        }
        return $data;
    }
}

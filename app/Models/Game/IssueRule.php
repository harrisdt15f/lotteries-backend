<?php

namespace App\Models\Game;

use Illuminate\Support\Facades\Validator;

class IssueRule extends BaseGame
{
    public $rules = [
        'lottery_name'      => 'required|min:4|max:32',
        'begin_time'        => 'required|date_format:"H:i:s"',
        'end_time'          => 'required|date_format:"H:i:s"',
        'issue_seconds'     => 'required|integer',
        'first_time'        => 'required|date_format:"H:i:s"',
        'adjust_time'       => 'required|integer',
        'encode_time'       => 'required|integer',
        'issue_count'       => 'required|integer',
    ];

    // 如果未设置 默认是蛇形复数形式的表明
    protected $table = 'issue_rules';

    // 获取列表
    static function getList($c, $pageSize = 20) {
        $query = self::orderBy('id', 'desc');

        if (isset($c['lottery_id']) && $c['lottery_id'] && $c['lottery_id'] != "all") {
            $query->where('lottery_id', '=', $c['lottery_id']);
        }

        $currentPage    = isset($c['pageIndex']) ? intval($c['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $data   = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $data, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    // 保存
    public function saveItem() {
        $data       = \Request::all();
        $validator  = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        // 游戏是否存在
        $lottery = Lottery::getByName($data['lottery_name']);
        if (!$lottery) {
            return "无效的游戏";
        }

        $this->lottery_name         = $data['lottery_name'];
        $this->begin_time           = $data['begin_time'];
        $this->end_time             = $data['end_time'];
        $this->issue_seconds        = intval($data['issue_seconds']);
        $this->first_time           = $data['first_time'];
        $this->adjust_time          = intval($data['adjust_time']);
        $this->encode_time          = intval($data['encode_time']);
        $this->issue_count          = intval($data['issue_count']);

        $this->save();
        return true;
    }
}

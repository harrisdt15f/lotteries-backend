<?php

namespace App\Models\Game;

use App\Lib\Clog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Lottery extends BaseGame
{
    public $rules = [
        'cn_name'           => 'required|min:4|max:32',
        'en_name'           => 'required|min:4|max:32',
        'series_id'         => 'required|min:2|max:32',
        'max_trace_number'  => 'required|min:1|max:32',
        'issue_format'      => 'required|min:2|max:32',
    ];

    // 如果未设置 默认是蛇形复数形式的表明
    protected $table = 'lotteries';

    // 获取列表
    static function getList($condition, $pageSize = 20) {
        $query = self::orderBy('id', 'desc');
        if (isset($condition['en_name']) && $condition['en_name']) {
            $query->where('en_name', '=', $condition['en_name']);
        }

        $currentPage    = isset($condition['pageIndex']) ? intval($condition['pageIndex']) : 1;
        $offset         = ($currentPage - 1) * $pageSize;

        $total  = $query->count();
        $menus  = $query->skip($offset)->take($pageSize)->get();

        return ['data' => $menus, 'total' => $total, 'currentPage' => $currentPage, 'totalPage' => intval(ceil($total / $pageSize))];
    }

    // 保存
    public function saveItem() {
        $data       = \Request::all();
        $validator  = Validator::make($data, $this->rules);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $this->cn_name          = $data['cn_name'];
        $this->en_name          = $data['en_name'];
        $this->series_id        = $data['series_id'];
        $this->max_trace_number = intval($data['max_trace_number']);
        $this->issue_format     = $data['issue_format'];

        $this->is_fast          = isset($data['is_fast']) ? 1 : 0;
        $this->auto_open        = isset($data['auto_open']) ? 1 : 0;

        $this->save();
        return true;
    }

    // 获取选项
    static function getOptions() {
        $items = self::where('status', 1)->get();
        $data = [];
        foreach ($items as $item) {
            $data[$item->en_name] = $item->cn_name;
        }

        return $data;
    }

    /**
     * 预处理 已经失败的代码
     * @param $lotteryId
     * @param $code
     */
    static function getPreLoseMethod($lotteryId, $code) {

    }

    /** ================================= 游戏相关 ================================== */

    /**
     * 合法的倍数
     * @param $times
     * @return bool
     */
    public function isValidTimes($times) {
        if (!$times || $times <= 0) {
            return false;
        }

        if ($times > $this->max_times || $times < $this->min_times) {
            return false;
        }

        return true;
    }

    /**
     * 是否是彩种合法的奖金组
     * @param $prizeGroup
     * @return bool
     */
    public function isValidPrizeGroup($prizeGroup) {

        if (!$prizeGroup) {
            return false;
        }

        info($prizeGroup);
        info($this->max_prize_group);
        info($this->min_prize_group);

        if ($prizeGroup > $this->max_prize_group || $prizeGroup < $this->min_prize_group) {
            return false;
        }

        return true;
    }

    // 检测追号数据
    public function checkTraceData($traceData) {
        if (!$traceData || !is_array($traceData)) {
            return "对不起, 无效的追号奖期数据!";
        }

        $issueArr = [];
        foreach ($traceData as $issue => $status) {
            $issueArr[] = $issue;
        }

        $issueItems = Issue::whereIn('issue', $issueArr)->orderBy('begin_time', 'ASC')->get();
        $nowTime    = time();

        if (count($traceData) != $issueItems->count()) {
            return "对不起, 追号奖期不正确!";
        }

        $data = [];
        foreach ($issueItems as $item) {
            if ($item->end_time <= $nowTime) {
                return "对不起, 存在无效的奖期!";
            }

            $data[] = $item->issue;
        }

        return $data;
    }

    /**
     * 获取所有游戏 包含玩法
     * @return array|mixed
     * @throws \Exception
     */
    static function getAllLotteryByCache() {

        if (self::_hasCache('lottery')) {
            return self::_getCacheData('lottery');
        } else {
            $lotteries = self::getAllLotteries();
            self::_saveCacheData('lottery', $lotteries);
            return $lotteries;
        }
    }

    static function getAllLotteries() {

        $lotteries = self::where('status', 1)->get();

        $lotteryData = [];
        foreach ($lotteries as $lottery) {
            $config     = self::getAllMethodConfigByCache($lottery->series_id);

            $methods    = Method::where('lottery_id', $lottery->en_name)->where('status', 1)->get();

            $_methods   = [];
            foreach ($methods as $method) {

                $methodConfig = isset($config[$method->method_id]) ? $config[$method->method_id] : [];
                if (!$methodConfig) {
                    continue;
                }
                $_method = $method->toArray();

                $_method['total']   = $methodConfig['total'] ? $methodConfig['total']  : '';
                $_method['levels']  = $methodConfig['levels'] ? $methodConfig['levels']  : '';

                $_methods[$method->method_id] = $_method;
            }

            $lottery->methods = $_methods;
            $lotteryData[$lottery->en_name] = $lottery;
        }

        return $lotteryData;
    }

    /**
     * 获取单个彩种
     * @param $sign
     * @param bool $hasMethod
     * @return array|mixed
     * @throws \Exception
     */
    static function getLottery($sign) {
        $lotteries = self::getAllLotteryByCache();

        if (isset($lotteries[$sign])) {
            return $lotteries[$sign];
        }
        return [];
    }

    /**
     * 获取玩法配置
     * @param $methodId
     * @return array
     */
    public function getMethod($methodId) {
        $methods = $this->methods;
        if (isset($methods[$methodId])) {
            return $methods[$methodId];
        }
        return [];
    }

    /**
     * 获取单个玩法对象
     * @param $seriesId
     * @param $methodId
     * @return array|mixed
     * @throws \Exception
     */
    static function getMethodObjectByCache($seriesId, $methodId) {
        $key    = $seriesId . "_" . $methodId;

        $methods = [];
        if (self::_hasCache('method_object')) {
            $methods =  self::_getCacheData('method_object');
        }

        // 存在就返回
        if (isset($methods[$key])) {
           return   $methods[$key];
        }

        $method = Method::where('series_id', $seriesId)->where('method_id', $methodId)->first();

        // 获取
        $oMethod = \App\Lib\Game\Lottery::getMethodObject($seriesId, $method->method_group, $methodId);
        if (!is_object($oMethod)) {
            $msg = "获取玩法异常:" . $method->method_name;
            Clog::userBet($msg);
            return [];
        }

        // 保存
        $methods[$key] = $oMethod;
        self::_saveCacheData('method_object', $methods);

        return $oMethod;
    }

    /**
     * 获取素有的玩法配置
     * @param $seriesId
     * @return array|\Illuminate\Contracts\Cache\Repository
     * @throws \Exception
     */
    static function getAllMethodConfigByCache($seriesId) {
        if (self::_hasCache("method_config")) {
            return self::_getCacheData("method_config");
        }

        $config     = \App\Lib\Game\Lottery::getAllMethodConfig($seriesId);
        self::_saveCacheData("method_config", $config);
        return $config;
    }

    /** ================================= 奖期生成 ================================== */

    /**
     * 根据开始时间和结束时间生成奖期
     * @param $startDay
     * @param $endDay
     * @param $openTime
     * @return array|string
     */
    public function genIssue($startDay, $endDay, $openTime = null) {
        if ($this->status != 1) {
            return "彩种未开启!!";
        }

        // 小于
        if (strtotime($startDay) > strtotime($endDay)) {
            return "结束时间不能小于开始时间!!";
        }

        // 是否选择了开始奖期
        if ($this->issue_type == 'random' && !$openTime) {
            return "您选择的彩种需要凯开始日期!";
        }

        $rules  = IssueRule::where('lottery_id', $this->en_name)->orderBy('id', "ASC")->get();

        $daySet = $this->getDaySet($startDay, $endDay);

        $return = [];
        foreach ($daySet as $day) {
            $return[$day] = $this->_genIssue($day, $rules);
        }

        return $return;
    }

    // 生成 某天的奖期
    public function _genIssue($day, $rules) {
        if (!$rules) {
            return "未配置奖期规则!!";
        }

        // 整数形式的日期
        $intDay = date('Ymd', strtotime($day));

        // 检查是否存在奖期
        $issueCount = Issue::where('lottery_id', $this->en_name)->where('day', $intDay)->count();

        if ($issueCount > 0) {
            return "奖期-{$this->lottery_sign}-{$intDay}-已经存在!!";
        }

        $firstIssueNo   = "";
        $data           = [];

        if ($this->issue_type == "increase") {
            $config = config("game.issue.issue_fix");
            if (isset($config[$this->en_name])) {
                $_config    = $config[$this->en_name];
                $day        = (strtotime($day) - strtotime($_config['day'])) / 86400;
                $day        = floor($day);

                if (isset($_config['zero_start'])) {
                    $firstIssueNo = intval($_config['start_issue']) + $day * $this->day_issue;
                    $firstIssueNo = $_config['zero_start'] . $firstIssueNo;
                } else {
                    $firstIssueNo = $_config['start_issue'] + $day * $this->day_issue;
                }
            }
        }

        if ($this->en_name == "hljssc") {
            Clog::issueGen($day . "--" . $firstIssueNo);
        }

        // 生成
        $issueNo = $firstIssueNo ? $firstIssueNo : "";
        foreach ($rules as $index => $rule) {

            $adjustTime = $rule->adjust_time;
            $beginTime  = strtotime($day . " " . $rule['begin_time']);

            // 结束时间的修正
            if ($rule['end_time'] == "00:00:00") {
                $endTime    = strtotime($day . " " . $rule['end_time']) + 86400   - $adjustTime;
            } else {
                $endTime    = strtotime($day . " " . $rule['end_time'])   - $adjustTime;
                // 如果跨天
                if (strtotime($day . " " . $rule['begin_time']) > strtotime($day . " " . $rule['end_time'])) {
                    $endTime = $endTime + 86400;
                }
            }

            $issueTime  = $rule['issue_seconds'];

            $index   = 1;
            do {
                if (1 == $index) {
                    $issueEnd = strtotime($day . " " . $rule['first_time']) - $adjustTime;
                    $officialOpenTime = strtotime($day . " " . $rule['first_time']);
                } else {
                    $issueEnd = $beginTime + $issueTime;
                    $officialOpenTime = $beginTime + $issueTime + $adjustTime;
                }

                $item = [
                    'lottery_id'            => $this->en_name,
                    'issue_rule_id'         => $rule->id,
                    'lottery_name'          => $this->cn_name,
                    'begin_time'            => $beginTime,
                    'end_time'              => $issueEnd,
                    'official_open_time'    => $officialOpenTime,
                    'allow_encode_time'     => $officialOpenTime + $rule['encode_time'],
                    'day'                   => $intDay,
                ];

                if ($firstIssueNo) {
                    $item['issue'] = $issueNo;
                    $issueNo = $this->getNextIssueNo($issueNo, $this, $rule, $day);
                } else {
                    $issueNo = $this->getNextIssueNo($issueNo, $this, $rule, $day);
                    $item['issue'] = $issueNo;
                }

                $data[] = $item;

                $beginTime = $issueEnd;
                $index ++;

            }while($beginTime < $endTime);

        }

        $totalGenCount  = count($data);

        if ($this->en_name == "hljssc") {
            Clog::issueGen($day . "--" . $totalGenCount, $data);
        }

        if ($totalGenCount != $this->day_issue) {
            return "生成的期数不正确, 应该：{$this->day_issue} - 实际:{$totalGenCount}";
        }

        // 插入
        $res = DB::table("issues")->insert($data);

        if ($res) {
            return true;
        }
        return "插入数据失败!!";
    }

    /**
     * 获取下一期的
     * @param $issueNo
     * @param $lottery
     * @param $day
     * @return mixed
     */
    public function getNextIssueNo($issueNo, $lottery, $day) {
        $day            = strtotime($day);
        $issueFormat    = $lottery->issue_format;

        $formats = explode('|', $issueFormat);

        // C 开头
        if (count($formats) == 1 and strpos($formats[0], 'C') !== false) {
            $currentIssueNo = intval($issueNo);
            $nextIssue      = $currentIssueNo + 1;

            if (strlen($currentIssueNo) == strlen($issueNo)) {
                return $nextIssue;
            } else {
                return str_pad($nextIssue, strlen($issueNo), '0', STR_PAD_LEFT);
            }
        }

        // 日期型
        if (count($formats) == 2) {
            $numberLength = substr($formats[1], -1);

            // 时时彩 / 乐透
            if (strpos($formats[1], 'N') !== false) {

                $suffix = date($formats[0], $day);

                if ($issueNo) {
                    return $suffix . $this->getNextNumber($issueNo, $numberLength);
                } else {
                    return $suffix . str_pad(1, $numberLength, '0', STR_PAD_LEFT);
                }
            }

            // 特殊号
            if (strpos($formats[1], 'T') !== false) {

                $suffix = date($formats[0], $day);

                if ($issueNo) {
                    return $suffix . $this->getNextNumber($issueNo, $numberLength);
                } else {
                    return $suffix . str_pad(1, $numberLength, '0', STR_PAD_LEFT);
                }
            }
        }
    }

    /**
     * 获取下一个
     * @param $issueNo
     * @param $count
     * @return string
     */
    public function getNextNumber($issueNo, $count) {
        $currentNo  = substr($issueNo, -$count);
        $nextNo     = intval($currentNo) + 1;
        return str_pad($nextNo, $count, '0', STR_PAD_LEFT);
    }

    /**
     * 获取时间集合
     * @param $startDay
     * @param $endDay
     * @return array
     */
    public function getDaySet($startDay, $endDay) {
        $data = [];
        $dtStart = strtotime($startDay);
        $dtEnd   = strtotime($endDay);

        if ($dtStart > $dtEnd) {
            return $data;
        }

        do {
            $data[] = date('Y-m-d', $dtStart);
        } while (($dtStart += 86400) <= $dtEnd);

        return $data;
    }

    /**
     * 检查录入的号码
     * @param $series
     * @param $code
     * @return bool
     */
    public function checkCodeFormat($codeStr) {
        $codeArr = explode(',',  $codeStr);
        $series = $this->series_id;
        // 数字彩票
        if (in_array($series, ['ssc', '3d', 'p3p5'])) {
            $_code = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
            foreach ($codeArr as $c) {
                if (!in_array($c, $_code)) {
                    return false;
                }
            }

            if (count($codeArr) != 5) {
                return false;
            }

            return true;
        }

        // 乐透彩票
        if (in_array($series, ['115',])) {
            $_code = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11'];
            foreach ($codeArr as $c) {
                if (!in_array($c, $_code)) {
                    return false;
                }
            }

            if (count($codeArr) != 5) {
                return false;
            }

            return true;
        }

        // pk10
        if ($series ==  'pk10') {
            $_code = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10'];
            foreach ($codeArr as $c) {
                if (!in_array($c, $_code)) {
                    return false;
                }
            }

            if (count($codeArr) != 10) {
                return false;
            }

            return true;
        }

        // 快三
        if (in_array($series, ['jskl3'])) {
            $_code = [1, 2, 3, 4, 5, 6];
            foreach ($codeArr as $c) {
                if (!in_array($c, $_code)) {
                    return false;
                }
            }

            if (count($codeArr) != 3) {
                return false;
            }

            return true;
        }

        // 六合彩
        if (in_array($series, ['lhc'])) {
            $_code = [1, 2, 3, 4, 5, 6];
            foreach ($codeArr as $c) {
                if (!in_array($c, $_code)) {
                    return false;
                }
            }

            if (count($codeArr) != 3) {
                return false;
            }

            return true;
        }

        return false;
    }
    
    public function formatOpenCode($openCode) {
        $positions  = explode(",", $this->positions);
        $codes      = explode(',', $openCode);
        return array_combine($positions, $codes);
    }
}

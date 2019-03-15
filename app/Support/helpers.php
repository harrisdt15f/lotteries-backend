<?php
//自定义helper

if (!function_exists('db')) {
    function db($connection = null)
    {
        if (is_null($connection)) {
            return app('db');
        } else {
            return app('db')->connection($connection);
        }
    }
}

if (!function_exists('real_ip')) {
    function real_ip()
    {
        return getRealIP();
    }
}

if (!function_exists('configure')) {
    function configure($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('Configure');
        } else {
            return app('Configure')->get($key, $default);
        }
    }
}

// 小数２
if (!function_exists('number2')) {
    function number2($number)
    {
        return \App\Lib\Help::number2($number);
    }
}

// 小数4
if (!function_exists('number4')) {
    function number4($number)
    {
        return \App\Lib\Help::number4($number);
    }
}

function isDatetime($date)
{
    $patten = "/^\d{4}[\-](0?[1-9]|1[012])[\-](0?[1-9]|[12][0-9]|3[01])(\s+(0?[0-9]|1[0-9]|2[0-3])\:(0?[0-9]|[1-5][0-9])\:(0?[0-9]|[1-5][0-9]))?$/";
    if (preg_match($patten, $date)) {
        return true;
    }
    return false;
}

function substrString($str, $length, $dot = false)
{
    $resStr = mb_substr($str, 0, $length, 'utf-8');

    if ($dot && $resStr != $str) {
        $resStr .= "...";
    }
    return $resStr;
}

function send_warning_mail($title, $data)
{
    if (app()->environment() != 'product') {
        $title = "(测试)" . $title;
    }

    $emails = [];

    // 邮件阀值
    $mailData = array(
        'emails' => $emails,
        'subject' => $title,
        'data' => $data,
        'tpl' => 'emails.draw',
    );

    if (!empty($emails)) {
        dispatch((new \App\Jobs\Mail($mailData))->onQueue('mail'));
    }
}

//秒转成 年-天-小时-分-秒
function second2Time($time)
{
    $value = array(
        "years" => 0, "days" => 0, "hours" => 0,
        "minutes" => 0, "seconds" => 0,
    );
    if($time >= 31556926){
        $value["years"] = floor($time/31556926);
        $time = ($time%31556926);
    }
    if($time >= 86400){
        $value["days"] = floor($time/86400);
        $time = ($time%86400);
    }
    if($time >= 3600){
        $value["hours"] = floor($time/3600);
        $time = ($time%3600);
    }
    if($time >= 60){
        $value["minutes"] = floor($time/60);
        $time = ($time%60);
    }
    $value["seconds"] = floor($time);

    $str='';
    if($value['years']){
        $str.=$value["years"] ."年";
    }
    if($value['days']){
        $str.=$value["days"] ."天";
    }
    if($value['hours']){
        $str.=$value["hours"] ."小时";
    }

    $str.=$value["minutes"] ."分".$value["seconds"]."秒";

    return $str;
}

function getIpDesc($ip = "", $all = false)
{
    if ($ip == "") {
        $ip = getRealIP();
    }

    if ($ip == '127.0.*.*' || $ip == '127.0.0.*' || $ip == '127.0.0.1') {
        return "本机地址";
    }

    //依赖ip库
    $res = \Ip::find($ip);

    if ($res == "N/A") {
        return "未知地区";
    }

    if ($res[0] = $res[1]) {
        $return = $res[0];
    } else {
        $return = $res[0] . " " . $res[1];
    }

    if ($all && isset($res[2])) {
        $return .= " " . $res[2];
    }

    if ($all && isset($res[3])) {
        $return .= " " . $res[3];
    }

    return $return;
}

function getRealIP()
{
    static $realip = NULL;
    if ($realip !== NULL) {
        return $realip;
    }

    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($arr AS $ip) {
                $ip = trim($ip);
                if ($ip != 'unknown') {
                    $realip = $ip;
                    break;
                }
            }
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                $realip = $_SERVER['REMOTE_ADDR'];
            } else {
                $realip = '0.0.0.0';
            }
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR')) {
            $realip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_CLIENT_IP')) {
            $realip = getenv('HTTP_CLIENT_IP');
        } else {
            $realip = getenv('REMOTE_ADDR');
        }
    }
    preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
    $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
    return $realip;
}

//替换IP 后1位保留星号
function ipHide($ip)
{
    return preg_replace('/(\d+)\.(\d+)\.(\d+)\.(\d+)/is', "$1.$2.$3.*", $ip);
}

//替换用户名***
function usernameHide($username)
{
    $prv = mb_substr($username, 0, 1);

    $last = mb_substr($username, mb_strlen($username) - 1, 1);

    return $prv . '***' . $last;
}

// 中文日期 星期几
function cnWeeks() {
    $arr = array('天','一','二','三','四','五','六');
    return $arr[date('w')];
}

// 生成客服地址
function genCustomUrl($user) {

    // 客服
    $liveConfig = config('web.live800');
    $key        = $liveConfig['key'];
    $params     = $liveConfig['params'];

    $l          = count(explode('|',$user->raleid))-1;

    $levels=[
        1 => '直属',
        2 => '总代',
    ];

    $directors = config('game.director');
    if(isset($directors[$user->topid])) {
        $levels = [
            1 => '主管',
            2 => '主管-直属',
            3 => '主管-总代',
        ];
    }

    $role='代理';
    if(isset($levels[$l])) {
        $role = $levels[$l];
    } else {
        if($user->type == \App\Models\User::PLAYER_TYPE_MEMBER) {
            $role='用户';
        }
    }

    $role.='-'.$user->point;

    $hashParams = [];
    $hashParams['userId']   = $user->id;
    $hashParams['name']     = $user->username . '(' . $role . ')';
    $hashParams['memo']     = $user->username . '(' . $user->nickname . ')';
    $hashParams['timestamp']= time() * 1000;
    $hashParams['hashCode'] = md5(urlencode($hashParams['userId'] . $hashParams['name'] . $hashParams['memo'] . $hashParams['timestamp'] . $key));
    $paramStr = "userId=" . $hashParams['userId'] . "&name=" . $hashParams['name'] . "&memo=" . $hashParams['memo'] . "&timestamp=" . $hashParams['timestamp'] . "&hashCode=" . $hashParams['hashCode'];
    $params['info'] = urlencode($paramStr);

    $url = $liveConfig['url'] . "?jid={$params['jid']}&s=1&companyID={$params['companyID']}&configID={$params['configID']}&codeType={$params['codeType']}&info={$params['info']}";
    return $url;
}
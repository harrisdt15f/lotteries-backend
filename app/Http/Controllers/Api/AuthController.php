<?php

namespace App\Http\Controllers\Api;

// 登录
use App\Lib\Help;
use App\Models\Player\Player;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;


class AuthController extends ApiBaseController {

    use Authenticatable;

    // 登录
    public function login() {
        $code = trim(request("code", ''));

        if (!\Captcha::check($code)) {
            //return Help::returnApiJson("对不起, 您输入的验证码不正确!", 0);
        }

        $username   = trim(request("username"));
        if (!$username) {
            return Help::returnApiJson("对不起, 您输入的用户名为空!", 0);
        }

        $password   = trim(request("password"));
        if (!$password) {
            return Help::returnApiJson("对不起, 您输入的密码为空!", 0);
        }

        $credentials = ['username' => $username, 'password' => $password];

        if (! $token = auth('api')->attempt($credentials)) {

            return Help::returnApiJson("对不起, 用户名或密码错误!", 0);
        }

        $user   = auth('api')->user();
        $user->last_login_ip    = real_ip();
        $user->last_login_time  = time();
        $user->save();

        $account = $user->account();

        $data = [
            'token'                 => $token,
            'token_type'            => 'bearer',
            'expires_in'            => auth('api')->factory()->getTTL() * 60,
            'user_id'               => $user->id,
            'username'              => $user->username,
            'prize_group'           => $user->prize_group,
            'user_type'             => $user->type,
            'is_tester'             => $user->is_tester,
            'levels'                => $user->levels,
            'can_withdraw'          => $user->frozen_type > 0 ? false : true,
            'balance'               => number4($account->balance),
            'frozen_balance'        => number4($account->frozen ),
            'has_funds_password'    => $user->fund_password ? true : false,
            'download_url'          => configure("system_app_download_url", "http://www.lottery.com/api/download") . "/" . $user->invite_code,
            'version'               => configure("system_app_version", "1.0"),
        ];

        return Help::returnApiJson('登录成功', 1, $data);
    }

    // 注册
    public function register() {

        $ip     = real_ip();
        $query  = InviteRecord::where("ip", $ip);

        $deviceType = trim(request('device_type', ''));
        if ($deviceType && in_array($deviceType, ['ios', 'android'])) {
            $query->where('device_type', $deviceType);
        }

        if ($query->count() > 0) {
            $item = $query->orderBy("id", "desc")->first();
        } else {
            $item  = InviteRecord::where("ip", $ip)->orderBy("id", "desc")->first();
        }

        if ($item) {
            $user = Player::find($item->user_id);
        } else {
            $defaultCode    = configure('proxy_default_register_code', "387652");
            $user = Player::findByCode($defaultCode);
        }

        // 如果找不到用户 用默认ID为1的
        if (!$user) {
            $user = Player::find(10000);
        }

        // 1. 当前用户如果为会员 不能添加
        if ($user->type == Player::PLAYER_TYPE_PLAYER) {
            return Help::returnApiJson("对不起, 会员不能有下级!", 0);
        }

        // 3. 检查用户名
        $username       = trim(request('phone_number', ''));
        $resUsername    = Player::checkPhoneNumber($username);
        if (true !== $resUsername) {
            return Help::returnApiJson("对不起, {$resUsername}!", 0);
        }

        // 5. 检查密码
        $password       = request('password', '');
        $resPassword    = Player::checkPassword($password);
        if (true !== $resPassword) {
            return Help::returnApiJson("对不起, {$resPassword}!", 0);
        }

        // 6. 用户名和密码不能一样
        if ($username == $password) {
            return Help::returnApiJson("对不起, 用户名和密码不能重复!", 0);
        }

        $res = $user->addChild($username, $password);
        if (!is_object($res)) {
            return Help::returnApiJson($res, 0);
        }

        // 生成关系
        Relationship::genRelationship($user, $res, 1);
        Relationship::genRelationship($res, $user, 2);

        return Help::returnApiJson("恭喜,注册成功!", 1);
    }

    /**
     * 验证码
     * @return \Illuminate\Http\JsonResponse
     */
    public function captcha() {
        $res = app('captcha')->create('flat', true);
        return Help::returnApiJson("恭喜,　获取验证码数据成功!", 1, ['img' => $res['img'], 'key' => $res['key']]);
    }

    // 登出
    public function logout() {
        auth()->logout();
        return Help::returnApiJson('登出成功!', 1);
    }

    //
    protected function guard() {
        return Auth::guard('api');
    }

    public function username() {
        return 'username';
    }

    /**
     * 获取银行列表
     * @return array
     */
    public function getBankList() {
        $banks = config("web.banks");

        $data = [];
        foreach($banks as $sign => $name) {
            $data[] = [
                'sign'  => $sign,
                'name'  => $name
            ];
        }

        return $data;
    }

    function base64EncodeImage ($image) {
        $image_info     = getimagesize($image);
        $image_data     = fread(fopen($image, 'r'), filesize($image));
        $base64_image   = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Lib\Help;
use App\Lib\T;
use App\Lib\Validator;
use App\Models\Admin\AdminUser;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cache;

class AuthController extends BaseController
{
    use AuthenticatesUsers;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $redirectTo = '/';

    /**
     * 显示登陆表单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return Help::adminView("auth/login");
    }

    /**
     * 注册表单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return Help::adminView("auth/register");
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $email = $request->input('email');
        $pass  = $request->input('password');
        if (!$email || !$pass) {
            return Help::returnJson("请输入帐号和密码!", 0);
        }

        /**
         * 根据username . id 做为缓存的key 保存到memcache
         * lockout  key: username.ip:lockout, 如果用户已经被锁 那么记录 用户key=> 解锁时间
         * hit      kay: username.ip       记录用户访问次数
         */
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
            );

            $message = __('view.auth.login.error.throttle', ['seconds' => $seconds]);
            $options = ["username" => $this->username()];

            return Help::returnJson($message, 0, $options);
        }

        // 检查是否可登陆
        if ($this->attemptLogin($request)) {
            $isProd = app()->environment() == 'product' ? true : false;
            $tCode  = $request->input('t_code');
            if ($isProd && !$tCode) {
                return Help::returnJson("请输入安全码!!!", 0);
            }

            // 确认验证码
            $user = \Auth::guard('admin')->user();

            // 是否存在验证码
            if ($isProd && !$user->t_code) {
                return Help::returnJson("对不起, 请获取验证码!!!", 0);
            }

            // 是否时间过期
            if ($isProd && (time() - 5 * 60 * 60) > $user->t_code_time) {
                return Help::returnJson("安全码失效, 请重新获取!!!", 0);
            }

            // 验证码
            if ($isProd && $user->t_code != $tCode) {
                return Help::returnJson("对不起, 您输入的安全码不正确!!!", 0);
            }

            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            $msg =  $request->get("email") . "登录后台成功, IP:" . real_ip();
            T::adminNotice($msg);

            $user->last_login_ip    = getRealIP();
            $user->save();

            return Help::returnJson(__('view.auth.login.success'), 1, ['url' => url("/")]);
        } else {
            return Help::returnJson("帐号密码不正确!", 0);
        }

        /**
         * 累加登陆失败次数
         */
        $this->incrementLoginAttempts($request);

        return Help::returnJson(__('view.auth.login.error.credentials'));
    }

    public function getTcode(Request $request) {
        $this->validateLogin($request);

        // 检查是否可登陆
        if ($this->attemptLogin($request)) {
            $ip     = $request->getClientIp();
            $key    = "login_T_code_" . $ip;

            $m = Carbon::now()->addMinutes(1);

            if (Cache::add($key, 1, $m)) {

                $user = AdminUser::where('email', $request->input('email'))->first();
                info($user);
                if (!$user->t_code_time || (time() - $user->t_code_time) > 5 * 60 * 60) {
                    $code  = rand(100000, 999999);
                    T::adminNotice("您本次登陆安全码:" . $code . ", 有效时间5分钟");

                    $user->t_code       = $code;
                    $user->t_code_time  = time();
                    $user->save();
                } else {
                    T::adminNotice("您本次登陆安全码:" . $user->t_code);
                }
                return Help::returnJson("发送安全密码成功!!", 1);
            } else {
                return Help::returnJson("发送太频繁,请稍后在试!!", 0);
            }
        } else {
            return Help::returnJson("无效的账户密码!!", 0);
        }
    }

    /**
     * 注册逻辑不用自带的的验证 用自定义的
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // 用户名
        $username       = $request->input('name');
        $usernameCheck  = Validator::check('name', $username, 'required|min:6|max:16', []);
        if ($usernameCheck !== true) {
            return Help::returnJson($usernameCheck);
        }

        // 邮箱
        $email              = $request->input('email');
        if (!$email) {
            return Help::returnJson("auth.register.error.empty.email");
        }

        // 密码
        $password           = $request->input('password');
        if (!$password) {
            return Help::returnJson("auth.register.error.empty.password");
        }

        // 确认密码
        $confirmPassword    = $request->input('password_confirmation');
        if (!$confirmPassword) {
            return Help::returnJson("auth.register.error.empty.password_confirmation");
        }


        // 写入
        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    public function forgotPassword()
    {
        return view('home');
    }

    /** ============ 辅助函数 ============= */

    /**
     * 这个是多个表结构验证必备的， 需要覆盖继承后的
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard|mixed
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * 逻辑处理 辅助函数
     * @param Request $request
     * @param $user
     */
    protected function registered(Request $request, $user)
    {
        //
    }
}

<?php
namespace App\Http\Controllers\Admin\Player;

use App\Lib\Help;
use App\Models\Admin\AdminMenu;
use App\Http\Controllers\Admin\Controller;
use App\Models\Player\Player;
use App\Models\Stat\UserStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PlayerController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $c  = $request->all();

        // 上级ID
        $ridStr = [];
        if (isset($c['parent_id']) && $c['parent_id']) {
            $parent = Player::find($c['parent_id']);
            if ($parent) {
                $ridStr = $parent->getRidStr();
                $c['parent_id'] = $parent->id;
            }
        }

        $data   = Player::getList($c);

        // 顶部按钮
        $buttonConfig = [
            ['route' => "playerAdd", 'params' => []]
        ];

        $buttons    = AdminMenu::buildButtons($buttonConfig);

        $types      = config("user.main.type");

        return Help::adminView("player/list")->with(['data' => $data, 'c' => $c,  'buttons' => $buttons, 'types' => $types, 'ridStr' => $ridStr]);
    }

    // 添加
    public function add() {

        if (\Request::isMethod('post')) {
            $username       = \Request::get("username");
            $password       = \Request::get("password");
            $isTester       = \Request::get("is_tester");
            $theme          = \Request::get("theme");

            $res = Player::addTop($username, $password, $isTester, $theme);
            if(!is_object($res)) {
                return Help::returnJson($res, 0);
            }

            return Help::returnJson("", 1, ['url' => route("playerList")]);
        }

        $minGroup   = \C::get('user_min_prize_group', 1800);
        $maxGroup   = \C::get('user_max_prize_group', 1960);
        $themeList  = config("user.main.theme");

        return Help::adminView("player/add")->with([
            'minGroup'      => $minGroup,
            'maxGroup'      => $maxGroup,
            'themeList'     => $themeList,

        ]);
    }

    // 资金
    public function fund($id) {
        $player     = Player::find($id);

        if (\Request::isMethod('post')) {
            $mode       = \Request::get("mode");
            $type       = \Request::get("type");
            $amount     = \Request::get("amount");
            $reason     = \Request::get("desc");

            $ret = $player->manualTransfer($mode, $type, $amount, $reason);
            if (true === $ret) {
                return Help::returnJson("操作成功", 1);
            }

            return Help::returnJson($ret, 0);
        }

        $min    = \C::get("proxy_transfer_min", 1);
        $max    = \C::get("proxy_transfer_max", 10000);

        $account    = $player->account();

        return Help::adminView("player/fund")->with([
            'model'             => $player,
            'account'           => $account,
            'min'               => $min,
            'max'               => $max,
            'fundAddTypes'      => Player::$fundAddTypes,
            'fundReduceTypes'   => Player::$fundReduceTypes,
        ]);
    }

    // 资金
    public function password($id) {
        $player     = Player::find($id);

        if (\Request::isMethod('post')) {
            $mode   = \Request::get("mode");

            if (1 == $mode) {
                $password   = \Request::get("password");
                $res        = Player::checkPassword($password);
                if ($res !== true) {
                    return Help::returnJson($res, 0);
                }

                $confirmPasswrod   = \Request::get("confirm_password", '');
                if ($confirmPasswrod != $password) {
                    return Help::returnJson("对不起, 密码输入不一致!", 0);
                }

                $player->password = Hash::make($password);
                $player->save();

                return Help::returnJson("修改登录密码成功!", 1);
            } else {
                $password   = \Request::get("fund_password");
                $res        = Player::checkFundPassword($password);
                if ($res !== true) {
                    return Help::returnJson($res, 0);
                }

                $confirmPasswrod   = \Request::get("confirm_fund_password", '');
                if ($confirmPasswrod != $password) {
                    return Help::returnJson("对不起, 密码输入不一致!", 0);
                }

                $player->fund_password = Hash::make($password);
                $player->save();

                return Help::returnJson("恭喜, 修改资金密码成功!", 1);
            }

            return Help::returnJson("操作成功", 1);
        }

        return Help::adminView("player/password")->with([
            'model' => $player,
        ]);
    }

    // 冻结
    public function frozen($id) {
        $player     = Player::find($id);

        if (\Request::isMethod('post')) {
            $frozen = \Request::get("frozen", 0);
            if (!array_key_exists($frozen, Player::$frozenType)) {
                return Help::returnJson("对不起, 无效的冻结类型!!", 0);
            }

            $player->frozen_type = $frozen;
            $player->save();

            return Help::returnJson("操作成功", 1);
        }

        $account    = $player->account();

        return Help::adminView("player/frozen")->with([
            'model'             => $player,
            'account'           => $account,
        ]);
    }

    // 详情
    public function detail($id) {
        $player     = Player::find($id);
        $account    = $player->account();
        $stat       = UserStat::where("user_id", $id)->first();
        return Help::adminView("player/detail")->with([
            'model'         => $player,
            'account'       => $account,
            'stat'          => $stat,
        ]);
    }

    // 详情
    public function setting($id) {
        $player     = Player::find($id);
        return Help::adminView("player/setting")->with([
            'model'         => $player,
        ]);
    }
}

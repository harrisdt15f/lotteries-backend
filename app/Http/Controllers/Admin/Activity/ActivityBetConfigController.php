<?php

namespace App\Http\Controllers\Admin\Activity;

use App\Lib\Help;
use App\Lib\Telegram;
use App\Models\Admin\AdminMenu;
use App\Models\Game\Lottery;
use App\Models\User;
use Curl\Curl;
use Illuminate\Support\Facades\Request;

class ActivityBetConfigController extends Controller
{

    public function frame()
    {
        $menu = AdminMenu::getTopMenus();
        return view('admin/frame')->with('menu', $menu);
    }

    public function home() {
        $lotteries    = Lottery::getAllLotteries(true);
        return view('admin/home')->with('lotteries',       $lotteries);
    }
}

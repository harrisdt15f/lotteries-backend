<?php

namespace App\Http\Controllers\Api;

use App\Lib\Help;
use App\Lib\Telegram;
use App\Models\Admin\AdminMenu;
use App\Models\Game\Lottery;
use App\Models\User;
use Curl\Curl;
use Illuminate\Support\Facades\Request;

class ApiSystemController extends Controller {

    public function userInfo() {
        $lotteries = Lottery::getAllLotteries(true);
        return view('frontend/theme_moon/home')->with('lotteries',       $lotteries);
    }

    public function balance() {
        $lotteries = Lottery::getAllLotteries(true);
        return view('frontend/theme_moon/home')->with('lotteries',       $lotteries);
    }
}

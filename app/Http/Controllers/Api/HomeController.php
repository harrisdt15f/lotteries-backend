<?php

namespace App\Http\Controllers\Frontend;

use App\Lib\Help;
use App\Lib\Telegram;
use App\Models\Admin\AdminMenu;
use App\Models\Game\Lottery;
use App\Models\User;
use Curl\Curl;
use Illuminate\Support\Facades\Request;

class HomeController extends Controller
{

    public function home() {
        $lotteries = Lottery::getAllLotteries(true);
        return view('frontend/theme_moon/home')->with('lotteries',       $lotteries);
    }

    public function getMethod() {
        $lotteries = Lottery::getOptions();
        return view('frontend/theme_moon/home')->with('lotteries',       $lotteries);
    }
}

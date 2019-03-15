<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\AdminMenu;
use App\Models\Game\Issue;
use App\Models\Game\Lottery;

class HomeController extends Controller
{

    public function frame()
    {
        $menu = AdminMenu::getLeftMenus();
        return view('admin/frame')->with('menu', $menu);
    }

    public function home() {

        $lotteries = Lottery::getAllLotteryByCache();
        $issues  = Issue::getCanBetIssue("cqssc");
        return view('admin/home')->with('lotteries', $lotteries)->with('issues', $issues);
    }

}

<?php

namespace App\Http\Controllers\Partner;

use App\Models\Admin\AdminMenu;
use App\Models\Game\Lottery;

class HomeController extends Controller
{

    public function frame()
    {
        $menu = AdminMenu::getLeftMenus();
        return view('admin/frame')->with('menu', $menu);
    }

    public function home() {
        $lotteries    = Lottery::getAllLotteries(true);
        return view('admin/home')->with('lotteries',       $lotteries);
    }
}

<?php

namespace App\Http\Controllers\Partner\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin\AdminMenu;

class HomeController extends Controller
{

    public function frame()
    {
        $menu = AdminMenu::getLeftMenus();
        return view('admin/frame')->with('menu', $menu);
    }

    public function home() {

        return view('admin/home')->with('lotteries',       []);
    }

}

<?php
namespace App\Http\Controllers\Admin\Account;

use App\Lib\Help;
use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data   = \App\Models\Account\Account::getList($request->all());

        return Help::adminView("account/list")->with(['data' => $data]);
    }

}

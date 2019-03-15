<?php

namespace App\Http\Controllers\Admin\Partner;

use App\Http\Controllers\Admin\Controller;
use App\Lib\Help;
use App\Models\Partner\PartnerUser;
use Illuminate\Support\Facades\Request;


class PartnerUserController extends Controller
{

    public function index()
    {
        $c      = Request::all();
        $data   = PartnerUser::getList($c);
        return Help::adminView("partner/user/list")->with(['data' => $data,]);
    }

    // 添加
    public function add() {

        if (\Request::isMethod('post')) {
            $params     = Request::all();
            $adminUser  = auth()->guard("admin")->user();

            $res = PartnerUser::saveItem($params, $adminUser->id);
            if ($res !== true) {
                return Help::returnJson($res, 0);
            }

            return Help::returnJson("添加成功！", 1, ['url' => route("partnerUserList", [])]);
        }

        $theme = config("main.theme");
        return Help::adminView("partner/user/add")->with([
            'theme' => $theme,
        ]);
    }

    public function setting($id) {

    }
}

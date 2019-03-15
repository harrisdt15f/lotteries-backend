<?php
namespace App\Http\Controllers\Admin\Account;

use App\Lib\Help;
use App\Http\Controllers\Admin\Controller;
use App\Models\Player\AdminTransferRecords;
use Illuminate\Http\Request;

class SystemTransferController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $c      = $request->all();
        $data   = AdminTransferRecords::getList($c);

        return Help::adminView("account/system_transfer/list")->with(['data' => $data, 'c' => $c]);
    }

}

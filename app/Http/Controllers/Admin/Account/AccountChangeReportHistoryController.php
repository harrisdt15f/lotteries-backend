<?php
namespace App\Http\Controllers\Admin\Account;

use App\Lib\Help;
use App\Http\Controllers\Admin\Controller;
use App\Models\Account\AccountChangeReport;
use App\Models\Account\AccountChangeType;
use Illuminate\Http\Request;

class AccountChangeReportHistoryController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $c      = $request->all();
        $data   = AccountChangeReport::getList($c);

        $types  = AccountChangeType::getDataListFromCache();
        return Help::adminView("account/account_change_report/list")->with(
            [
                'data'  => $data,
                'types' => $types,
                'c'     => $c
            ]
        );
    }
}

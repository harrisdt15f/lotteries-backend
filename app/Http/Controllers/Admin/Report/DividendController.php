<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Admin\Controller;
use App\Lib\Help;
use App\Models\Stat\DividendReport;
use Illuminate\Support\Facades\Request;

class DividendController extends Controller
{

    public function index() {
        $c      = Request::all();
        $data   = DividendReport::getList($c);
        return Help::adminView("report/dividend/list")->with(['data' => $data,]);
    }
}
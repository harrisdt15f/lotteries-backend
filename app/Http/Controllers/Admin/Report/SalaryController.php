<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Admin\Controller;
use App\Lib\Help;
use App\Models\Stat\SalaryReport;
use Illuminate\Support\Facades\Request;

class SalaryController extends Controller
{

    public function index() {
        $c      = Request::all();
        $data   = SalaryReport::getList($c);
        return Help::adminView("report/salary/list")->with(['data' => $data,]);
    }
}

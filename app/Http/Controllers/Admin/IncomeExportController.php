<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\IcomeExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class IncomeExportController extends Controller
{
    public function __invoke(Request $request){
        $start = $request->start;
        $end = $request->end;

        return Excel::download(new IcomeExport($start, $end), 'report.xlsx');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $income = Pinjam::query();

        if (!empty($request->start)) {
            $income->where('starting_date', '>=', $request->start);
        }

        if (!empty($request->end)) {
            $income->where('ending_date', '<=', $request->end);
        }

        $income = $income->get();

        $total_income = 0;
        foreach ($income as $item) {
            $total_income += $item->income;
        }

        return view('admin.income.index', [
            'income' => $income,
            'total_income' => $total_income
        ]);
    }
}

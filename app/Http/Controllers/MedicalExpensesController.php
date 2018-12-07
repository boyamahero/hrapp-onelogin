<?php

namespace App\Http\Controllers;

use App\MedicalExpense;
use Illuminate\Http\Request;

class MedicalExpensesController extends Controller
{
    public function show($year = null)
    {
        $employee_id = auth()->user()->username;
        $year = ($year)?:date("Y");

        $expenses = MedicalExpense::where('PERNR',$employee_id)
                        ->where('SUBTY','5')
                        ->where('SCKTO','LIKE',$year.'%')
                        ->where('STATUS','P')
                        ->orderBy('RCPTDT')->get();

        return  response()->json([
            'year' => (int)$year,
            'total' => $expenses->sum('REIMB'),
            'data' => $expenses
        ]);

    }
}

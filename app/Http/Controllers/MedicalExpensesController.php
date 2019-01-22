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

        $expenses = MedicalExpense::where('PersNo',$employee_id)
                        ->where('SickDateTo','LIKE','%'.$year)
                        ->orderByRaw('SUBSTRING(SickDateTo,7,4)+SUBSTRING(SickDateTo,4,2)+SUBSTRING(SickDateTo,1,2) DESC')->get();

        return  response()->json([
            'year' => (int)$year,
            'total' => $expenses->sum('Reimburse'),
            'data' => $expenses
        ]);

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TempLocationController extends Controller
{
    public function exist($employeeCode)
    {
        return  response()->json([
            'employee_code' => $employeeCode,
            'show_popup' => !\App\WLSavedata::where('PERNR',$employeeCode)->whereNotNull('INTM_TEL')->exists()
        ],200);
    }
}

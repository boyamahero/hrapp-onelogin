<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobilePhoneLogController extends Controller
{
    public function show($employee_code)
    {
        $employee = Employee::where('employee_code', $employee_code)->with(['workFromHome','workFromAnyWhere', 'templocation', 'person.workLocations'])->first();

        // dd($employee->employee_code);

        $permissionViewMobilePhone = Auth::user()->hasRole('admin') || (Auth::user()->employee->is_boss &&
            Auth::user()->username != $employee->id &&
            $employee->isOwnerDataLevel(Auth::user()) || ($employee->workFromAnyWhere->count() > 0 || $employee->workFromHome->count() > 0));

        if (!$permissionViewMobilePhone)
        {
            abort(403);
        }

        return response()->json([
            'employee' => $employee->employee_code,
            'mobile_phone' => $employee->templocation->ZZMOBL ?? $employee->person->workLocations[0]->PWAH_MobilePhoneNumber ?? null
        ]);
    }
}

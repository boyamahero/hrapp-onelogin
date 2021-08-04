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
            $this->isOwnerDataLevel(Auth::user(),$employee) || ($employee->workFromAnyWhere->count() > 0 || $employee->workFromHome->count() > 0));

        if (!$permissionViewMobilePhone)
        {
            abort(403);
        }

        $mobilenumber_wf = "";
        // if(count($employee->workFromAnyWhere)>0){
        //     $mobilenumber_wf = $employee->workFromAnyWhere->first()->Mobile;
        // }else if(count($employee->workFromHome)>0){
        //     $mobilenumber_wf = $employee->workFromHome->first()->Mobile;
        // }
        
        return response()->json([
            'employee' => $employee->employee_code,
            // 'mobile_phone' => $employee->templocation->ZZMOBL ?? $employee->person->workLocations[0]->PWAH_MobilePhoneNumber ?? null
            'mobile_phone' =>  $mobilenumber_wf ?  $mobilenumber_wf : ($employee->templocation->ZZMOBL ?? $employee->person->workLocations[0]->PWAH_MobilePhoneNumber ?? null)
        ]);
    }

    public function isOwnerDataLevel($user,$employee)
    {
        if ($user->employee->employee_group == 9) {
            return true;
        } else if ($user->employee->org->org_level == 5) {
            return $user->employee->section_abb == $employee->section_abb;
        } else if ($user->employee->org->org_level == 4) {
            return $user->employee->department_abb == $employee->department_abb;
        } else if ($user->employee->org->org_level == 3) {
            return $user->employee->division_abb == $employee->division_abb;
        } else if ($user->employee->org->org_level == 2) {
            return $user->employee->assistant_abb == $employee->assistant_abb;
        } else if ($user->employee->org->org_level == 1) {
            return $user->employee->deputy_abb == $employee->deputy_abb;
        }
    }
}

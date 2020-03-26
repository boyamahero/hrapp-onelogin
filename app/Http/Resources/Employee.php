<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EducationCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class Employee extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'code' => $this->employee_code,
            'name' => $this->name,
            'position_abb' => $this->position_combine_abb,
            'secretary' => $this->person->secretary()->with('positionBoss')->first(),
            'position_full' => $this->position_combine_full,
            'org_path' => $this->org_path,
            'deputy_abb' => $this->deputy_abb,
            'deputy_full' => $this->deputy_full,
            'assistant_abb' => $this->assistant_abb,
            'assistant_full' => $this->assistant_full,
            'division_abb' => $this->division_abb,
            'division_full' => $this->division_full,
            'department_abb' => $this->department_abb,
            'department_full' => $this->department_full,
            'section_abb' => $this->section_abb,
            'section_full' => $this->section_full,
            'building' => trim($this->building),
            'room' => trim($this->room),
            'phone' => $this->phone,
            'senior' => $this->senior,
            'image_path' => $this->image_path,
            'level' => $this->employee_subgroup,
            'org_level' => $this->org->org_level,
            'is_boss' => $this->is_boss,
            'person_location' => $this->person->FirstLocation,
            'templocation' => $this->templocation ? $this->templocation->makeHidden(['ZZMOBL','INTM_NAME','INTM_TEL','INTM_RELATION','GENTEXT_AT']):null,
            'work_from_home' => $this->workFromHome()->where('BeginAt','<=',Carbon::now())->where('EndAt','>=',Carbon::now())->first(),
            $this->mergeWhen(Auth::user()->hasRole('admin') ||
            (
                Auth::user()->employee->is_boss && 
                Auth::user()->username != $this->id && 
                $this->isOwnerDataLevel(Auth::user()) 
            ), [
                'mobile_number' => $this->templocation ? $this->templocation->ZZMOBL : $this->person->MobilePhoneNumber,
                'name_english' => $this->name_english,
                'blood_group' => $this->blood_group,
                'employee_group_name' => $this->employee_group_name,
                'religion' => $this->religion_name,
                'birth_date' => $this->birth_thai_date,
                'age' => $this->age,
                'entry_date' => $this->entry_thai_date,
                'assign_date' => $this->assign_thai_date,
                'work_age' => $this->agew,
                'retire_date' => $this->retire_thai_date,
                'remain_work_age' => $this->remain_work_age,
                'level_date' => $this->old_dat,
                'level_work_age' => $this->old_dat_age,
                'positions' => $this->positions,
                'educations' => new EducationCollection($this->educations),
                'can_open' => true
            ]),
        ];
    }

    public function isOwnerDataLevel($user)
    {
        if ($user->employee->employee_group == 9) {
            return true;
        } else if ($user->employee->org->org_level == 5) {
            return $user->employee->section_abb == $this->section_abb;
        } else if ($user->employee->org->org_level == 4) {
            return $user->employee->department_abb == $this->department_abb;
        } else if ($user->employee->org->org_level == 3) {
            return $user->employee->division_abb == $this->division_abb;
        } else if ($user->employee->org->org_level == 2) {
            return $user->employee->assistant_abb == $this->assistant_abb;
        } else if ($user->employee->org->org_level == 1) {
            return $user->employee->deputy_abb == $this->deputy_abb;
        }
        
    }
}

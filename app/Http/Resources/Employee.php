<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Auth;
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
            'name' => $this->name,
            'position_abb' => $this->position_abb,
            'org_path' => $this->org_path,
            'building' => trim($this->building),
            'room' => trim($this->room),
            'phone' => $this->phone,
            'senior' => $this->senior,
            'image_path' => $this->image_path,
            'level' => $this->employee_subgroup,
            'is_boss' => $this->is_boss,
            'mobile_number' => $this->when(
                    Auth::user()->hasRole('admin') ||
                    ( 
                        Auth::user()->employee->is_boss && 
                        $this->isOwnerDataLevel(Auth::user()) 
                    ) || 
                    Auth::user()->username == $this->id
                , $this->mobile_number),
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

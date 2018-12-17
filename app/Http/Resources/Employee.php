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
            'is_boss' => $this->priority !== '' && $this->priority !== '04' && $this->priority !== '05',
            'mobile_number' => $this->when(
                    (Auth::user()->employee->id == $this->boss_id) || 
                    (Auth::user()->employee->id == $this->id) || 
                    (Auth::user()->hasRole('admin')
                ) , $this->mobile_number),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Education extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'degree_name' => $this->PEDH_EducationQualificationName,
            'certificate_name' => $this->PEDH_EducationFacultyName,
            'branch_name' => $this->PEDH_EducationFirstBranchName,
            'school_name' => $this->PEDH_EducationInstitutionName,
            'grade' => $this->PEDH_EducationGPAX,
            'graduated_year' => $this->PEDH_EducationGraduateYear,
            'degree_main' => $this->PEDH_EducationMainFlag=='10'?'X':'',
            'degree_entry' => $this->PEDH_EducationFirstFlag=='10'?'X':'',
        ];
    }
}

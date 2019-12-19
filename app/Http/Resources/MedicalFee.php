<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicalFee extends JsonResource
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
            'PersNo' => (int)$this->person->PS_Code,
            'Claim_Date' => $this->PMFH_MedicalFeeClaimDate,
            'Reference_No' => $this->PMFH_RequestDocumentCode,
            'Family_member' => $this->PMFH_PatientRelationName,
            // 'NUMB' => '',
            'Hospital_name' => $this->PMFH_HospitalName,
            // 'Diagnosis' => '',
            'SickDateFrom' => $this->PMFH_MedicalTreatmentBeginDate,
            'SickDateTo' => $this->PMFH_MedicalTreatmentEndDate,
            'Zyear' => substr($this->PMFH_MedicalTreatmentBeginDate,0,4),
            'Claim_Amount' => $this->PMFH_ApprovedAmount,
            'Reimburse' => $this->PMFH_ApprovedAmount,
            'Total_Amount' => $this->PMFH_MedicalFeeClaimAmount,
            'No_Reimburse' => $this->PMFH_MedicalFeeClaimAmount - $this->PMFH_ApprovedAmount,
            'date_added' => $this->PMFH_CreateTime,
            'family_type' => $this->PMFH_PatientRelationName,
            'diagnosis_name' => $this->PMFH_MedicalDiagnosis,
        ];
    }
}

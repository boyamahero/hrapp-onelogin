<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalFee extends Model
{
    protected $connection= 'NewHRDatabase';

    protected $table = 'PersonMedicalFeeHistory';

    /**
     * Scope a query to only include medical 3600 fees.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMedical3600Fee($query)
    {
        return $query->where('PMFH_MedicalFeeType',50)
                ->where('PMFH_ApprovedStatus',10);
    }

    /**
     * Get the person of the medical fee.
     */
    public function person()
    {
        return $this->belongsTo('App\Person', 'PMFH_PersonID','PersonID')->withDefault();
    }    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $connection= 'NewHRDatabase';

    protected $table = 'Person';

    public function MedicalFees()
    {
        return $this->hasMany('App\MedicalFee','PMFH_PersonID','PersonID');
    }

    public function Medical3600Fees()
    {
        return $this->hasMany('App\MedicalFee','PMFH_PersonID','PersonID')
                ->where('PMFH_MedicalFeeType',50)
                ->where('PMFH_ApprovedStatus',10);
    }
}

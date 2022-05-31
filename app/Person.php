<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Person extends Model
{
    use Cachable;

    protected $connection = 'NewHRDatabase';

    protected $table = 'Person';

    public function workLocations()
    {
        return $this->hasMany('App\WLPersonWorkAddressHistory', 'PWAH_PersonID', 'PersonID');
    }

    public function secretary()
    {
        return $this->hasMany('App\Secretary', 'PATH_PersonID', 'PersonID')
            ->where('PATH_SecretaryType', 24)
            ->where('PATH_ActiveFlag', 10)
            ->orderBy('PATH_DataValidYear','desc');
    }

    public function MedicalFees()
    {
        return $this->hasMany('App\MedicalFee', 'PMFH_PersonID', 'PersonID');
    }

    public function Medical3600Fees()
    {
        return $this->hasMany('App\MedicalFee', 'PMFH_PersonID', 'PersonID')
            ->where('PMFH_MedicalFeeType', 50)
            ->where('PMFH_ApprovedStatus', 10);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class WLPerdata extends Model
{
    use Cachable;
    
    protected $connection = 'NewHRDatabase';

    protected $table = 'Person';

    protected $appends = ['employee_code'];

    protected $visible = ['location'];

    public function location()
    {
        return $this->hasMany('App\WLPersonWorkAddressHistory', 'PWAH_PersonID', 'PersonID')
        ->select('PWAH_WorkLocationCode', 'PWAH_Name','PWAH_Address','PWAH_Room','PWAH_Building','PWAH_PhoneNumber')
        ->where('PWAH_DataStatus','100')
        ->orderBy('PWAH_DataValidEndDate','desc');
    }

    public function mobilephonenumber()
    {
        return $this->hasMany('App\WLPersonWorkAddressHistory', 'PWAH_PersonID', 'PersonID')
        ->select('PWAH_MobilePhoneNumber')
        ->where('PWAH_DataStatus','100')
        ->orderBy('PWAH_DataValidEndDate','desc');
    }

    public function getEmployeeCodeAttribute()
    {
        return substr($this->PS_Code,2,6);
    }

    public function getFirstLocationAttribute() {
        return $this->location()->first();
    }

    public function getMobilePhoneNumberAttribute() {
        return $this->mobilephonenumber()->pluck('PWAH_MobilePhoneNumber')->first();
    }

    public function secretary()
    {
        return $this->hasMany('App\Secretary','PATH_PersonID','PersonID')->where('PATH_SecretaryType',24);
    }
}

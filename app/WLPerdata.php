<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WLPerdata extends Model
{
    protected $connection = 'WorkLocationDB';

    protected $table = 'Person';

    protected $appends = ['employee_code'];

    protected $visible = ['location'];

    public function location()
    {
        return $this->hasMany('App\WLPersonWorkAddressHistory', 'PWAH_PersonID', 'PersonID')
        ->select(array('PWAH_Address','PWAH_Name','PWAH_PhoneNumber','PWAH_Room','PWAH_WorkLocationCode'))
        ->orderBy('PWAH_DataValidEndDate','desc');
    }

    public function mobilephonenumber()
    {
        return $this->hasMany('App\WLPersonWorkAddressHistory', 'PWAH_PersonID', 'PersonID')
        ->select('PWAH_MobilePhoneNumber')->orderBy('PWAH_DataValidEndDate','desc');
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
}

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
        return $this->hasOne('App\WLPersonWorkAddressHistory', 'PWAH_PersonID', 'PersonID');
    }

    public function getEmployeeCodeAttribute()
    {
        return substr($this->PS_Code,2,6);
    }
}

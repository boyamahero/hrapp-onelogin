<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'Employees';

    protected $appends = ['image_path'];

    protected $hidden = ['birth_date','birth_thai_date','birth_year','birth_month','birth_day','age','idcard_number','weight','weight_ratio','height','height_ratio','blood_group'];

    /* @ retrun image_path */
    public function getImagePathAttribute()
    {
        return 'https://pmsp.egat.co.th/EGAT-PMSP-IMAGE-DI/viewImage?PersonCode='. sprintf("%06d", $this->id) .'&pfdrid_c=true';
    }
}

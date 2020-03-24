<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Employee extends Model
{
    use Cachable;
    
    protected $connection = 'HRDatabase';

    protected $table = 'employees';

    protected $appends = ['image_path','is_boss','location'];

    protected $hidden = ['birth_date','birth_thai_date','birth_year','birth_month','birth_day','age','idcard_number','weight','weight_ratio','height','height_ratio','blood_group'];

    /* @ retrun image_path */
    public function getImagePathAttribute()
    {
        // return 'https://pmsp.egat.co.th/EGAT-PMSP-IMAGE-DI/viewImage?PersonCode='. sprintf("%06d", $this->id) .'&pfdrid_c=true';
        return '/api/images/'. sprintf("%06d", $this->id).'/'.base64_encode( substr(sprintf("%06d", $this->id),0,3) ).env('APP_SECRET','HrApP').base64_encode( substr(sprintf("%06d", $this->id),3,3) );
    }

    public function getIsBossAttribute()
    {
        return ($this->priority !== '' && $this->priority !== '04' && $this->priority !== '05' && $this->priority !== '06') || $this->employee_group == 9;
    }

    public function getEmployeePsCodeAttribute()
    {
        return '00'.$this->employee_code;
    }

    public function getMobileNumberAttribute()
    {
        return $this->person->mobilephonenumber;
    }

    public function org()
    {
        return $this->hasOne('App\Organization', 'org_egat_id', 'org_egat_id');
    }

    public function positions()
    {
        return $this->hasMany('App\Position', 'employee_code', 'id');
    }

    public function educations()
    {
        return $this->hasMany('App\Education', 'PersonCode', 'id')
                    ->orderBy('PEDH_EducationQualificationCode')
                    ->orderBy('PEDH_EducationGraduateYear','desc');
    }

    public function boss()
    {
        return $this->hasOne('App\Employee', 'id', 'boss_id');
    }

    public function person()
    {
        return $this->hasOne('App\WLPerdata', 'PS_Code', 'employee_ps_code');
    }

    public function getLocationAttribute() {
        return $this->person->FirstLocation;
    }

    public function templocation()
    {
        return $this->hasOne('App\WLSavedata', 'PERNR', 'id');
    }

}

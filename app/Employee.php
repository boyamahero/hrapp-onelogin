<?php

namespace App;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Employee extends Model
{
    use Searchable;
    use Cachable;

    protected $connection = 'HRDatabase';

    protected $table = 'employees';

    protected $appends = ['image_path', 'is_boss', 'location'];

    protected $hidden = ['birth_date', 'birth_thai_date', 'birth_year', 'birth_month', 'birth_day', 'age', 'idcard_number', 'weight', 'weight_ratio', 'height', 'height_ratio', 'blood_group'];

    public function searchableAs()
    {
        return 'employees';
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'org_path' => $this->org_path,
            'name_english' => $this->name_english,
            'email' => $this->email,
            'position_combine_abb' => $this->position_combine_abb,
            'position_combine_full' => $this->position_combine_full,
            'deputy_full' => $this->deputy_full,
            'assistant_full' => $this->assistant_full,
            'division_full' => $this->division_full,
            'department_full' => $this->department_full,
            'section_full' => $this->section_full,
        ];
    }

    public function getImagePathAttribute()
    {
        return '/images/' . sprintf("%06d", $this->id);
    }

    public function getIsBossAttribute()
    {
        return ($this->priority !== '' && $this->priority !== '04' && $this->priority !== '05' && $this->priority !== '06') || $this->employee_group == 9;
    }

    public function getPSCodeAttribute()
    {
        return '00' . $this->employee_code;
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
            ->orderBy('PEDH_EducationGraduateYear', 'desc');
    }

    public function boss()
    {
        return $this->hasOne('App\Employee', 'id', 'boss_id');
    }

    public function person()
    {
        return $this->hasOne('App\Person', 'PS_Code', 'PS_Code');
    }

    public function getLocationAttribute()
    {
        return $this->person->workLocations->first();
    }

    public function templocation()
    {
        return $this->hasOne('App\WLSavedata', 'PERNR', 'id');
    }

    public function workFromHome()
    {
        return $this->hasMany('App\WorkFromHome', 'EmpNo', 'employee_code');
    }

    public function workFromAnyWhere()
    {
        return $this->hasMany('App\WorkFromAnyWhere', 'EmpNo', 'employee_code');
    }
}

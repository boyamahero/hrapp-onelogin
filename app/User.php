<?php

namespace App;

use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $appends = ['user_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getUserIdAttribute()
    {
        return sprintf("%06d", $this->username);
    }

    /**
     * Get the employee record associated with the user.
     */
    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'username');
    }

    /**
     * Get the competencies record associated with the user.
     */
    public function competencies()
    {
        return $this->hasMany('App\Competency', 'Empn', 'user_id');
    }

     /**
     * Get the kpis record associated with the user.
     */
    public function kpis()
    {
        return $this->hasMany('App\Kpi', 'EMPN06', 'user_id');
    }

     /**
     * Get the bkpis record associated with the user.
     */
    public function bkpis()
    {
        return $this->hasMany('App\Bkpi', 'EMPN06', 'user_id');
    }

     /**
     * Get the history_works record associated with the user.
     */
    public function portfolioInfo()
    {
        return $this->hasMany('App\PortfolioInfo', 'empn', 'user_id');
    }

     /**
     * Get the education record associated with the user.
     */
    public function educations()
    {
        return $this->hasMany('App\Education', 'employee_id', 'user_id');
    }

     /**
     * Get the salary record associated with the user.
     */
    public function salaries()
    {
        $year = (intval(date("Y")) +543);
        return $this->hasMany('App\Salary', 'emp_code', 'user_id')->orderBy('salary_date', 'desc')->orderBy('salary_no', 'desc');
    }

}

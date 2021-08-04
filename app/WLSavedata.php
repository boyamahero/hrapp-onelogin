<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class WLSavedata extends Model
{
    use Cachable;
    
    protected $connection = 'HRDatabase';

    public $timestamps = false;

    protected $table = 'work_locations';

    protected $guarded = [];

    // protected $with = ['wlfullname'];

    public function scopeExclude($query,$value = array()) 
    {
        return $query->select( array_diff( $this->fillable,(array) $value) );
    }

    public function wlfullname()
    {
        return $this->belongsTo('App\Worklocation','ZZCODE','WL_Code');
    }
}

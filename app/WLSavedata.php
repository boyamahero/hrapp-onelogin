<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class WLSavedata extends Model
{
    use Cachable;
    
    protected $connection = 'HRDatabase';

    protected $table = 'work_locations';

    protected $fillable = ['PERNR', 'type_code', 'BEGDA' ,'ZZCODE' ,'ZZROMNO' ,'ZZFLBLD' ,'ZZOFTEL' ,'ZZMOBL',];

    protected $with = ['wlfullname'];

    public function wlfullname()
    {
        return $this->belongsTo('App\Worklocation','ZZCODE','WL_Code');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WLSavedata extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'work_locations';

    protected $fillable = ['PERNR', 'type_code', 'BEGDA' ,'ZZCODE' ,'ZZROMNO' ,'ZZFLBLD' ,'ZZOFTEL' ,'ZZMOBL',];

    protected $with = ['wlfullname'];

    public function wlfullname()
    {
        return $this->belongsTo('App\Worklocation','ZZCODE','WL_Code');
    }
}

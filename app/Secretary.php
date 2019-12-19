<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secretary extends Model
{
    protected $connection = 'NewHRDatabase';

    protected $table = 'V_PersonAction';

    public function positionBoss()
    {
        return $this->belongsTo('App\PositionNew','PATH_PersonManagementPositionID','PositionID');
    }
}

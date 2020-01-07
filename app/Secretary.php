<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Secretary extends Model
{
    use Cachable;

    protected $connection = 'NewHRDatabase';

    protected $table = 'V_PersonAction';

    public function positionBoss()
    {
        return $this->belongsTo('App\PositionNew','PATH_PersonManagementPositionID','PositionID');
    }
}

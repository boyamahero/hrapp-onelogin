<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class PositionNew extends Model
{
    use Cachable;

    protected $connection = 'HRDatabase';

    protected $table = 'PSNEngine_Position';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class WLtype extends Model
{
    use Cachable;

    protected $connection = 'HRDatabase';

    protected $table = 'work_location_types';
}

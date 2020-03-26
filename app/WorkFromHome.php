<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class WorkFromHome extends Model
{
    use Cachable;
    
    protected $connection = 'HRDatabase';

    protected $table = 'WFH_Headers';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class WorkFromAnyWhere extends Model
{
    use Cachable;

    protected $connection = 'HRDatabase';

    protected $table = 'HWFA';
    // protected $table = 'WFA_Headers';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Worklocation extends Model
{
    use Cachable;
    protected $connection = 'NewHRDatabase';
    protected $table = 'WorkLocation';
}

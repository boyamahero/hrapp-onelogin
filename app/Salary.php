<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Salary extends Model
{
    use Cachable;
    
    protected $connection = 'HRDatabase';

    protected $table = 's_salarys';
}

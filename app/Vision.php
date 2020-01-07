<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Vision extends Model
{
    use Cachable;

    protected $connection = 'HRDatabase';

    protected $table = 'TBP_pfo_vision';
}

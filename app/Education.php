<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Education extends Model
{
    use Cachable;
    
    protected $connection = 'HRDatabase';

    protected $table = 'PSN_STATE0_Educations';
    
}

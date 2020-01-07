<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Category extends Model
{
    use Cachable;
    
    protected $table = 'categoires';
}

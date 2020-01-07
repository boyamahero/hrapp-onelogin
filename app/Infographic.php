<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Infographic extends Model
{
    use Cachable;

    protected $table = 'infographics';
}

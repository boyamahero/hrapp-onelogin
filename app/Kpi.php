<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Kpi extends Model
{
    use Cachable;
    
    protected $connection = 'HRDatabase';

    protected $table = 'TBP_KPI';

   // protected $appends = ['avg_score','avg_all_score'];

}
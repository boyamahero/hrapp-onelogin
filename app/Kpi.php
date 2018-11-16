<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'TBP_KPI';

   // protected $appends = ['avg_score','avg_all_score'];

}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class HistoryWork extends Model
{
    use Cachable;
    
    protected $connection = 'HRDatabase';

    protected $table = 'TBP_history_works';
}

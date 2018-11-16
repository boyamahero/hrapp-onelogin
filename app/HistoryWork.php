<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryWork extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'TBP_history_works';
}

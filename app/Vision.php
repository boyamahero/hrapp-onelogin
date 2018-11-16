<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vision extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'TBP_pfo_vision';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'Positions';
}

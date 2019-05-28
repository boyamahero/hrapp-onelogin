<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WLtype extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'work_location_types';
}

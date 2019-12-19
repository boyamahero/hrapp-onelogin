<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PositionNew extends Model
{
    protected $connection = 'NewHRDatabase';
    protected $table = 'Position';
}

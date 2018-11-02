<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'Employees';
}

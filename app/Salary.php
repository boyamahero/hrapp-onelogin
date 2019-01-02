<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 's_salarys';
}

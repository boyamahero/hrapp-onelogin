<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalExpense extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'r_pa9202';
}

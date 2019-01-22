<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedicalExpense extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'v_medical_expense';
}

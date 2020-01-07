<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class MedicalExpense extends Model
{
    use Cachable;

    protected $connection = 'HRDatabase';

    protected $table = 'v_medical_expense';
}

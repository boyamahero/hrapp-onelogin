<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'educations';
    
}

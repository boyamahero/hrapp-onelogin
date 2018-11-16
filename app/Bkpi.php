<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bkpi extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'TBP_BKPI';
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'TBP_pfo_portfolio';
}

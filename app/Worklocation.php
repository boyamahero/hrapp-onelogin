<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worklocation extends Model
{
    protected $connection = 'WorkLocationDB';
    protected $table = 'WorkLocation';
}

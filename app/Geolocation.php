<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Geolocation extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'geolocation_user';
}
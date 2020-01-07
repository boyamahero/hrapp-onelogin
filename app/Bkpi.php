<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Bkpi extends Model
{
    use Cachable;
    
    protected $connection = 'HRDatabase';

    protected $table = 'TBP_BKPI';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'TEST_YR' => 'integer',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    protected $connection = 'HRDatabase';

    protected $table = 'TBP_Competency';

    protected $appends = ['score'];

    public function getScoreAttribute()
    {
        return (($this->C1 == 'S' ? 3 : ($this->C1 == 'A' ? 2 : 1)) + 
                ($this->C2 == 'S' ? 3 : ($this->C2 == 'A' ? 2 : 1)) +
                ($this->C3 == 'S' ? 3 : ($this->C3 == 'A' ? 2 : 1)) +
                ($this->C4 == 'S' ? 3 : ($this->C4 == 'A' ? 2 : 1)) +
                ($this->C5 == 'S' ? 3 : ($this->C5 == 'A' ? 2 : 1)) +
                ($this->C6 == 'S' ? 3 : ($this->C6 == 'A' ? 2 : 1)) +
                ($this->C7 == 'S' ? 3 : ($this->C7 == 'A' ? 2 : 1))) *100/21 ;
    }
}

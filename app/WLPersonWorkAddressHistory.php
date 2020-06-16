<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class WLPersonWorkAddressHistory extends Model
{
    use Cachable;

    protected $connection = 'HRDatabase';

    protected $table = 'PSNEngine_PersonWorkAddressHistory';

    protected $visible = ['PWAH_WorkLocationCode', 'PWAH_Name', 'PWAH_Address', 'PWAH_Room', 'PWAH_Building', 'PWAH_PhoneNumber', 'PWAH_MobilePhoneNumber'];

    //
}

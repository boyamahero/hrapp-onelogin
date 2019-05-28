<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WLPersonWorkAddressHistory extends Model
{
    protected $connection = 'WorkLocationDB';
    protected $table = 'PersonWorkAddressHistory';

    protected $visible = ['PWAH_WorkLocationCode', 'PWAH_Name','PWAH_Address','PWAH_Room','PWAH_Building','PWAH_PhoneNumber','PS_MobilePhoneNumber'];

    //
}
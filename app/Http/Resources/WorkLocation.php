<?php

namespace App\Http\Resources;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkLocation extends JsonResource
{
    protected $permission;

    public function __construct($resource, $permission = false, $wfa)
    {
        $this->resource = $resource;
        $this->permission = $permission;
        $this->wfa = $wfa;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];

        if ($this->resource->getTable() == 'work_locations') {
            if (count($this->wfa)==0){
                $mobilenumber = $this->ZZMOBL;
            } else {
                $mobilenumber = $this->wfa[0]->Mobile ? $this->wfa[0]->Mobile : $this->ZZMOBL;
            }
            $data = [
                'Address' => $this->wlfullname ? $this->wlfullname->WL_SubDistrict . ' ' . $this->wlfullname->WL_District . ' ' . $this->wlfullname->WL_Province : '',
                'Building' => $this->ZZFLBLD ?? '',
                'MobilePhoneNumber' => $this->when(
                    $this->permission,
                    $mobilenumber ? 'xxx-xxx-' . substr($mobilenumber, -4) : null
                ),
                'Name' => $this->wlfullname ? $this->wlfullname->WL_Name : '',
                'PhoneNumber' => $this->ZZOFTEL ?? '',
                'PhoneNumberFull' => $this->ZZOFTELFULL ?? '',
                'Room' => $this->ZZROMNO ?? '',
                'WorkLocationCode' => $this->ZZCODE ?? '',
            ];
        }

        if ($this->resource->getTable() == 'PSNEngine_PersonWorkAddressHistory') {
            if (count($this->wfa)==0){
                $mobilenumber = $this->PWAH_MobilePhoneNumber;
            } else {
                $mobilenumber = $this->wfa[0]->Mobile ? $this->wfa[0]->Mobile : $this->PWAH_MobilePhoneNumber;
            }
            $data = [
                'Address' => $this->PWAH_Address,
                'Building' => $this->PWAH_Building,
                'MobilePhoneNumber' => $this->when(
                    $this->permission,
                    $mobilenumber ? 'xxx-xxx-' . substr($mobilenumber, -4) : null
                ),
                'Name' => $this->PWAH_Name,
                'PhoneNumber' => $this->PWAH_PhoneNumber,
                'Room' => $this->PWAH_Room,
                'WorkLocationCode' => $this->PWAH_WorkLocationCode
            ];
        }

        return $data;
    }
}

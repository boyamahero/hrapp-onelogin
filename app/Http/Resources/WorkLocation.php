<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkLocation extends JsonResource
{
    protected $permission;

    public function __construct($resource, $permission = false)
    {
        $this->resource = $resource;
        $this->permission = $permission;
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

        if ($this->PWAH_Address) {
            $data = [
                'Address' => $this->PWAH_Address,
                'Building' => $this->PWAH_Building,
                'MobilePhoneNumber' => $this->when(
                    $this->permission,
                    $this->PWAH_MobilePhoneNumber
                ),
                'Name' => $this->PWAH_Name,
                'PhoneNumber' => $this->PWAH_PhoneNumber,
                'Room' => $this->PWAH_Room,
                'WorkLocationCode' => $this->PWAH_WorkLocationCode
            ];
        }

        if ($this->id) {
            $data = [
                'Address' => $this->wlfullname->WL_SubDistrict . ' ' . $this->wlfullname->WL_District . ' ' . $this->wlfullname->WL_Province,
                'Building' => $this->ZZFLBLD,
                'MobilePhoneNumber' => $this->when(
                    $this->permission,
                    $this->ZZMOBL
                ),
                'Name' => $this->wlfullname->WL_Name,
                'PhoneNumber' => $this->ZZOFTEL,
                'Room' => $this->ZZROMNO,
                'WorkLocationCode' => $this->ZZCODE,
            ];
        }

        return $data;
    }
}
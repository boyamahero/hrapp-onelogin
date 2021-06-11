<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkFromHome extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'BeginDate' => $this->BeginDate,
            'EndDate' => $this->EndDate,
            'BeginTime' => $this->BeginTime,
            'EndTime' => $this->EndTime,
        ];    
    }
}

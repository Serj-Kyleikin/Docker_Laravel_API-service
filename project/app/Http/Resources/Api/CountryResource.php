<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(isset($this->title)) {

            $resourse = [
                'status' => 'ok',
                'id' => $this->id,
                'country' => $this->title,
                'cities' => $this->city
            ];

        } else {

            $resourse = [
                'code' => $this['code']
            ];
        }

        return $resourse;
    }
}

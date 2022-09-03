<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public static $wrap = null;
    
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
                'status' => true,
                'id' => $this->id,
                'country' => $this->title,
                'cities' => $this->city
            ];

        } elseif($this['code'] == 422) {

            $resourse = [
                'status' => false,
                'message' => $this['message']
            ];

        } elseif($this['code'] == 201) {

            $resourse = [
                'status' => true,
                'id' => $this['id']
            ];

        } else $resourse = '';

        return $resourse;
    }
}

<?php

namespace App\Services;

use App\Models\Country;
use App\Models\City;
use App\Models\CountryCity;

class Service {

    public $country;
    public $status = false;

    public function addCountry($data) {

        $country = Country::firstOrCreate(
            ['title' =>  $data['title']]
        );

        if($country->wasRecentlyCreated) {

            if(isset($data['city']) and $data['city']) {

                $city = City::firstOrCreate(
                    ['title' =>  $data['city']]
                );

                if($city->wasRecentlyCreated) {

                    $add['country_id'] = $country->id;
                    $add['city_id'] = $city->id;

                    CountryCity::create($add);

                } else {

                    CountryCity::updateOrInsert(
                        ['city_id' =>  $city->id],
                        ['country_id' => $country->id]
                    );
                }
            }

            return $country;

        } else return 0;
    }

    public function updateCountry($entity, $data) {

        Country::where('title', $data['title'])->firstOr(function () use ($entity, $data) {
            $entity->update($data);
            $this->status = true;
        });

        return $this->status;
    }

    public function addCity($data) {
        
        $city = City::firstOrCreate(
            ['title' =>  $data['title']]
        );

        if($city->wasRecentlyCreated) {
            
            if(isset($data['country']) and $data['country']) {

                $country = Country::firstOrCreate(
                    ['title' =>  $data['country']]
                );

                $add['country_id'] = $country->id;
                $add['city_id'] = $city->id;

                CountryCity::create($add);
            }

            return 1;

        } else return 0;
    }

    public function updateCity($entity, $data) {

        $city = City::where('title', $data['title'])->firstOr(function () use ($entity, $data) {

            $insert['title'] = $data['title'];
            $entity->update($insert);
        });

        // Приоритет у новой созданной страны

        if(isset($data['country']) and $data['country']) {

            $country = Country::where('title', $data['country'])->firstOr(function () use ($data) {

                $insert['title'] = $data['country'];
                $this->country = Country::create($insert);
            });

            $id = ($country) ? $country->id : $this->country->id;

            CountryCity::updateOrInsert(
                ['city_id' => $entity->id],
                ['country_id' => $id]
            );

        } else {

            if(isset($data['country_id']) and $data['country_id']) {

                CountryCity::updateOrInsert(
                    ['city_id' => $entity->id],
                    ['country_id' => $data['country_id']]
                );

            } else CountryCity::where('city_id', $entity->id)->delete();
        }
    }
}
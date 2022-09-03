<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\City;
use App\Models\CountryCity;

class Service {

    public $country;

    public $messages = [
        'The service is not available',
        'The country already exists!',
        'The city already exists!'
    ];

    public function addCountry($data) 
    {
        DB::beginTransaction();

        try {

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

                $response = ['id' => $country->id, 'code' => 201];

            } else $response = ['message' => $this->messages[1], 'code' => 422];

            DB::commit();
            return $response;

        } catch(\Exception $exception) {

            DB::rollback();
            return ['message' => $this->messages[0], 'code' => 503];
        }
    }

    public function updateCountry($entity, $data) 
    {
        DB::beginTransaction();

        try {

            $status = Country::where('title', $data['title'])->firstOr(function () use ($entity, $data) {
                $entity->update($data);
            });

            DB::commit();
            return (isset($status->wasRecentlyCreated)) ? ['message' => $this->messages[1], 'code' => 422] : ['code' =>  204];

        } catch(\Exception $exception) {

            DB::rollback();
            return ['message' => $this->messages[0], 'code' => 503];
        }
    }

    public function addCity($data) 
    {
        DB::beginTransaction();

        try {
        
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

                $response = ['id' => $city->id, 'code' => 201];

            } else $response = ['message' => $this->messages[2], 'code' => 422];

            DB::commit();
            return $response;

        } catch(\Exception $exception) {

            DB::rollback();
            return ['message' => $this->messages[0], 'code' => 503];
        }
    }

    public function updateCity($entity, $data) 
    {
        DB::beginTransaction();

        try {

            City::where('title', $data['title'])->firstOr(function () use ($entity, $data) {

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

            DB::commit();
            return ['code' => 204];

        } catch(\Exception $exception) {

            DB::rollback();
            return ['message' => $this->messages[0], 'code' => 503];
        }
    }
}
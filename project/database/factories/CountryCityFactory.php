<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CountryCity;

class CountryCityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country_id' => $this->getCountryId(),
            'city_id' => $this->getCityId()
        ];
    }

    public static function getCountryId() {
        static $country_key = -1;
        $countries = ['1', '1', '2', '2', '3', '3', '4', '4', '5', '5'];
        $country_key++;
        return $countries[$country_key];
    }

    public static function getCityId() {
        static $country_key = 1;
        return $country_key++;
    }
}

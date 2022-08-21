<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Country;

class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Country::class;

    public function definition()
    {
        return [
            'title' => $this->getCountry()
        ];
    }

    public static function getCountry() {
        static $key = -1;
        $countries = ['Россия', 'Белоруссия', 'Казахстан', 'Англия', 'Франция'];
        $key++;
        return $countries[$key];
    }
}

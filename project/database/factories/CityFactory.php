<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\City;

class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = City::class;

    public function definition()
    {
        return [
            'title' => $this->getCity()
        ];
    }

    public static function getCity() {
        static $key = -1;
        $cities = ['Москва', 'Санкт-Петербург', 'Минск', 'Витебск', 'Астана', 'Актау', 'Лондон', 'Манчестер', 'Париж', 'Марсель'];
        $key++;
        return $cities[$key];
    }
}

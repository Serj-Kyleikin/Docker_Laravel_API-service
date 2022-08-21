<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    use Filterable;

    protected $guarded = false;

    public function city() {
        return $this->hasManyThrough(City::class, CountryCity::class, 'country_id', 'id', 'id', 'city_id');
    }
}

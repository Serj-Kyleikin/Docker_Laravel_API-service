<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    use Filterable;

    protected $guarded = false;

    public function country() {
        return $this->hasOneThrough(Country::class, CountryCity::class, 'city_id', 'id', 'id', 'country_id');
    }
}

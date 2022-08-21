<?php

namespace App\Http\Controllers\Api;

use App\Models\Country;
use App\Http\Filters\ApiFilter;
use App\Http\Requests\Api\FilterRequest;
use App\Http\Requests\Api\CountryRequest;
use App\Http\Requests\Api\UpdateCountryRequest;
use App\Http\Resources\Api\CountryResource;

class CountryController extends ApiController
{
    public function index(FilterRequest $request)
    {
        // Фильтрация get-параметров

        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;

        $data = $request->validated();
        $filter = app()->make(ApiFilter::class, ['queryParams' => array_filter($data)]);

        $countries = Country::filter($filter)->paginate($perPage, ['*'], 'page', $page);

        return CountryResource::collection($countries);
    }

    public function show(Country $entity)
    {
        return new CountryResource($entity);
    }

    public function add(CountryRequest $request)
    {
        $data = $request->validated();
        $response = $this->service->addCountry($data);

        $status = ($response) ? ['status' => 'created'] : ['status' => 'dublicate country'];
        return new CountryResource($status);
    }

    public function update(UpdateCountryRequest $request, Country $entity) 
    {
        $data = $request->validated();
        $response = $this->service ->updateCountry($entity, $data);

        $status = ($response) ? ['status' => 'dublicate country'] : ['status' => 'update'];
        return new CountryResource($status);
    }

    public function remove(Country $entity) 
    {
        $entity->delete();
        return new CountryResource(['status' => 'deleted']);;
    }
}
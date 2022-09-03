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
        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 5;

        $data = $request->validated();
        $filter = app()->make(ApiFilter::class, ['queryParams' => array_filter($data)]);

        $countries = Country::filter($filter)->paginate($perPage, ['*'], 'page', $page);

        return CountryResource::collection($countries);
    }

    public function store(CountryRequest $request)
    {
        $data = $request->validated();
        $response = $this->service->addCountry($data);

        $status = ($response) ? ['code' => 201] : ['code' => 422];
        return (new CountryResource($status))->response()->setStatusCode($status['code']);
    }

    public function show(Country $country)
    {
        return new CountryResource($country);
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $data = $request->validated();
        $response = $this->service->updateCountry($country, $data);

        $status = ($response) ? ['code' => 204] : ['code' => 422];
        return (new CountryResource($status))->response()->setStatusCode($status['code']);
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return (new CountryResource(['code' => 204]))->response()->setStatusCode(204);
    }
}

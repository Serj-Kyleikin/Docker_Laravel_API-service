<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Http\Requests\Api\CityRequest;
use App\Http\Requests\Api\UpdateCityRequest;
use App\Http\Resources\Api\CityResource;

class CityController extends ApiController
{
    public function index()
    {
        return new CityResource(['code' => 204]);
    }

    public function store(CityRequest $request)
    {
        $data = $request->validated();
        $response = $this->service->addCity($data);

        $status = ($response) ? ['code' => 201] : ['code' => 422];
        return new CityResource($status);
    }

    public function show(City $city)
    {
        return new CityResource($city);
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $data = $request->validated();
        $this->service ->updateCity($city, $data);

        return new CityResource(['code' => 204]);
    }

    public function destroy(City $city)
    {
        $city->delete();
        return new CityResource(['code' => 204]);
    }
}

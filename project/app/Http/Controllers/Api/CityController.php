<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Http\Requests\Api\CityRequest;
use App\Http\Requests\Api\UpdateCityRequest;
use App\Http\Resources\Api\CityResource;

class CityController extends ApiController
{
    public function show(City $entity)
    {
        return new CityResource($entity);
    }

    public function add(CityRequest $request)
    {
        $data = $request->validated();
        $response = $this->service->addCity($data);

        $status = ($response) ? ['status' => 'created'] : ['status' => 'dublicate city'];
        return new CityResource($status);
    }

    public function update(UpdateCityRequest $request, City $entity) 
    {
        $data = $request->validated();
        $response = $this->service ->updateCity($entity, $data);

        return new CityResource(['status' => 'update']);
    }

    public function remove(City $entity) 
    {
        $entity->delete();
        return new CityResource(['status' => 'deleted']);
    }
} 
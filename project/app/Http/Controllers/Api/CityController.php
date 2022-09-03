<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Models\City;
use App\Http\Requests\Api\CityRequest;
use App\Http\Requests\Api\UpdateCityRequest;
use App\Http\Resources\Api\CityResource;

class CityController extends ApiController
{
    public $messages = [
        'The service is not available'
    ];

    public function index()
    {
        return response()->json('', 204);
    }

    public function store(CityRequest $request)
    {
        $data = $request->validated();
        $response = $this->service->addCity($data);

        return (new CityResource($response))->response()->setStatusCode($response['code']);
    }

    public function show(City $city)
    {
        return new CityResource($city);
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $data = $request->validated();
        $response = $this->service->updateCity($city, $data);

        return (new CityResource($response))->response()->setStatusCode($response['code']);
    }

    public function destroy(City $city)
    {
        DB::beginTransaction();

        try {

            $city->delete();
            DB::commit();

            return response()->json('', 204);

        } catch(\Exception $exception) {

            DB::rollback();
            return response()->json(["message" => $this->messages[0]], 503);
        }
    }
}
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Http\Filters\ApiFilter;
use App\Http\Requests\Api\FilterRequest;
use App\Http\Requests\Api\CountryRequest;
use App\Http\Requests\Api\UpdateCountryRequest;
use App\Http\Resources\Api\CountryResource;

class CountryController extends ApiController
{
    public $messages = [
        'The service is not available'
    ];

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

        return (new CountryResource($response))->response()->setStatusCode($response['code']);
    }

    public function show(Country $country)
    {
        return new CountryResource($country);
    }

    public function update(UpdateCountryRequest $request, Country $country)
    {
        $data = $request->validated();
        $response = $this->service->updateCountry($country, $data);

        return (new CountryResource($response))->response()->setStatusCode($response['code']);
    }

    public function destroy(Country $country)
    {
        DB::beginTransaction();

        try {

            $country->delete();
            DB::commit();

            return response()->json('', 204);

        } catch(\Exception $exception) {

            DB::rollback();
            return response()->json(["message" => $this->messages[0]], 503);
        }
    }
}

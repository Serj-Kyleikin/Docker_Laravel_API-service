<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return 'Welcome!!';
});

Route::get('/api', 'Api\CountryController@index');
Route::get('/api/country/{entity}', 'Api\CountryController@show');
Route::get('/api/city/{entity}', 'Api\CityController@show');

Route::patch('/api/country/{entity}', 'Api\CountryController@update');
Route::patch('/api/city/{entity}', 'Api\CityController@update');

Route::delete('/api/country/{entity}', 'Api\CountryController@remove');
Route::delete('/api/city/{entity}', 'Api\CityController@remove');

Route::post('/api/country/create', 'Api\CountryController@add');
Route::post('/api/city/create', 'Api\CityController@add');

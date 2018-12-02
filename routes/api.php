<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::apiResource('cars', 'API\CarsController');

Route::apiResource('tickets', 'API\TicketsController');

Route::apiResource('carstype', 'API\CarsTypeController');

Route::apiResource('drivers', 'API\DriversController');

Route::get('carstype', 'API\TicketsController@carstype');

Route::get('carstype', 'API\TicketsController@carstype');

Route::get('car_serch/{key_serch}', 'API\CarsController@Serch');

Route::get('carscolors', 'API\CarsController@carscolor');

Route::get('carstatus', 'API\CarsController@carstatus');

Route::get('car_statusid/{id}', 'API\CarsController@CarsByStatusId');
Route::get('car_typeid/{id}', 'API\CarsController@CarsByTypeId');


Route::get('cars_orders', 'API\CarsController@cars_orders');

Route::put('carsupdatstatus/{id}', 'API\CarsController@updatestatus');


Route::get('tickets_booked', 'API\TicketsController@tickets_booked');


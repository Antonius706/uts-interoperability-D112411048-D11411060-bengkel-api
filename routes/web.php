<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Support\ApiResponse;
use Illuminate\Http\Request;

$router->get('/', function (Request $request) {
    return ApiResponse::make($request, [
        'service_name' => 'UTS Interoperability - Bengkel API',
        'status'       => 'Running',
    ]);
});

// ---- GET: publik ----
$router->get('/customers', 'CustomersController@index');
$router->get('/customers/{id}', 'CustomersController@show');
$router->get('/repairs', 'RepairsController@index');          // ?customer_id=1
$router->get('/repairs/{id}', 'RepairsController@show');

// ---- INSERT / UPDATE / DELETE: wajib Basic Auth ----
$router->group(['middleware' => 'basic.auth'], function () use ($router) {
    $router->post('/customers', 'CustomersController@store');
    $router->put('/customers/{id}', 'CustomersController@update');
    $router->delete('/customers/{id}', 'CustomersController@destroy');

    $router->post('/repairs', 'RepairsController@store');
    $router->put('/repairs/{id}', 'RepairsController@update');
    $router->delete('/repairs/{id}', 'RepairsController@destroy');
});

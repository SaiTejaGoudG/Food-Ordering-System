<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\FoodOrdersController;




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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('foods', [FoodController::class, 'index'] );
Route::post('foods', [FoodController::class, 'store'] );
Route::get('foods/{state}', [FoodController::class, 'show'] );

Route::get('foodOrders', [FoodOrdersController::class, 'index'] );
Route::post('foodOrders', [FoodOrdersController::class, 'store'] );
Route::post('foodOrders-payOrder', [FoodOrdersController::class, 'payOrder'] );
Route::get('orders/pdf', [FoodOrdersController::class, 'downloadPDF']);
Route::get('foodOrders/{id}', [FoodOrdersController::class, 'show'] );

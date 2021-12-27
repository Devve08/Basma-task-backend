<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControlller;

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


// Costumer Routes //

Route::group(['prefix' => 'users'], function () {
    Route::post('/register', ['App\Http\Controllers\UserController', 'register']);
    Route::post('/login', ['App\Http\Controllers\UserController', 'login']);


    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::post('/logout', ['App\Http\Controllers\UserController', 'logout']);
    });
});

// Admin Routes //

Route::group(['prefix' => 'admins'], function () {
    Route::post('/register', ['App\Http\Controllers\AdminController', 'register']);
    Route::post('/login', ['App\Http\Controllers\AdminController', 'login']);


    Route::group(['middleware' => ['jwt.admin']], function () {
        Route::post('/logout', ['App\Http\Controllers\AdminController', 'logout']);
        Route::get('/costumers/{num}', ['App\Http\Controllers\AdminController', 'index']);
        Route::delete('/customers/{id}', ['App\Http\Controllers\AdminController', 'destroy']);
        Route::get('/searchbyname', ['App\Http\Controllers\SearchController', 'searchByName']);
        Route::get('/searchbyemail', ['App\Http\Controllers\SearchController', 'searchByEmail']);
        Route::get('/searchbyid', ['App\Http\Controllers\SearchController', 'searchById']);
        Route::get('/lastday', ['App\Http\Controllers\SearchController', 'lastday']);
        Route::get('/lastweek', ['App\Http\Controllers\SearchController', 'lastweek']);
        Route::get('/lastmonth', ['App\Http\Controllers\SearchController', 'lastmonth']);
        Route::get('/lastthreemonths', ['App\Http\Controllers\SearchController', 'lastthreemonths']);
        Route::get('/lastyear', ['App\Http\Controllers\SearchController', 'lastyear']);
    });
});

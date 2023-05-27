<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use Tymon\JWTAuth\Contracts\Providers\Auth;

Route::apiResource('/member', MemberController::class);
Route::apiResource('/cost', CostController::class);
Route::apiResource('/accounts', AccountController::class);



Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function () {

    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/me', 'AuthController@me');
    Route::post('/payload', 'AuthController@payload');
    Route::post('/register', 'AuthController@register');
});

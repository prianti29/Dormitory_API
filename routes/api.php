<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MealController;
use Tymon\JWTAuth\Contracts\Providers\Auth;



Route::resource('/member', MemberController::class);
// Route::get('/member/create', [MemberController::class, 'create']);
// Route::get("/member", MemberController::class);
Route::apiResource('/cost', CostController::class);
Route::apiResource('/accounts', AccountController::class);
Route::resource('/meal', MealController::class);
// api/meal/monthly-count
Route::get('/monthly-count', [MealController::class, 'monthlyCount']);
Route::get('/monthly-cost', [CostController::class, 'monthlyCost']);
Route::get('/meal-rate', [CostController::class, 'mealRate']);
Route::get('/expense', [CostController::class, 'expenseCount']);
Route::get('/perHead-deposit', [AccountController::class, 'perHeadDeposit']);

Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'as' => 'auth.'
], function () {
    Route::get('/dashboard', function (Request $request) {
        return view('dashboard');
    });
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/me', 'AuthController@me');
    Route::post('/payload', 'AuthController@payload');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

<?php

use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\TransfusionPointController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {



    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user', [AuthController::class, 'user']);

});

Route::group(['middleware' => ['jwt.verify']], function(){
    Route::put('/users-update', [UserController::class, 'userUpdate']);

    Route::get('/my-blood-points', [TransfusionPointController::class, 'listBloodPoints']);
    Route::get('/missing-blood', [TransfusionPointController::class, 'missingBlood']);
    Route::get('/honorary-donors', [UserController::class, 'honoraryDonors']);
    Route::get('/possibility-donation', [UserController::class, 'possibilityDonation']);
});

Route::group(['middleware' => ['jwt.verify', 'admin']], function(){
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/admin-users/{id}', [UserController::class, 'adminUpdate']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    Route::get('/transfusion-points', [TransfusionPointController::class, 'index']);
    Route::post('/transfusion-points', [TransfusionPointController::class, 'store']);
    Route::get('/transfusion-points/{id}', [TransfusionPointController::class, 'show']);
    Route::put('/transfusion-points/{id}', [TransfusionPointController::class, 'update']);
    Route::delete('/transfusion-points/{id}', [TransfusionPointController::class, 'destroy']);

    Route::get('/donations', [DonationController::class, 'index']);
    Route::post('/donations', [DonationController::class, 'store']);
    Route::get('/donations/{id}', [DonationController::class, 'show']);
    Route::put('/donations/{id}', [DonationController::class, 'update']);
    Route::delete('/donations/{id}', [DonationController::class, 'destroy']);
});






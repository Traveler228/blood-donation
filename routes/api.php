<?php

use App\Http\Controllers\Api\BloodTypeTransfusionPointController;
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
    Route::get('/my-blood-points', [UserController::class, 'listBloodPoints']);
    Route::get('/missing-blood', [TransfusionPointController::class, 'missingBlood']);
    Route::get('/honorary-donors', [UserController::class, 'honoraryDonors']);
    Route::get('/possibility-donation', [UserController::class, 'possibilityDonation']);

});

Route::group(['middleware' => ['jwt.verify', 'admin']], function(){
    Route::apiResources([
        'users' => UserController::class,
        'transfusion-points' => TransfusionPointController::class,
        'donations' => DonationController::class,
    ]);

});






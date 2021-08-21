<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::group(['middleware' => ['auth:api']],function(){
    Route::post('/profile', [AuthController::class, 'userProfile']);
    Route::post('/update-profile', [AuthController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::group(['middleware' => ['auth:api','RoleIsValid']],function(){
    Route::apiResource('students',StudentController::class);
    Route::post('/checkToken', [AuthController::class, 'checkToken']);
});

<?php

use App\Http\Controllers\Api\Attendances\ScheduleController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 認証前でもOK
Route::get('/tasks', [TaskController::class, 'index']);
Route::post('/tokens/create', function(Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});

// 認証済みでないと許可しない
Route::group(["middleware" => ["auth:sanctum"]], function() {
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::get('/users/{user}/attendances/monthsHasSchedule', [UserController::class, 'monthsHasSchedule']);
    Route::get('/users/{user}/attendances/schedules', [ScheduleController::class, 'index']);

    // 管理者以上
    Route::group(['middleware' => ['auth', 'can:manager']], function() {
        Route::post('/users', [UserController::class, 'store']);
        Route::post('/users/{user}/attendances/schedules', [ScheduleController::class, 'store']);
    });
});

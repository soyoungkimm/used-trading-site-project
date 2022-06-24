<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
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

// 채팅
Route::prefix('messages')->group(function () {
    Route::post('/', [MessageController::class, 'store']);
    Route::get('/', [MessageController::class, 'index']);
    Route::get('/chatList', [MessageController::class, 'chatList']);
    Route::get('/getUserName', [MessageController::class, 'getUserName']);
});


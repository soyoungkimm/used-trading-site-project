<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminGoodsController;
use App\Http\Controllers\AdminReviewsController;
use App\Http\Controllers\AdminUsersController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


// admin users
Route::resource('admin/users', AdminUsersController::class);
Route::post('admin/users/checkUid', 'App\Http\Controllers\AdminUsersController@checkUid')->name('users.checkUid');

// admin goods
Route::resource('admin/goods', AdminGoodsController::class);

// admin reviews
Route::resource('admin/reviews', AdminReviewsController::class);
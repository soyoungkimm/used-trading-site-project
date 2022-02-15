<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminGoodsController;

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
Route::get('admin/users', 'App\Http\Controllers\AdminUsersController@index');
Route::get('admin/users/view/{id}', 'App\Http\Controllers\AdminUsersController@view')->name('user.view');
Route::get('admin/users/edit/{id}', 'App\Http\Controllers\AdminUsersController@edit')->name('user.edit');
Route::post('admin/users/delete', 'App\Http\Controllers\AdminUsersController@delete')->name('user.delete');
Route::post('admin/users', 'App\Http\Controllers\AdminUsersController@update')->name('user.update');
Route::get('admin/users/create', 'App\Http\Controllers\AdminUsersController@create')->name('user.create');
Route::post('admin/users/store', 'App\Http\Controllers\AdminUsersController@store')->name('user.store');;
Route::post('admin/users/checkUid', 'App\Http\Controllers\AdminUsersController@checkUid')->name('user.checkUid');

// admin goods
Route::resource('admin/goods', AdminGoodsController::class);
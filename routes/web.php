<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminGoodsController;
use App\Http\Controllers\AdminReviewsController;
use App\Http\Controllers\AdminReviewCommentsController;
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AdminAdsController;
use App\Http\Controllers\AdminNoticesController;
use App\Http\Controllers\AdminQuestionsController;
use App\Http\Controllers\AdminQuestionCommentsController;
use App\Http\Controllers\AdminHeartGoodsController;
use App\Http\Controllers\AdminTagsController;
use App\Http\Controllers\AdminAlarmsController;
use App\Http\Controllers\AdminCategoryController;


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

// admin review_comments
Route::resource('admin/review_comments', AdminReviewCommentsController::class);

// admin advertise
Route::resource('admin/advertise', AdminAdsController::class);

// admin notice
Route::resource('admin/notice', AdminNoticesController::class);

// admin questions
Route::resource('admin/questions', AdminQuestionsController::class);

// admin question_comments
Route::resource('admin/question_comments', AdminQuestionCommentsController::class);

// admin heart_goods
Route::resource('admin/heart-goods', AdminHeartGoodsController::class);

// admin tags
Route::resource('admin/tags', AdminTagsController::class);

// admin tags
Route::resource('admin/alarm', AdminAlarmsController::class);

// admin categorys
Route::resource('admin/category', AdminCategoryController::class);
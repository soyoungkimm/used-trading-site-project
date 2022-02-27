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
use App\Http\Controllers\AdminCategoryDeController;
use App\Http\Controllers\AdminCategoryDeDeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminToDoListsController;
use App\Http\Controllers\GoodsController;

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


// admin 
Route::prefix('admin')->group(function () {
    
    Route::resources([
        'users' => AdminUsersController::class,
        'goods' => AdminGoodsController::class,
        'reviews' => AdminReviewsController::class,
        'review_comments' => AdminReviewCommentsController::class,
        'advertise' => AdminAdsController::class,
        'notice' => AdminNoticesController::class,
        'questions' => AdminQuestionsController::class,
        'question_comments' => AdminQuestionCommentsController::class,
        'heart-goods' => AdminHeartGoodsController::class,
        'tags' => AdminTagsController::class,
        'alarm' => AdminAlarmsController::class,
        'category' => AdminCategoryController::class,
        'category-de' => AdminCategoryDeController::class,
        'category-de-de' => AdminCategoryDeDeController::class,
        'todo_lists' => AdminToDoListsController::class,
    ]);

    // dashboard
    Route::get('/', AdminDashboardController::class);

    // users check uid
    Route::post('users/checkUid', 'App\Http\Controllers\AdminUsersController@checkUid')->name('users.checkUid');
});



// site main
Route::get('/', function () {
    return view('sites.main');
});



// site goods 
Route::prefix('goods')->group(function () {
    
    Route::resource('/', GoodsController::class);

    // ajax
    Route::post('upload', [GoodsController::class, 'ajax_upload_image'])->name('upload_image');
    Route::post('delete_image', [GoodsController::class, 'ajax_delete_image'])->name('delete_image');
    Route::post('find_adress', [GoodsController::class, 'ajax_find_adress'])->name('find_adress');
});
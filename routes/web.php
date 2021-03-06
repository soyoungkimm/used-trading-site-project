<?php

use App\Http\Controllers\NoticesController;
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
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\GoodsController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\QuestionCommentsController;
use App\Http\Controllers\HeartGoodsController;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MainController;
use App\Events\MyEvent;
use App\Http\Controllers\PayController;
use App\Http\Controllers\CalculatesController;
use App\Http\Controllers\ShopController;

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
    Route::group(['middleware' => 'adminCheck'], function(){
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
        Route::post('users/checkUid', 'App\Http\Controllers\AdminUsersController@checkUid')->name('users.checkUid'); // users check uid
        Route::get('/', AdminDashboardController::class); // dashboard
    });

    // users login, logout
    Route::POST('loginCheck', 'App\Http\Controllers\AdminUsersController@login')->name('admin.loginCheck');
    Route::get('login', 'App\Http\Controllers\AdminUsersController@loginForm')->name('admin.loginForm');
    Route::get('logout', 'App\Http\Controllers\AdminUsersController@logout')->name('admin.logout');
});

// site main
Route::get('/', [MainController::class, 'main']);

// site resource
Route::resources([
    'goods' => GoodsController::class,
    'questions' => QuestionsController::class,
    'question_comments' => QuestionCommentsController::class,
]);

// site goods
Route::prefix('goods')->group(function () {
    Route::post('upload', [GoodsController::class, 'ajax_upload_image'])->name('upload_image');
    Route::post('delete_image', [GoodsController::class, 'ajax_delete_image'])->name('delete_image');
    Route::post('find_adress', [GoodsController::class, 'ajax_find_adress'])->name('find_adress');
    Route::post('delete_tag', [GoodsController::class, 'ajax_delete_tag'])->name('delete_tag');
});

// site heart_goods
Route::prefix('hearts')->group(function () {
    Route::post('/', [HeartGoodsController::class, 'store']);
    Route::delete('delete', [HeartGoodsController::class, 'destroy']);
});

// site follows
Route::prefix('follows')->group(function () {
    Route::post('/', [FollowsController::class, 'store']);
    Route::delete('delete', [FollowsController::class, 'destroy']);
});

// site notices
Route::prefix('notices')->group(function () {
    Route::get('/', [NoticesController::class, 'index']);
    Route::get('/{notice}', [NoticesController::class, 'show']);
});

// site user
Route::prefix('users')->group(function () {
    Route::get('/edit', [UsersController::class, 'edit']);//?????????????????? ???
    Route::put('/{user}', [UsersController::class, 'update']);//??????????????????
    Route::get('/show', [UsersController::class, 'show']);//??????????????????
    Route::get('/login', [UsersController::class, 'loginForm'])->name('login');//????????? ???
    Route::POST('/login', [UsersController::class, 'login']);// ?????????
    Route::get('/logout', [UsersController::class, 'logout']);//????????????
    Route::get('/register', [UsersController::class, 'register']);//???????????? ???
    Route::POST('/store', [UsersController::class, 'store']);//????????????
    Route::DELETE('/delete', [UsersController::class, 'destroy']);//?????? ??????
    Route::post('checkUid', [UsersController::class, 'checkUid'])->name('users.checkUid'); // users check uid
    Route::get('/getCurrentUser', [UsersController::class, 'getCurrentUser']);// ?????? ???????????? ?????? ?????? ????????????
    Route::get('/calculate/{id}', [CalculatesController::class, 'show'])->middleware('auth'); // ?????? ?????? ????????????
});


// chatting
Route::get('/chatting/{chatWith?}', function($chatWith = null) {
    return view('sites.chats.chatting', ['chatWith' => $chatWith ]);
})->middleware('auth');


// pay
Route::prefix('pay')->group(function () {
    Route::get('/getMerchantUidAndSetPrice', [PayController::class, 'getMerchantUidAndSetPrice']);
    Route::post('/complete', [PayController::class, 'complete']);
    Route::post('/removePayAuth', [PayController::class, 'removePayAuth']);
});

// site shop
Route::prefix('shop')->group(function () {
    Route::GET('/main/{id}', [ShopController::class, 'main']);//????????????
    Route::GET('/manage', [ShopController::class, 'manage']);//????????????
    Route::GET('/log/{user}', [ShopController::class, 'log']);//??????/?????? ??????

    //ajax
    Route::PUT('/update_StoreIntro', [ShopController::class, 'ajax_edit_intro']);//???????????? ??????
    Route::PUT('/update_StoreName', [ShopController::class, 'ajax_edit_storename']);//???????????? ??????
    Route::PUT('/update_saleStatus', [ShopController::class, 'ajax_saleStatus']);//???????????? ??????
    Route::POST('/ajax_heart', [ShopController::class, 'ajax_hearts']);//??? ???
    Route::POST('/ajax_good', [ShopController::class, 'ajax_goods']);//?????? ???
    Route::POST('/ajax_manage', [ShopController::class, 'ajax_managing']);//???????????? ????????? ??????
    Route::POST('/ajax_payHistory', [ShopController::class, 'ajax_payHistory']);//???????????? ????????? ??????
    Route::POST('/ajax_updateBuyConfirm', [ShopController::class, 'updateBuyConfirm']);//???????????? ??????
});

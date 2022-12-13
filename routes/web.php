<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ConstructionsController;
use App\Http\Controllers\LayoutsController;
use App\Http\Controllers\ConstructionPlansController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\KanrisController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'auth'], function () {

    // 物件概要-----------------------------------------------------------
    //登録画面
    Route::get('/property/new', [PropertiesController::class, 'create'])
    ->name('propertyNew');

    //登録処理
    Route::post('/property/store', [PropertiesController::class, 'store'])
    ->name('propertyStore');

    //一覧表示
    Route::get('/property/list', [PropertiesController::class, 'index'])
    ->name('propertyList');

    //一覧表示-絞り込み
    Route::post('/property/list/search', [PropertiesController::class, 'search'])
    ->name('propertySearch');




    //詳細画面
    Route::get('/property/detail/{id}', [PropertiesController::class, 'show'])
    ->name('propertyDetail');

    //更新処理
    Route::post('/property/update', [PropertiesController::class, 'update'])
    ->name('propertyUpdate');



    // 収支計画-----------------------------------------------------------
    //登録画面
    Route::post('/project/new', [ProjectController::class, 'create'])
    ->name('projectNew');

    //登録処理
    Route::post('/project/store', [ProjectController::class, 'store'])
    ->name('projectStore');

    //登録処理
    Route::post('/project/copy', [ProjectController::class, 'copy'])
    ->name('projectCopy');

    //詳細画面
    Route::get('/project/{id}', [ProjectController::class, 'show'])
    ->name('projectDetail');

    //更新処理
    Route::post('/project/update', [ProjectController::class, 'update'])
    ->name('projectUpdate');

    //一覧表示
    Route::get('/list', [ProjectController::class, 'index'])
    ->name('projectList');

    //一覧表示-絞り込み
    Route::post('/list/search', [ProjectController::class, 'search'])
    ->name('projectSearch');

    //削除処理
    Route::delete('/project/delete/{id}', [ProjectController::class, 'destroy'])
    ->name('projectDelete');


    //収支計画
    Route::get('/plan/{id}', [ProjectController::class, 'plan'])
    ->name('projectPlan');

    //PDF
    Route::get('/pdf/{id}', [ProjectController::class, 'pdf'])
    ->name('projectPdf');



    //ダッシュボード
    Route::get('/', [DashboardsController::class, 'dashboard'])
    ->name('dashboard');

    //設定ページ
    Route::get('/setting', [SettingController::class, 'setting'])
    ->name('setting');

    //登録処理
    Route::post('/construction/store', [ConstructionsController::class, 'store'])
    ->name('constructionStore');
    //削除処理
      // 削除
    Route::delete('/construction/delete/{id}', [ConstructionsController::class, 'destroy'])
    ->name('constructionDelete');

    //登録処理
    Route::post('/layout/store', [LayoutsController::class, 'store'])
    ->name('layoutStore');
    //削除処理
        // 削除
    Route::delete('/layout/delete/{id}', [LayoutsController::class, 'destroy'])
    ->name('layoutDelete');

    //登録処理
    Route::post('/constructionPlan/store', [ConstructionPlansController::class, 'store'])
    ->name('constructionPlanStore');
    //削除処理
        // 削除
    Route::delete('/constructionPlan/delete/{id}', [ConstructionPlansController::class, 'destroy'])
    ->name('constructionPlanDelete');

    //登録処理
    Route::post('/bank/store', [BanksController::class, 'store'])
    ->name('bankStore');
    //削除処理
        // 削除
    Route::delete('/bank/delete/{id}', [BanksController::class, 'destroy'])
    ->name('bankDelete');


    //設定ページ
    Route::get('/user', [KanrisController::class, 'kanri'])
    ->name('kanri');




    Route::get('/hello', function () {
        return PDF::loadHTML('<h1>Hello!</h1>')->inline();
    });

    Route::get('/output/pdf', [ProjectController::class, 'output']);


});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

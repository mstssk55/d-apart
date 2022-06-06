<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardsController;
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


    // 収支計画-----------------------------------------------------------
    //登録画面
    Route::post('/project/new', [ProjectController::class, 'create'])
    ->name('projectNew');

    //登録処理
    Route::post('/project/store', [ProjectController::class, 'store'])
    ->name('projectStore');

    //詳細画面
    Route::get('/project/{id}', [ProjectController::class, 'show'])
    ->name('projectDetail');

    //更新処理
    Route::post('/project/update', [ProjectController::class, 'update'])
    ->name('projectUpdate');

    //一覧表示
    Route::get('/list', [ProjectController::class, 'index'])
    ->name('projectList');


    //ダッシュボード
    Route::get('/', [DashboardsController::class, 'dashboard'])
    ->name('dashboard');


});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

<?php

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
    return view('top');
});

Auth::routes();

// ホーム画面を表示
Route::get('/home', 'RecordController@home')->name('home');

// 履歴画面を表示
Route::get('/index', 'RecordController@index')->name('index');

// 記録フォームを表示
Route::get('/record/new', 'RecordController@new')->name('new');

// 収支の記録
Route::post('/record/create', 'RecordController@create')->name('create');

// 記録詳細画面を表示
Route::get('/record/{id}', 'RecordController@show')->name('show');

// 編入画面を表示
Route::get('/record/edit/{id}', 'RecordController@edit')->name('edit');

// 記録の更新
Route::post('/record/update', 'RecordController@update')->name('update');

// 記録の削除
Route::post('/record/delete/{id}', 'RecordController@delete')->name('delete');

// カテゴリー登録フォームを表示
Route::get('/category/new', 'CategoryController@new')->name('categoryNew');

// カテゴリー登録
Route::post('/category/create', 'CategoryController@create')->name('categoryCreate');

// カテゴリー一覧を表示
Route::get('/category/index', 'CategoryController@index')->name('categoryIndex');

// カテゴリー編集画面を表示
Route::get('/category/edit/{id}', 'CategoryController@edit')->name('categoryEdit');

// カテゴリー一覧を表示
Route::post('/category/update', 'CategoryController@update')->name('categoryUpdate');

// カテゴリーの削除
Route::post('/category/delete/{id}', 'CategoryController@delete')->name('categoryDelete');

// 日付範囲検索
Route::get('/search', 'SearchController@search')->name('search');

Route::get('/search/data', 'SearchController@searchData')->name('searchData');

// 年別検索
Route::get('/search/{period}', 'SearchController@searchPeriod')->name('searchPeriod');

// 予算の一覧表示
Route::get('/budgets', 'BudgetController@index')->name('budgetIndex');

// 予算の作成フォーム表示
Route::get('/budget/new', 'BudgetController@new')->name('budgetNew');

// 予算作成
Route::post('/budget/create', 'BudgetController@create')->name('budgetCreate');

// 予算の編集フォーム表示
Route::get('/budget/edit/{id}', 'BudgetController@edit')->name('budgetEdit');

// 予算の更新
Route::post('/budget/update', 'BudgetController@update')->name('budgetUpdate');

// 予算の削除
Route::post('/budget/{id}', 'BudgetController@delete')->name('budgetDelete');

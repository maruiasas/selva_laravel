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

Auth::routes();

// ホーム画面
Route::get('/', function () { return view('logout'); });
Route::get('/', function () { return view('home'); });

// 会員登録
Route::get('/confirm', 'Auth\RegisterController@confirm')->name('confirm');
Route::post('/confirm', 'Auth\RegisterController@confirm')->name('confirm');
Route::get('/complete', 'Auth\RegisterController@complete')->name('complete');
Route::post('/complete', 'Auth\RegisterController@complete')->name('complete');
// Route::get('/', 'HomeController@home')->name('home');
Route::post('/', 'Auth\RegisterController@home')->name('home');

Auth::routes(['verify' => true]);

Route::get('profile', function () {
})->middleware('verified');

// 商品登録
Route::get('/products/register', 'ProductsController@ProductForm')->name('products.register')->middleware('auth');
Route::get('/products/confirm', 'ProductsController@ProdutConfirm')->name('products.confirm')->middleware('auth');
Route::post('/products/confirm', 'ProductsController@ProductConfirm')->name('products.confirm')->middleware('auth');
Route::post('/', 'ProductsController@ProductComplete')->name('products.complete')->middleware('auth');

Route::get('/products/category', 'ProductsController@ProductCategoryAjax');
Route::post('/products/category', 'ProductsController@ProductCategoryAjax');

Route::get('/products/upload', 'ProductsController@uploadAjax');
Route::post('/products/upload', 'ProductsController@uploadAjax');

//商品検索
Route::get('/products/list', 'ProductsController@productlist')->name('products.list');
Route::post('/products/list', 'ProductsController@productlist')->name('products.list');

// 商品の詳細
Route::get('/show/{id}', 'ProductsController@show')->name('products.show');
Route::post('/show/{id}', 'ProductsController@show')->name('products.show');

// 商品レビュー登録
Route::get('/review/regist/{id}', 'ProductsController@reviewregist')->name('products.reviewregist')->middleware('auth');
Route::get('/review/confirm', 'ProductsController@reviewconfirm')->name('products.reviewconfirm')->middleware('auth');
Route::post('/review/confirm', 'ProductsController@reviewconfirm')->name('products.reviewconfirm')->middleware('auth');
Route::post('/review/complete', 'ProductsController@reviewcomplete')->name('products.reviewcomplete')->middleware('auth');

// 商品レビュー一覧
Route::get('/products/review/{id}', 'ProductsController@review')->name('products.review')->middleware('auth');
Route::post('/products/review/{id}', 'ProductsController@review')->name('products.review')->middleware('auth');

// マイページ
Route::get('/mypage', 'ProductsController@mypage')->name('mypage')->middleware('auth');
Route::post('/mypage', 'ProductsController@mypage')->name('mypage')->middleware('auth');

// 退会ページ
Route::get('/withdrawal', 'ProductsController@withdrawal')->name('withdrawal');
Route::post('/withdrawal', 'ProductsController@withdrawal')->name('withdrawal');

// 退会機能
Route::get('/destroy', 'ProductsController@destroy')->name('destroy');
Route::post('/destroy', 'ProductsController@destroy')->name('destroy');
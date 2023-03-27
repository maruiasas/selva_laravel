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

Route::get('/', function () { return view('logout'); });
Route::get('/', function () { return view('home'); });
Route::get('/confirm', 'Auth\RegisterController@confirm')->name('confirm');
Route::post('/confirm', 'Auth\RegisterController@confirm')->name('confirm');
Route::get('/complete', 'Auth\RegisterController@complete')->name('complete');
Route::post('/complete', 'Auth\RegisterController@complete')->name('complete');
Route::post('/', 'Auth\RegisterController@home')->name('home');

Auth::routes(['verify' => true]);

Route::get('profile', function () {
})->middleware('verified');

Route::get('/products/register', 'Auth\ProductController@ProductForm')->name('products.register');
Route::get('/products/confirm', 'Auth\ProductController@ProduConfirm')->name('products.confirm');
Route::post('/products/confirm', 'Auth\ProductController@ProductConfirm')->name('products.confirm');

<?php

Auth::routes();

// ホーム画面
Route::get('/', function () { return view('logout'); });
Route::get('/', function () { return view('home'); });
Route::post('/', 'Auth\RegisterController@home')->name('home');
Route::get('/', 'HomeController@home')->name('home');

// 会員登録
Route::get('/confirm', 'Auth\RegisterController@confirm')->name('confirm');
Route::post('/confirm', 'Auth\RegisterController@confirm')->name('confirm');
Route::get('/complete', 'Auth\RegisterController@complete')->name('complete');
Route::post('/complete', 'Auth\RegisterController@complete')->name('complete');

Auth::routes(['verify' => true]);

Route::get('profile', function () {
})->middleware('verified');

// マイページ
Route::get('/mypage', 'MembersController@mypage')->name('mypage')->middleware('auth');
Route::post('/mypage', 'MembersController@mypage')->name('mypage')->middleware('auth');

// 退会ページ
Route::get('/withdrawal', 'MembersController@withdrawal')->name('withdrawal');
Route::post('/withdrawal', 'MembersController@withdrawal')->name('withdrawal');

// 退会機能
Route::get('/destroy', 'MembersController@destroy')->name('destroy');
Route::post('/destroy', 'MembersController@destroy')->name('destroy');

// 会員情報変更
Route::get('/update', 'MembersController@update')->name('update');
Route::get('/updateconfirm', 'MembersController@updateconfirm')->name('updateconfirm');
Route::post('/updateconfirm', 'MembersController@updateconfirm')->name('updateconfirm');
Route::post('/updatecomplete', 'MembersController@updatecomplete')->name('updatecomplete');

// パスワード変更
Route::get('/password/change','ChangePasswordController@edit')->name('passwordform')->middleware('auth');
Route::post('/password/change','ChangePasswordController@change')->name('passwordform')->middleware('auth');

// メールアドレス変更
Route::get('/email/change','ChangeEmailController@edit')->name('emailform')->middleware('auth');
Route::match(['get', 'post'], '/emailconfirm', 'ChangeEmailController@change')->name('emailconfirm')->middleware('auth');
Route::post('/emailcomplete','ChangeEmailController@complete')->name('emailcomplete')->middleware('auth');

// 商品登録
Route::get('/products/register', 'ProductsController@ProductForm')->name('products.register')->middleware('auth');
Route::get('/products/confirm', 'ProductsController@ProdutConfirm')->name('products.confirm')->middleware('auth');
Route::post('/products/confirm', 'ProductsController@ProductConfirm')->name('products.confirm')->middleware('auth');
Route::post('/', 'ProductsController@ProductComplete')->name('products.complete')->middleware('auth');

Route::get('/products/category', 'ProductsController@categoryAjax');
Route::post('/products/category', 'ProductsController@categoryAjax');

// Route::get('/products/upload', 'ProductsController@uploadAjax');
// Route::post('/products/upload', 'ProductsController@uploadAjax');

//商品一覧・検索
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
Route::get('/products/review/{id}', 'ProductsController@review')->name('products.review');
Route::post('/products/review/{id}', 'ProductsController@review')->name('products.review');

// 商品レビュー管理
Route::get('/review/master','ReviewsController@list')->name('reviews.master')->middleware('auth');
Route::get('/review/edit/{id}','ReviewsController@edit')->name('reviews.edit')->middleware('auth');
Route::match(['get', 'post'], '/review/masterconfirm', 'ReviewsController@confirm')->name('reviews.confirm')->middleware('auth');
Route::post('/review/update', 'ReviewsController@update')->name('reviews.update')->middleware('auth');

Route::get('/review/delete/{id}','ReviewsController@delete')->name('reviews.delete')->middleware('auth');
Route::post('/review/deletecomplete','ReviewsController@deletecomplete')->name('reviews.deletecomplete')->middleware('auth');


// 管理画面
Route::get('/admin/login', 'Auth\LoginController@showAdminLoginForm');
Route::post('/admin/login', 'Auth\LoginController@adminLogin');

Route::get('/admin/logout', 'Auth\LoginController@logout');

Route::get('/admin/register', 'Auth\RegisterController@showAdminRegisterForm');
Route::post('/admin/register', 'Auth\RegisterController@createAdmin')->name('admin-register');

// Route::view('/admin', 'admin')->middleware('auth:admin')->name('adminhome');← おかしい。「view」というのはないはず。代わりに下記を追加。またnameも変更。
Route::get('/admin/home', 'Admin\IndexController@index')->name('admin.home')->middleware('auth:admin');

Route::group(['middleware' => 'web', 'namespace' => 'Auth'], function () {
    Route::get('admin/register', 'AdminRegisterController@showRegistrationForm')->name('admin.register.form');
    Route::post('admin/register', 'AdminRegisterController@register')->name('admin.register');
});

// 会員一覧・検索
Route::get('admin/members/list', 'MembersController@memberslist')->name('members.list')->middleware('auth:admin');
Route::post('admin/members/list', 'MembersController@memberslist')->name('members.list')->middleware('auth:admin');

// 会員登録
Route::get('/members/register', 'MembersController@MemberForm')->name('members.register');
Route::get('/members/confirm', 'MembersController@MemberConfirm')->name('members.confirm');
Route::post('/members/confirm', 'MembersController@MemberConfirm')->name('members.confirm');
Route::post('/members/complete', 'MembersController@MemberComplete')->name('members.complete');

// 会員編集
Route::get('/members/update/{id}', 'MembersController@MemberUpdate')->name('members.update');
Route::get('/members/updateconfirm', 'MembersController@MemberUpdateConfirm')->name('members.updateconfirm');
Route::post('/members/updateconfirm', 'MembersController@MemberUpdateConfirm')->name('members.updateconfirm');
Route::post('/members/updatecomplete', 'MembersController@MemberUpdateComplete')->name('members.updatecomplete');

// 会員の詳細
Route::get('/members/show/{id}', 'MembersController@MemberShow')->name('members.show');
Route::post('/members/show/{id}', 'MembersController@MemberShow')->name('members.show');

// 会員削除
Route::get('/members/withdrawal/{id}', 'MembersController@MemberWithdrawal')->name('members.withdrawal');

//商品カテゴリ一覧・検索
Route::get('/members/categorylist', 'ProductsController@categorylist')->name('members.categorylist');
Route::post('/members/categorylist', 'ProductsController@categorylist')->name('members.categorylist');

// 商品カテゴリ登録
Route::get('/members/categoryregister', 'ProductsController@CategoryForm')->name('members.categoryregister');
Route::get('/members/categoryconfirm', 'ProductsController@CategorysConfirm')->name('members.categoryconfirm');
Route::post('/members/categoryconfirm', 'ProductsController@CategorysConfirm')->name('members.categoryconfirm');
Route::post('/members/categorycomplete', 'ProductsController@CategoryComplete')->name('members.categorycomplete');

// 商品カテゴリ編集
Route::get('/members/categoryedit/{id}', 'ProductsController@CategoryUpdate')->name('members.categoryedit');
Route::get('/members/categoryeditconfirm', 'ProductsController@CategoryUpdateConfirm')->name('members.categoryeditconfirm');
Route::post('/members/categoryeditconfirm', 'ProductsController@CategoryUpdateConfirm')->name('members.categoryeditconfirm');
Route::post('/members/categoryeditcomplete', 'ProductsController@CategoryUpdateComplete')->name('members.categoryeditcomplete');

// 商品カテゴリの詳細
Route::get('/members/categoryshow/{id}', 'ProductsController@CategoryShow')->name('members.categoryshow');
Route::post('/members/categoryshow/{id}', 'ProductsController@CategoryShow')->name('members.categoryshow');

// 商品カテゴリの削除
Route::get('/members/categorywithdrawal/{id}', 'ProductsController@CategoryWithdrawal')->name('members.categorywithdrawal');

//商品一覧・検索
Route::get('/members/productlist', 'ProductsController@ProductView')->name('members.productlist');
Route::post('/members/productlist', 'ProductsController@ProductView')->name('members.productlist');

// 商品登録
Route::get('/members/productregister', 'ProductsController@ProductsForm')->name('members.productregister');
Route::get('/members/productconfirm', 'ProductsController@ProductsConfirm')->name('members.productconfirm');
Route::post('/members/productconfirm', 'ProductsController@ProductsConfirm')->name('members.productconfirm');
Route::get('/members/productcomplete', 'ProductsController@ProductsComplete')->name('members.productcomplete');

// 商品編集
Route::get('/members/productedit/{id}', 'ProductsController@ProductUpdate')->name('members.productedit');
Route::get('/members/producteditconfirm', 'ProductsController@ProductUpdateConfirm')->name('members.producteditconfirm');
Route::post('/members/producteditconfirm', 'ProductsController@ProductUpdateConfirm')->name('members.producteditconfirm');
Route::post('/members/producteditcomplete', 'ProductsController@ProductUpdateComplete')->name('members.producteditcomplete');

Route::get('/members/category', 'ProductsController@CategoryAjax');
Route::post('/members/category', 'ProductsController@CategoryAjax');

Route::get('/members/upload', 'ProductsController@uploadAjax');
Route::post('/members/upload', 'ProductsController@uploadAjax');

// 商品詳細
Route::get('/members/productshow/{id}', 'ProductsController@ProductShow')->name('members.productshow');
Route::post('/members/productshow/{id}', 'ProductsController@ProductShow')->name('members.productshow');

// 商品削除
Route::get('/members/productwithdrawal/{id}', 'ProductsController@ProductWithdrawal')->name('members.productwithdrawal');

//レビュー一覧・検索
Route::get('/members/reviewlist', 'ProductsController@ReviewView')->name('members.reviewlist');
Route::post('/members/reviewlist', 'ProductsController@ReviewView')->name('members.reviewlist');

// レビュー登録
Route::get('/members/reviewregister', 'ProductsController@ReviewsForm')->name('members.reviewregister');
Route::get('/members/reviewconfirm', 'ProductsController@ReviewsConfirm')->name('members.reviewconfirm');
Route::post('/members/reviewconfirm', 'ProductsController@ReviewsConfirm')->name('members.reviewconfirm');
Route::post('/members/reviewcomplete', 'ProductsController@ReviewsComplete')->name('members.reviewcomplete');

// レビュー編集
Route::get('/members/reviewedit/{id}', 'ProductsController@ReviewUpdate')->name('members.reviewedit');
Route::get('/members/revieweditconfirm', 'ProductsController@ReviewUpdateConfirm')->name('members.revieweditconfirm');
Route::post('/members/revieweditconfirm', 'ProductsController@ReviewUpdateConfirm')->name('members.revieweditconfirm');
Route::post('/members/revieweditcomplete', 'ProductsController@ReviewUpdateComplete')->name('members.revieweditcomplete');

// レビュー詳細
Route::get('/members/reviewshow/{id}', 'ProductsController@ReviewShow')->name('members.reviewshow');
Route::post('/members/reviewshow/{id}', 'ProductsController@ReviewShow')->name('members.reviewshow');

// レビュー削除
Route::get('/members/reviewwithdrawal/{id}', 'ProductsController@ReviewWithdrawal')->name('members.reviewwithdrawal');
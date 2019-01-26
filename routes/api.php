<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');
// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// ログインユーザー
Route::get('/user', function () {
    return Auth::user();
})->name('user');

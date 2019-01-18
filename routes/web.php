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
    return view('welcome');
});

Route::get('foo/foo1', 'FooController@foo1');
Route::get('foo/foo2', 'FooController@foo2');
Route::get('foo/foo3', 'FooController@foo3');
Route::get('foo/foo4', 'FooController@foo4');

Route::get('test', 'HelloController@index');

Route::get('student/list','StudentController@getIndex');
Route::group(['prefix' => 'student'], function () {
    Route::get('list', 'StudentController@getIndex'); //一覧
    Route::get('new', 'StudentController@new_index'); //入力
    Route::patch('new','StudentController@new_confirm'); //確認
    Route::post('new', 'StudentController@new_finish'); //完了
});

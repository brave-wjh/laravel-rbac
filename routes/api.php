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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::namespace('Api')->group(function () {
    // 在 "App\Http\Controllers\Admin" 命名空间下的控制器 ->middleware('check.token')
    Route::get('/test/wjh', 'TestController@wjh')->middleware('check.permit');
    Route::get('/test/ww', 'TestController@ww');
    Route::post('/admin_user/register', 'AdminUserController@register');
    Route::post('/admin_user/login', 'AdminUserController@login');
    Route::post('/admin_user/role_for_user', 'AdminUserController@roleForUser');
});

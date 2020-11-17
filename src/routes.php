<?php

use Illuminate\Http\Request;
use S25\Auth\Controllers\UserController;

Route::group(['middleware' => ['api']], static function () {
    Route::get('/api/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/api/users', [UserController::class, 'all']);
});

Route::group(['middleware' => ['web']], static function () {
    Route::get('/me', 'S25\Auth\Controllers\LoginController@loginByToken');
    Route::get('/token', 'S25\Auth\Controllers\LoginController@loginByToken');
    Route::get('/logout', 'S25\Auth\Controllers\LoginController@logout');
    Route::post('/logout', 'S25\Auth\Controllers\LoginController@logout');
    Route::get('/api/user', 'S25\Auth\Controllers\UserController@user');
});

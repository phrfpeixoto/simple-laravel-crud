<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', [
    'as' => 'home', 'uses' => 'SimpleController@index'
]);

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['prefix' => 'api/'], function(){
    Route::resource('state', 'StateController', ['except' => ['show', 'edit']]);
    Route::resource('user', 'UserController', ['only' => ['index', 'destroy']]);
    Route::patch('user/authorize/{user}', ['as' => 'user.authorize', 'uses' => 'UserController@authorizeUser']);
    Route::patch('user/unauthorize/{user}', ['as' => 'user.unauthorize', 'uses' => 'UserController@unauthorizeUser']);
});

Route::get('/state/{state}', [
    'as' => 'audit-state', 'uses' => 'SimpleController@auditState'
])->middleware('can:audit,App\State');

Route::get('/audit', [
    'as' => 'audit', 'uses' => 'SimpleController@audit'
])->middleware('can:audit,App\State');

Route::get('/users', [
    'as' => 'manage-users', 'uses' => 'SimpleController@users'
])->middleware('can:manage-users');


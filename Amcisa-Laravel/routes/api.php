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

Route::get('/user',[
    'uses' => 'UserController@getUser',
    'middleware' => 'auth:api'
]);

Route::post('/event/post',[
    'uses' => 'EventController@postEvent'

]);

Route::get('/event/get/{id}',[
    'uses' => 'EventController@getEvents'
]);

Route::post('/eventData/post/{id}',[
    'uses' => 'EventController@postEventData',
    'middleware' => 'guest',
    'middleware' => 'auth:api'
]);

Route::post('/register',[
    'uses' => 'UserController@register'
]);

Route::post('/login',[
    'uses' => 'UserController@signin'
]);

Route::get('/role/get',[
    'uses' => 'RoleController@getRole'
]);

Route::post('/role/post',[
    'uses' => 'RoleController@postRole'
]);

Route::post('/upload',[
    'uses' => 'FileController@upload'
]);

Route::get('/download/{name}',[
    'uses' => 'FileController@download'
]);

Route::get('/download/{folder}/{name}',[
    'uses' => 'FileController@downloadfolder'
]);

Route::post('/sendemail',[
    'uses' => 'EmailController@sendemail'
]);

Route::post('/amtee',[
    'uses' => 'AmteeController@vote',
    'middleware' => 'auth:api'
]);

Route::post('/info/post',[
    'uses' => 'InfoController@postInfo',
    'middleware' => ['auth:api','role:admin']
]);

Route::get('/info/get',[
    'uses' => 'InfoController@getInfo'
]);

Route::get('/clear-cache', function() {
    //execute php artisan cache:clear
    $exitCode = Artisan::call('cache:clear');
    return response("Cleared cache with wxit code: ".$exitCode,"200");
});
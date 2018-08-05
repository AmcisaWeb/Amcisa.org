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
    'uses' => 'EventController@postEvent',
    'middleware' => 'auth:api'
]);

Route::get('/event/get/{id}',[
    'uses' => 'EventController@getEvents'
]);

Route::get('/eventData/get/{id}',[
    'uses' => 'EventController@getEventData',
    'middleware' => 'auth:api'
]);

Route::post('/eventData/post/{eventId}/{pageId}',[
    'uses' => 'EventController@postEventData',
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
    return response("Cleared cache with exit code: ".$exitCode,"200");
});

Route::post('/bobi', function (Request $request){
    $user = \Illuminate\Support\Facades\Auth::user();
    $bobi = new \App\Bobi();
    $bobi->user_id = $user->id;
    $bobi->user_name = $user->name_en;
    $bobi->data = $request->input('data');
    $bobi->save();
    return response('posted successful', 200);

})->middleware('auth:api');

Route::get('/18-19 FOA Hunter Game/GetTime',[
    'uses' => '_18_19_FOA_Hunter_Game\GameController@getTime'
]);

Route::get('/18-19 FOA Hunter Game/GetInventory',[
    'uses' => '_18_19_FOA_Hunter_Game\GameController@getInventory'
]);

Route::post('/18-19 FOA Hunter Game/Purchase',[
    'uses' => '_18_19_FOA_Hunter_Game\GameController@purchase'
]);

Route::post('/18-19 FOA Hunter Game/PlayerStart',[
    'uses' => '_18_19_FOA_Hunter_Game\GameController@playerStart'
]);

Route::post('/18-19 FOA Hunter Game/PlayerEnd',[
    'uses' => '_18_19_FOA_Hunter_Game\GameController@playerEnd'
]);

Route::post('/18-19 FOA Hunter Game/AllPlayersEnd',[
    'uses' => '_18_19_FOA_Hunter_Game\GameController@allPlayersEnd'
]);

Route::post('/18-19 FOA Hunter Game/ResetTime',[
    'uses' => '_18_19_FOA_Hunter_Game\GameController@resetTime'
]);

Route::post('/18-19 FOA Hunter Game/ResetCash',[
    'uses' => '_18_19_FOA_Hunter_Game\GameController@resetCash'
]);

Route::post('/18-19 FOA Hunter Game/ResetItems',[
    'uses' => '_18_19_FOA_Hunter_Game\GameController@resetItems'
]);

Route::post('/18-19 FOA Hunter Game/AddCash',[
    'uses' => '_18_19_FOA_Hunter_Game\GameController@addCash'
]);
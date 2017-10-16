<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::get('/auth/facebook', 'Auth\FacebookAuthController@redirectToProvider');
Route::get('/auth/facebook/callback', 'Auth\FacebookAuthController@handleProviderCallback');

Route::get('iframe/{code}', 'JigsawController@iframe');
Route::get('play/{code}', 'JigsawController@play');
Route::get('load/{code}', 'JigsawController@load');
Route::get('share/{game_id}/{user_id}', 'HomeController@share');
Route::get('player/{username}', 'HomeController@player');
Route::get('category/{title}-{id}', 'HomeController@category');
Route::get('language', 'HomeController@language');

Route::group(['prefix' => 'brain-game'], function () {
    Route::get('/', 'BrainGameController@index');
    Route::get('/{id}-{title}', 'BrainGameController@play');
});

Route::group(['prefix' => 'windowapp'], function () {
    Route::get('/', 'WindowAppController@index');
    Route::get('play/{code}', 'WindowAppController@play');
    Route::get('load/{code}', 'WindowAppController@load');
});

Route::group(['prefix' => 'fbapp'], function () {
    Route::get('/', 'FBAppController@index');
});

Route::group(['middleware' => ['auth']], function () {
	Route::get('newpics', 'HomeController@newpics');
	Route::get('custompic', 'CustomPicController@custompic');
	Route::post('custompic', 'CustomPicController@uploadPicture');
	Route::post('deletepic/{id}', 'CustomPicController@deletePicture');
	Route::post('makegame', 'CustomPicController@makegame');
	Route::post('count', 'JigsawController@count');
	Route::post('score', 'JigsawController@score');
	Route::controllers(['account'=> 'AccountController']);
});

Route::group(['middleware' => ['backend']], function () {
	Route::controllers(['collection'=> 'CollectionController']);
	Route::controllers(['picture'=> 'PictureController']);
	Route::controllers(['game'=> 'GameController']);
	Route::controllers(['user'=> 'UserController']);
	Route::controllers(['gamesize'=> 'GameSizeController']);
	Route::controllers(['category'=> 'CategoryController']);
	Route::controllers(['brain-game'=> 'BrainGameController']);
});

Route::controllers(['api'=> 'ApiController']);

Route::auth();
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

Route::get('/', [
    'as' => 'home', 'uses' => 'HomeController@index'
]);

Route::get('alert/',function(){
	return redirect()->route('home')->with('info','You have signed up!');
});

Route::get('/signup', [
    'as' => 'auth.signup', 'uses' => 'AuthController@getSignup',
    'middleware' => ['guest']
]);

Route::post('/signup', [
    'uses' => 'AuthController@postSignup',
    'middleware' => ['guest']
]);

Route::get('/signin', [
    'as' => 'auth.signin', 'uses' => 'AuthController@getSignin',
    'middleware' => ['guest']
]);

Route::post('/signin', [
    'uses' => 'AuthController@postSignin',
    'middleware' => ['guest']
]);
Route::get('/signout', [
	'as' => 'auth.signout',
    'uses' => 'AuthController@getSignOut'
]);

Route::get('/search',[
	'as' => 'search.results',
	'uses' => 'SearchController@getSearchResults'
]);


/***Profile****/

Route::get('/user/{username}',[
	'as' => 'profile.index',
	'uses' => 'ProfileController@getProfile'
]);


Route::get('/profile/edit',[
	'as' => 'profile.edit',
	'uses' => 'ProfileController@getEdit',
	'middleware' =>['auth'],
]);

Route::post('/profile/edit',[
	'uses' => 'ProfileController@postEdit',
	'middleware' =>['auth'],
]);



/****Friends****/

Route::get('/friends',[
	'as' => 'friend.index',
	'uses' => 'FriendController@index',
	'middleware' =>['auth'],
]);
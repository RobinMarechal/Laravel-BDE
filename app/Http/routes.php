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


Route::group(['prefix' => '/', 'middleware' => 'banned'], function()
{
	Route::group(['prefix' => 'news'], function()
	{
		Route::post('create', 'NewsController@store')->name('news.store')->middleware('auth');
		Route::post('delete', 'NewsController@delete')->name('news.delete')->middleware('auth');
		Route::post('edit', 'NewsController@update')->name('news.update')->middleware('auth');
		Route::post('toggleValidation', 'NewsController@toggleValidation')->name('news.toggleValidation')->middleware('auth');
		Route::post('update', 'NewsController@update')->name('news.update')->middleware('auth');
		Route::post('trash', 'NewsController@trash')->name('news.trash')->middleware('auth');
		Route::post('restore', 'NewsController@restore')->name('news.restore')->middleware('auth');

		Route::get('/', 'NewsController@index')->name('news.index');
		Route::get('all', 'NewsController@indexAll')->name('news.indexAll');
		Route::get('show/{id}', 'NewsController@show')->name('news.show');
		Route::get('create', 'NewsController@create')->name('news.create');
		Route::get('edit/{id}', 'NewsController@edit')->name('news.edit')->middleware('auth');
		Route::get('/{id}', 'NewsController@ajaxGet')->name('news.ajaxGet');
	});

	Route::group(['prefix' => 'events'], function()
	{
		Route::post('create', 'EventController@store')->name('events.store')->middleware('auth');
		Route::post('delete', 'EventController@delete')->name('events.delete')->middleware('auth');
		Route::post('edit', 'EventController@update')->name('events.update')->middleware('auth');
		Route::post('toggleValidation', 'EventController@toggleValidation')->name('events.toggleValidation')->middleware('auth');
		Route::post('store', 'EventController@store')->name('events.store')->middleware('auth');
		Route::post('update', 'EventController@update')->name('events.update')->middleware('auth');
		Route::post('trash', 'EventController@trash')->name('events.trash')->middleware('auth');
		Route::post('restore', 'EventController@restore')->name('events.restore')->middleware('auth');
		Route::post('ajax/create', 'EventController@ajaxCreate')->name('events.ajaxCreate');

		Route::get('/', 'EventController@index');
		Route::get('/coming', 'EventController@indexComing')->name('events.indexComing');
		Route::get('/past', 'EventController@indexPast')->name('events.indexPast');
		Route::get('/coming/all', 'EventController@indexAllComing')->name('events.indexAllComing');
		Route::get('/past/all', 'EventController@indexAllPast')->name('events.indexAllPast');
		Route::get('show/{id}', 'EventController@show');
		Route::get('create', 'EventController@create')->name('events.create')->middleware('auth');
		Route::get('edit', 'EventController@edit')->name('events.edit')->middleware('auth');
		Route::get('{id}', 'EventController@ajaxGet')->name('events.ajaxGet');
	});

	Route::group(['prefix' => 'teams'], function()
	{
		Route::post('create', 'TeamController@store')->name('teams.store')->middleware('level:1');
		Route::post('delete', 'TeamController@delete')->name('teams.delete')->middleware('level:3');
		Route::post('edit', 'TeamController@update')->name('teams.update')->middleware('level:2');
		Route::post('/post', 'TeamController@ajaxPost')->name('teams.ajaxPost')->middleware('auth');
		Route::post('trash', 'TeamController@trash')->name('teams.trash')->middleware('auth');
		Route::post('restore', 'TeamController@restore')->name('teams.restore')->middleware('auth');
		Route::post('ajax/create', 'TeamController@ajaxCreate')->name('teams.ajaxCreate')->middleware('auth');

		Route::get('/{id}', 'TeamController@ajaxGet')->middleware('auth')->name('teams.ajaxGet');
		Route::get('/', 'TeamController@index');
		Route::get('show/{slug}', 'TeamController@show')->name('teams.show');
		Route::get('show/{slug}/news', 'TeamController@news')->name('teams.show.news');
	});

	Route::group(['prefix' => 'auth'], function()
	{
		Route::post('register', 'Auth\AuthController@postRegister')->middleware('auth')->name('auth.register');
		Route::post('login', 'Auth\AuthController@postLogin')->middleware('guest')->name('auth.register');
		Route::post('firstconnexion', 'Auth\AuthController@postFirstConnexion')->middleware('auth');

		Route::get('login', 'Auth\AuthController@login')->middleware('guest');
		Route::get('register', 'Auth\AuthController@register')->middleware('auth');
		Route::get('logout', 'Auth\AuthController@logout')->middleware('auth');
		Route::get('firstconnexion', 'Auth\AuthController@firstConnexion')->middleware('auth');
	});

	Route::group(['prefix' => 'staff'], function()
	{
		Route::post('create', 'StaffController@store')->name('teams.store')->middleware('level:1');
		Route::post('delete', 'StaffController@delete')->name('teams.delete')->middleware('level:3');
		Route::post('edit', 'StaffController@update')->name('teams.update')->middleware('level:2');

		Route::get('/', 'StaffController@index');
		Route::get('show/{id}', 'StaffController@show');
	});

	Route::group(['prefix' => 'gallery'], function()
	{
		Route::get('/', 'GalleryController@index')->name('gallery.index');
	});

	Route::group(['prefix' => 'users'], function()
	{
		Route::get('/teamManaged', 'UserController@teamManaged')->name('users.teamManagedcd ');
		Route::get('/getData', 'UserController@getData')->name('users.getData ');
	});
});

Route::get('contents/{name}', 'ContentController@getContent') -> name('getcontent');
Route::post('contents/post', 'ContentController@post') -> name('post');

Route::get('help', function()
{
	return view('about');
});

Route::get('/', function()
{
	$content = App\Content::where('name', 'home_content')->first();
    return view('index', compact('content'));
});
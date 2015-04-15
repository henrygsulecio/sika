<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/', array(
  'before' => 'auth.fake',
  'as' => 'home',
  'uses' => 'PageController@showInfo',
));

Route::get('login', array(
  'before' => 'guest.fake',
  'as' => 'login',
  'uses' => 'PageController@showLogin',
));

Route::get('dologin', array(
  'as' => 'dologin',
  'uses' => 'PageController@doLogin',
));

Route::get('dologout', array(
  'as' => 'dologout',
  'uses' => 'PageController@doLogout',
));

Route::get('users', array(
  'before' => 'auth.fake',
  'as' => 'users',
  'uses' => 'PageController@showUsers',
));

Route::get('user/{id}', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@showUser',
))
->where('id', '[0-9]+');

Route::get('cliente', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@showCliente',
));

Route::post('cliente', array(
  'before' => 'auth.fake',
  'as' => 'cliente',
  'uses' => 'PageController@updateCliente',
));

Route::get('repartidor', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@showRepartidor',
));

Route::post('repartidor', array(
  'before' => 'auth.fake',
  'as' => 'cliente',
  'uses' => 'PageController@updateRepartidor',
));



Route::get('search/{phone}', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@SearchData',
));
//->where('phone', '[0-9]+’);

Route::get('searchReguards/{phone}', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@SearchReguardsData',
));

Route::get('info', array(
  'before' => 'auth.fake',
  'as' => 'info',
  'uses' => 'PageController@showInfo',
));



Route::post('user', array(
  'before' => 'auth.fake',
  'as' => 'user',
  'uses' => 'PageController@updateUser',
));

Route::get('report/{mesu}/{mesd}/{mest}/{ano}', array(
  'before' => 'auth.fake',
  'as' => 'report',
  'uses' => 'PageController@showReport',
));



Route::get('receivesms/{phone}/{shornumber}/{telco}/{msg}', array(
  'as' => 'receivesms',
  'uses' => 'SMSController@receive',
));


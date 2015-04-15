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
  'uses' => 'PageController@showDashboard',
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

Route::get('reguardStatus/{id}', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@showReguardStatus',
))
->where('id', '[0-9]+');

Route::post('reguardStatus', array(
  'before' => 'auth.fake',
  'as' => 'reguardStatus',
  'uses' => 'PageController@updateStatusReguard',
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

Route::get('reguard/{mes}/{ano}', array(
  'before' => 'auth.fake',
  'as' => 'reguard',
  'uses' => 'PageController@showReguard',
));


Route::get('record/{phone}', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@showUserRecord',
))
->where('id', '[0-9]+');

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

Route::get('rango', array(
  'before' => 'auth.fake',
  
  'uses' => 'PageController@ShowRango',
));

Route::get('rangoMes', array(
  'before' => 'auth.fake',
  
  'uses' => 'PageController@ShowRangoMes',
));

Route::get('messages', array(
  'before' => 'auth.fake',
  'as' => 'messages',
  'uses' => 'PageController@showMessages',
));

Route::get('exportinfo', array(
  'before' => 'auth.fake',
 
  'uses' => 'PageController@exelInfo',
));

Route::get('exportMessage', array(
  'before' => 'auth.fake',
 
  'uses' => 'PageController@exelMessage',
));

Route::get('exportUsuarios', array(
  'before' => 'auth.fake',
 
  'uses' => 'PageController@exelUser',
));

Route::get('exportReguards/{mes}/{ano}', array(
  'before' => 'auth.fake',
 
  'uses' => 'PageController@exelReguards',
));

Route::get('exportReport/{mesu}/{mesd}/{mest}/{ano}', array(
  'before' => 'auth.fake',
 
  'uses' => 'PageController@exelReport',
));

Route::get('exportBirthday', array(
  'before' => 'auth.fake',
 
  'uses' => 'PageController@exelBirthday',
));

Route::get('birthday', array(
  'before' => 'auth.fake',
  
  'uses' => 'PageController@showBirthday',
));


Route::get('receivesms/{phone}/{shornumber}/{telco}/{msg}', array(
  'as' => 'receivesms',
  'uses' => 'SMSController@receive',
));


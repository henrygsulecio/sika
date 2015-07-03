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

Route::post('dologin', array(
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


//clientes
Route::get('clientes', array(
  'before' => 'auth.fake',
  'as' => 'clientes',
  'uses' => 'PageController@showInfoCliente',
));

Route::post('cliente', array(
  'before' => 'auth.fake',
  'as' => 'cliente',
  'uses' => 'PageController@updateCliente',
));

Route::any('cliented/{id}', array(
  'before' => 'auth.fake',
  'as' => 'cliented',
  'uses' => 'PageController@deleteCliente',
));

Route::get('cliente/{id}', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@showClientes',
))
->where('id', '[0-9]+');
//fin clientes

//REPARTIDORES

Route::get('repartidores', array(
  'before' => 'auth.fake',
  'as' => 'repartidores',
  'uses' => 'PageController@showInfoRepartidor',
));

Route::get('repartidor', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@showRepartidor',
));

Route::post('repartidor', array(
  'before' => 'auth.fake',
  'as' => 'repartidor',
  'uses' => 'PageController@updateRepartidor',
));

Route::any('repartidord/{id}', array(
  'before' => 'auth.fake',
  'as' => 'repartidord',
  'uses' => 'PageController@deleteRepartidor',
));

Route::get('repartidor/{id}', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@showRepartidores',
))
->where('id', '[0-9]+');
//FIN REPARTIDORES

//Ususarios

Route::get('usuarios', array(
  'before' => 'auth.fake',
  'as' => 'usuarios',
  'uses' => 'PageController@showInfoUsuario',
));

Route::get('usuario', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@showUsuario',
));

Route::post('usuario', array(
  'before' => 'auth.fake',
  'as' => 'usuario',
  'uses' => 'PageController@updateUsuarios',
));

Route::any('usuariosd/{id}', array(
  'before' => 'auth.fake',
  'as' => 'usuariosd',
  'uses' => 'PageController@deleteUsuarios',
));

Route::get('usuario/{id}', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@showUsuarios',
))
->where('id', '[0-9]+');
//FIN usuarios

Route::get('ruta', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@showRuta',
));

Route::post('ruta', array(
  'before' => 'auth.fake',
  'as' => 'ruta',
  'uses' => 'PageController@updateRuta',
));

Route::any('rutad/{id}', array(
  'before' => 'auth.fake',
  'as' => 'rutad',
  'uses' => 'PageController@deleteRuta',
));

Route::get('ruta/{id}', array(
  'before' => 'auth.fake',
  'uses' => 'PageController@showRutas',
))
->where('id', '[0-9]+');


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

//servicios web
Route::get('json', array(
  
  'as' => 'json',
  'uses' => 'PageController@showJson',
));

Route::get('loginJ', array(
  
  'as' => 'loginJ',
  'uses' => 'PageController@LoginJson',
));

Route::any('insJ/{id}/{estado}/{comentario}', array(
  'before' => 'auth.fake',
  'as' => 'insJ',
  'uses' => 'PageController@updateRutaJ',
));

//fin servicios


Route::get('exportinfo', array(
  'before' => 'auth.fake',
 
  'uses' => 'PageController@exelInfo',
));


Route::post('user', array(
  'before' => 'auth.fake',
  'as' => 'user',
  'uses' => 'PageController@updateUser',
));

Route::get('report/{mesu}', array(
  'before' => 'auth.fake',
  'as' => 'report',
  'uses' => 'PageController@showReport',
));

/*Route::any('/ajax-subcat',function(){
  $cat_id = Input::get('cat_id');
  $subcategories = Subcategory::where('id','=',$cat_id)->get();
  return Response::json($subcategories);


});*/

Route::get('rango', array(
  'before' => 'auth.fake',
  
  'uses' => 'PageController@ShowRango',
));

Route::get('ajax-subcat/{cat_id}', array(
  'before' => 'auth.fake',
  'as' => 'ajax-subcat',
  'uses' => 'PageController@showAjax',
));

Route::get('exportRep/{repartidor}', array(
  'before' => 'auth.fake',
 
  'uses' => 'PageController@exelRep',
));

Route::get('exportFec/{fu}/{fd}', array(
  'before' => 'auth.fake',
 
  'uses' => 'PageController@exelFec',
));

Route::get('rangof', array(
  'before' => 'auth.fake',
  
  'uses' => 'PageController@showRangoFecha',
));


Route::get('receivesms/{phone}/{shornumber}/{telco}/{msg}', array(
  'as' => 'receivesms',
  'uses' => 'SMSController@receive',
));


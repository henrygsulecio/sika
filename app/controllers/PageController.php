<?php

class PageController extends BaseController {

 

  public function showLogin()
  {
    return View::make('page.login', array(
      'page' => 'login'
    ));
  }

  public function doLogin()
  {
    // getting parameters
    $user = trim(Input::get('user', ''));
    $password = trim(Input::get('password', ''));

    Log::info("user: " . print_r($user, true));
    Log::info("password: " . print_r($password, true));

    //$user;
    //$password;
    $users = DB::table('usuarios')
             ->selectRaw('usuarios.nickname, usuarios.password')
             ->where('usuarios.nickname', '=',$user)
             ->where('usuarios.password', '=',$password)
              ->get();
             //->first();
    if($users)
    {
      
            Session::put('userLogged', 1);
            Session::regenerate();

            return Redirect::route('home');
           
         
        
      }
       
    
      else
    {
      return Redirect::route('login');

    }

    // user login
   
  }

  public function doLogout()
  {
    // user logout
    Session::flush();

    return Redirect::route('home');
  }

  

  

  


  public function showInfo()
  {
    // info
    
    $users = DB::table('rutas')
      ->selectRaw('rutas.created_at,rutas.img,rutas.nrutas,rutas.checkP,rutas.updated_at, rutas.ruta_id, rutas.estado, rutas.comentario, clientes.nombre, clientes.direccion, clientes.ncuenta, rutas.pedido,rutas.direccion as direc, rutas.nfactura,rutas.norden,rutas.nhr, repartidores.nombre as rname, repartidores.apellido')
      //->where('message.msg_out', '0')
      //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      ->leftJoin('clientes', 'rutas.cliente_id', '=', 'clientes.id')
      ->leftJoin('repartidores', 'rutas.repartidor_id', '=', 'repartidores.id')
      ->groupBy(DB::raw('rutas.ruta_id'))
      ->paginate(20);
     //Log::info("info datos: " . print_r($users, true));
    // display page 
    return View::make('page.info', array(
      'page' => 'users',
      'users' => $users,
    ));
  }


  public function showInfoDetalle($id)
  {
    // info
    
    $users = DB::table('rutas')
      ->selectRaw('rutas.created_at,rutas.img,rutas.nrutas,rutas.checkP,rutas.updated_at, rutas.ruta_id, rutas.estado, rutas.comentario, clientes.nombre, clientes.direccion, clientes.ncuenta, rutas.pedido,rutas.direccion as direc, rutas.nfactura,rutas.norden,rutas.nhr, repartidores.nombre as rname, repartidores.apellido')
      //->where('message.msg_out', '0')
      //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      ->leftJoin('clientes', 'rutas.cliente_id', '=', 'clientes.id')
      ->leftJoin('repartidores', 'rutas.repartidor_id', '=', 'repartidores.id')
      ->where('rutas.ruta_id',$id)
      ->groupBy(DB::raw('rutas.ruta_id'))
      ->paginate(20);
     //Log::info("info datos: " . print_r($users, true));
    // display page 
    return View::make('page.infoDetalle', array(
      'page' => 'infoDetalle',
      'users' => $users,
    ));
  }

  public function showJson()
  {
    
    $users = DB::table('rutas')
      ->selectRaw('rutas.created_at,rutas.updated_at, rutas.ruta_id, clientes.nombre, clientes.direccion, clientes.ncuenta, rutas.pedido,rutas.direccion as direc, rutas.nfactura,rutas.norden,rutas.nhr, repartidores.nombre as rname, repartidores.apellido')
      //->where('message.msg_out', '0')
      //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      ->leftJoin('clientes', 'rutas.cliente_id', '=', 'clientes.id')
      ->leftJoin('repartidores', 'rutas.repartidor_id', '=', 'repartidores.id')
      ->groupBy(DB::raw('rutas.ruta_id'))
      //->take(50)
      //->skip(50)
      ->get();
      
     //Log::info("info datos: " . print_r($users, true));
    // display page 
    return Response::json(array('data' => $users));
  }

  public function showInfoRepartidor()
  {
    // info
    
    $users = DB::table('repartidores')
      ->selectRaw('repartidores.id, repartidores.created_at, repartidores.nombre, repartidores.apellido, repartidores.ncarne')
      //->where('message.msg_out', '0')
      //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      
      //->groupBy(DB::raw('rutas.ruta_id'))
      ->paginate(20);
     //Log::info("info datos: " . print_r($users, true));
    // display page 
    return View::make('page.infoRepartidor', array(
      'page' => 'users',
      'users' => $users,
    ));
  }

  public function showInfoUsuario()
  {
    // info
    
    $users = DB::table('usuarios')
      ->selectRaw('usuarios.id, usuarios.nombre, usuarios.nickname, usuarios.repartidor_id')
      //->where('message.msg_out', '0')
      //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      
      //->groupBy(DB::raw('rutas.ruta_id'))
      ->paginate(20);
     //Log::info("info datos: " . print_r($users, true));
    // display page 
    return View::make('page.infoUsuarios', array(
      'page' => 'users',
      'users' => $users,
    ));
  }

  public function showInfoCliente()
  {
    // info
    
    $users = DB::table('clientes')
      ->selectRaw('*')
      //->where('message.msg_out', '0')
      //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      
      //->groupBy(DB::raw('rutas.ruta_id'))
      ->paginate(20);
     //Log::info("info datos: " . print_r($users, true));
    // display page 
    return View::make('page.infoCliente', array(
      'page' => 'users',
      'users' => $users,
    ));
  }


  

  
  public function showUser($id)
  {
    // get user data
    $user = $this->getUserData($id);

    // display page 
    return View::make('page.user', array(
      'page' => 'user',
      'user' => $user,
    ));
  }


public function showCliente()
  {
    // get user data
    //$user = $this->getUserData($id);

    // display page 
    return View::make('page.cliente', array(
      'page' => 'cliente',
      //'user' => $user,
    ));
  }

  public function showRepartidor()
  {
    // get user data
    //$user = $this->getUserData($id);

    // display page 
    return View::make('page.repartidor', array(
      'page' => 'repartidor',
      //'user' => $user,
    ));
  }

   public function showUsuario()
  {
    // get user data
    //$user = $this->getUserData($id);
      $user = DB::table('repartidores')
      ->selectRaw('*')

      ->get(); 
    // display page 
    return View::make('page.usuario', array(
      'page' => 'usuario',
      'user' => $user,
    ));
  }


  public function showRangoFecha()
  {
    // get user data
    //$user = $this->getUserData($id);

    // display page 
    return View::make('page.rangoReguard', array(
      'page' => 'rangoReguard',
      //'user' => $user,
    ));
  }



  public function showRuta()
  {
    // get user data
    //$user = $this->getUserData($id);
      $clientes = DB::table('clientes')
      ->selectRaw('*')
      ->orderByRaw('clientes.nombre ASC')
      //->leftJoin('user', 'reguards.user_id', '=', 'user.id')
      //->leftJoin('user_info', 'reguards.user_id', '=', 'user_info.user_id')
      //->where('reguards.id', $id)
      ->get();

      $repartidores = DB::table('repartidores')
      ->selectRaw('*')
      //->leftJoin('user', 'reguards.user_id', '=', 'user.id')
      //->leftJoin('user_info', 'reguards.user_id', '=', 'user_info.user_id')
      //->where('reguards.id', $id)
      ->get();
    // display page 
    return View::make('page.ruta', array(
      'page' => 'ruta',
      'clientes' => $clientes,
      'repartidores'=>$repartidores,
    ));
  }

   public function showAjax($cat_id)
  {
    // get user data
    //$user = $this->getUserData($id);
      $clientes = DB::table('clientes')
      ->selectRaw('*')

      //->leftJoin('user', 'reguards.user_id', '=', 'user.id')
      //->leftJoin('user_info', 'reguards.user_id', '=', 'user_info.user_id')
      //->where('reguards.id', $id)
      ->get();

      $subcategories = DB::table('clientes')
      ->selectRaw('direccion,id')
      //->leftJoin('user', 'reguards.user_id', '=', 'user.id')
      //->leftJoin('user_info', 'reguards.user_id', '=', 'user_info.user_id')
      ->where('clientes.id', $cat_id)
      ->orderByRaw('clientes.nombre ASC')
      ->get();

      $repartidores = DB::table('repartidores')
      ->selectRaw('*')
      //->leftJoin('user', 'reguards.user_id', '=', 'user.id')
      //->leftJoin('user_info', 'reguards.user_id', '=', 'user_info.user_id')
      //->where('reguards.id', $id)
      ->get();
    // display page 
      return Response::json($subcategories);
    /*return View::make('page.ruta', array(
      'page' => 'ruta',
      'clientes' => $clientes,
      'repartidores'=>$repartidores,
    ));*/
  }

public function ShowRango(){


      $repartidores = DB::table('repartidores')
      ->selectRaw('*')
      
      ->get();

       return View::make('page.rangoReport', array(
      'page' => 'page.rangoReport',
      'repartidores'=>$repartidores,
      
    ));

  }

  public function ShowRangoHR(){


      $repartidores = DB::table('rutas')
      ->selectRaw('*')
      
      ->get();

       return View::make('page.rangoHR', array(
      'page' => 'page.rangoHR',
      'repartidores'=>$repartidores,
      
    ));

  }
    


  public function showRutas($id)
  {
    $clientes = DB::table('clientes')
      ->selectRaw('*')
      ->orderByRaw('clientes.nombre ASC')
      ->get();

      $repartidores = DB::table('repartidores')
      ->selectRaw('*')
     ->orderByRaw('repartidores.nombre ASC')
      ->get();

      $clientess = DB::table('clientes')
      ->selectRaw('*')
      ->orderByRaw('clientes.nombre ASC')
      ->first();

      $repartidoress = DB::table('repartidores')
      ->selectRaw('*')
     ->orderByRaw('repartidores.nombre ASC')
      ->first();
    // get user data
      $user = DB::table('rutas')
      ->selectRaw('*')
      //->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->where('rutas.ruta_id', $id)
      ->first();

    //$user = $this->getUserData($id);

    // display page 
    return View::make('page.rutas', array(
      'page' => 'rutas',
      'user' => $user,
      'clientes' => $clientes,
      'repartidores' => $repartidores,
      'clientess' => $clientess,
      'repartidoress' => $repartidoress,
    ));
  }

  public function showClientes($id)
  {
    

      $clientes = DB::table('clientes')
      ->selectRaw('*')
      ->where('clientes.id', $id)
      ->first();
    

    // display page 
    return View::make('page.clientes', array(
      'page' => 'clientes',
      
      'user' => $clientes,
      
    ));
  }

   public function showRepartidores($id)
  {
    

      $repartidores = DB::table('repartidores')
      ->selectRaw('*')
     ->where('repartidores.id', $id)
      ->first();
    

    // display page 
    return View::make('page.repartidores', array(
     'page' => 'repartidores',
      
      'user' => $repartidores,
      
    ));
  }


   public function showUsuarios($id)
  {
    

      $user = DB::table('repartidores')
      ->selectRaw('*')
      ->get(); 

      $usuarios = DB::table('usuarios')
      ->selectRaw('*')
     ->where('usuarios.id', $id)
      ->first();
    

    // display page 
    return View::make('page.usuarios', array(
     'page' => 'usuarios',
      'useres' => $usuarios,
      'user' => $user,
      
    ));
  }



    public function showReguardStatus($id)
  {
    // get Reguards data
    $user = DB::table('reguards')
      ->selectRaw('reguards.id,reguards.estado,reguards.codigo, user.phone')
      ->leftJoin('user', 'reguards.user_id', '=', 'user.id')
      //->leftJoin('user_info', 'reguards.user_id', '=', 'user_info.user_id')
      ->where('reguards.id', $id)
      ->first();

    // display page 
    return View::make('page.reguardStatus', array(
      'page' => 'reguardStatus',
      'user' => $user,
    ));
  }

  protected function getUserData($id)
  {
    $user = DB::table('rutas')
      ->selectRaw('rutas.*')
      //->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->where('rutas.ruta_id', $id)
      ->first();

    return $user;
  }

//Reguards status update
  public function updateStatusReguard()
  {

    // parameters
    $now = date('Y-m-d H:i:s');
    $id = Input::get('user_id', 0);
    $status = trim(Input::get('status', ''));
    


 
                
          
   // Log::info('location: ' . $location);
    // Log::info('first name: ' . $firstname);
     //Log::info('birthday: ' . $birthday);

    // validating
    /*if ($id == 0) {
      return Redirect::route('rangoMes');
    }*/

    // get user data
    /*$user = DB::table('user')
      ->selectRaw('*')
      ->where('id', $id)
      ->first();*/
    $user_info = DB::table('reguards')
      ->selectRaw('*')
      ->where('id', $id)
      ->first();

    // exists?
    /*if (! $user) {
      return Redirect::route('rangoMes');
    }*/

    // update
    DB::beginTransaction();
    try {
      // user_info
      if ($user_info) {
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // update
        DB::table('reguards')
          ->where('id', $id)
          ->update(array(
            'estado' => $status,
            
          ));
      } else {
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // insert
        DB::table('reguards')->insert(
          array(
            'id' => $id,
            'estado' => $status,
            
          )
        );
      }

      // user
      /*DB::table('reguards')
        ->where('id', $id)
        ->update(array(
          'updated_at' => $now,
        ));*/

      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::error($e);
    }
  //else de validacion

    

    // get user data
    //$user = $this->getUserData($id);
     $user = DB::table('reguards')
      ->selectRaw('reguards.*, user.*')
      //->leftJoin('user_info', 'reguards.user_id', '=', 'user_info.user_id')
      ->leftJoin('user', 'reguards.user_id', '=', 'user.id')
      ->where('reguards.id', $id)
      ->first(); 

    // display page 
    return View::make('page.reguardStatus', array(
      'page' => 'reguardStatus',
      'user' => $user,
    ));
     
   
  }

  

  public function updateCliente()
  {

    // parameters
    $now = date('Y-m-d H:i:s');
    $id = Input::get('id', 0);
    $nombre = trim(Input::get('nombre', ''));
    $direccion = trim(Input::get('direccion', ''));
    $telefono = trim(Input::get('telefono', ''));
    $ncuenta = trim(Input::get('ncuenta', ''));
     //Log::info('first name: ' .  $nombre);
     //Log::info('birthday: ' .  $direccion);
     //Log::info('cienta: ' . $ncuenta);
     $user = DB::table('clientes')
      ->selectRaw('*')
      ->where('id', $id)
      ->first();

 // update
    DB::beginTransaction();
    try {
      
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // insert
        /*DB::table('clientes')->insert(
          array(
            //'user_id' => $id,
            'nombre' => $nombre,
            'direccion' => $direccion,
            'ncuenta' => $ncuenta,
            
            
          )
        );*/

if ($user) {
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // update
        DB::table('clientes')
          ->where('id', $id)
          ->update(array(
            'id' => $id,
            'nombre' => $nombre,
            'direccion' => $direccion,
            'ncuenta' => $ncuenta,
            'telefono' => $telefono,
            
            
          ));
      }else{
        
        // insert
        DB::table('clientes')->insert(
          array(
            //'user_id' => $id,
            'nombre' => $nombre,
            'direccion' => $direccion,
            'ncuenta' => $ncuenta,
            'telefono' => $telefono,
            
            
          )
        );
      }
      

    

      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::error($e);
    }
  //else de validacion

    

    // get user data
    //$user = $this->getUserData($id);

    // display page 
    return View::make('page.cliente', array(
      'page' => 'cliente',
      //'user' => $user,
    ));
     
   
  }

  public function updateRepartidor()
  {

    // parameters
    $now = date('Y-m-d H:i:s');
    $id = Input::get('id', 0);
    $nombre = trim(Input::get('nombre', ''));
    $apellido = trim(Input::get('apellido', ''));
    $ncarne = trim(Input::get('ncarne', ''));
     //Log::info('first name: ' .  $nombre);
     //Log::info('birthday: ' .  $direccion);
     //Log::info('cienta: ' . $ncuenta);
    $user = DB::table('repartidores')
      ->selectRaw('*')
      ->where('id', $id)
      ->first();

 // update
    DB::beginTransaction();
    try {
      
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // insert
       /* DB::table('repartidores')->insert(
          array(
            //'user_id' => $id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'ncarne' => $ncarne,
            
            
          )
        );*/

      if ($user) {
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // update
        DB::table('repartidores')
          ->where('id', $id)
          ->update(array(
            'id' => $id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'ncarne' => $ncarne,
            
            
          ));
      }else{
        
        // insert
        DB::table('repartidores')->insert(
          array(
            //'user_id' => $id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'ncarne' => $ncarne,
            
            
          )
        );
      }
      

    

      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::error($e);
    }
  //else de validacion

    

    // get user data
    //$user = $this->getUserData($id);

    // display page 
    return View::make('page.repartidor', array(
      'page' => 'repartidor',
      //'user' => $user,
    ));
     
   
  }


  //USUARIOS
    public function updateUsuario()
  {

    // parameters
    $now = date('Y-m-d H:i:s');
    $id = Input::get('id', 0);
    $nombre = trim(Input::get('nombre', ''));
    $nickname = trim(Input::get('nickname', ''));
    $pass = trim(Input::get('password', ''));
    $repartidor_id = trim(Input::get('repartidor_id', ''));
     //Log::info('first name: ' .  $nombre);
     //Log::info('birthday: ' .  $direccion);
     //Log::info('cienta: ' . $ncuenta);
    $useres = DB::table('usuarios')
      ->selectRaw('*')
      ->where('id', $id)
      ->first();

     $user = DB::table('repartidores')
      ->selectRaw('*')
      ->where('id', $id)
      ->first();
 // update
    DB::beginTransaction();
    try {
      
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // insert
       /* DB::table('repartidores')->insert(
          array(
            //'user_id' => $id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'ncarne' => $ncarne,
            
            
          )
        );*/

      if ($useres) {
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // update
        DB::table('usuarios')
          ->where('id', $id)
          ->update(array(
            'id' => $id,
            'nombre' => $nombre,
            'nickname' => $nickname,
            'password' => $pass,
            'repartidor_id' => $repartidor_id,
            
            
          ));
      }else{
        
        // insert
        DB::table('usuarios')->insert(
          array(
            
            'nombre' => $nombre,
            'nickname' => $nickname,
            'password' => $pass,
            'repartidor_id' => $repartidor_id,
            
            
          )
        );
      }
      

    

      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::error($e);
    }
  //else de validacion

    

    // get user data
    //$user = $this->getUserData($id);

    // display page 
    return View::make('page.updateUs', array(
      'page' => 'updateUs',
      'user' => $user,
    ));
     
   
  }

  public function updateRutaJ($id, $estado, $comentario)
  {

    $now = date('Y-m-d H:i:s');
    $response ='';
    DB::beginTransaction();
    try {
      //Session::flash('result', 'Los datos han sido actualizados con EXITO');
      
        //Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // update
        DB::table('rutas')
          ->where('ruta_id', $id)
          ->update(array(
            
            'estado' => $estado,
            'comentario' => $comentario,
            'updated_at' => $now,
          ));

          $response='exito';
      
      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::error($e);
      $response='error';
    }
    return Response::json(array('data' => $response));
  }


  public function updateRuta()
  {

    $clientes = DB::table('clientes')
      ->selectRaw('*')
      
      ->get();

      $repartidores = DB::table('repartidores')
      ->selectRaw('*')
      
      ->get();

    // parameters
    $now = date('Y-m-d H:i:s');
    $id = Input::get('ruta_id', 0);
    $nruta = trim(Input::get('nruta', ''));
    $cliente_id = trim(Input::get('cliente_id', ''));
    $repartidor_id = trim(Input::get('repartidor_id', ''));
    $pedido = trim(Input::get('pedido', ''));
    $direccion = trim(Input::get('direccion', ''));
     $nfactura = trim(Input::get('nfactura', ''));
      $norden = trim(Input::get('norden', ''));
       $nhr = trim(Input::get('nhr', ''));
      $sub = trim(Input::get('subcategory', ''));
     
     Log::info('id: ' . $id);
     Log::info('cliente_id: ' .  $cliente_id);
     Log::info('repartidor_id: ' . $repartidor_id);
     Log::info('pedido: ' . $pedido);
// get user data
    $user = DB::table('rutas')
      ->selectRaw('*')
      ->where('ruta_id', $id)
      ->first();
 // update
    DB::beginTransaction();
    try {
      Session::flash('result', 'Los datos han sido actualizados con EXITO');
      if ($user) {
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // update
        DB::table('rutas')
          ->where('ruta_id', $id)
          ->update(array(
            'nrutas' => $nruta,
            'cliente_id' => $cliente_id,
            'repartidor_id' => $repartidor_id,
            'pedido' => $pedido,
            'nfactura' => $nfactura,
            'norden' => $norden,
            'nhr' => $nhr,
            'updated_at' => $now,
            'direccion' => $direccion,
            'direccionu' => $sub,
            'estado' => '',
            'comentario' => '',
            'img' => '',
          ));
      }else{
        
        // insert
        DB::table('rutas')->insert(
          array(
            //'user_id' => $id,
            'nrutas' => $nruta,
            'cliente_id' => $cliente_id,
            'repartidor_id' => $repartidor_id,
            'pedido' => $pedido,
            'nfactura' => $nfactura,
            'norden' => $norden,
            'nhr' => $nhr,
            'created_at' => $now,
            'direccion' => $direccion,
            'direccionu' => $sub,
            'estado' => '',
            'comentario' => '',
            'img' => '',
            
            
          )
        );
      }

    

      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::error($e);
    }
  //else de validacion

    

    // get user data
    //$user = $this->getUserData($id);

    // display page 
    return View::make('page.ruta', array(
      'page' => 'ruta',
      'clientes' => $clientes,
      'repartidores' => $repartidores,
     
    ));
     
   
  }

  public function deleteRepartidor($id)
  {

    

    
   
// get user data
    $user = DB::table('repartidores')
      ->selectRaw('*')
      ->where('id', $id)
      ->first();
 // update
    DB::beginTransaction();
    try {
     // Session::flash('result', 'Los datos han sido eliminados con EXITO');
      if ($user) {
        Session::flash('result', 'Los datos han sido eliminados con EXITO');
        // update
        DB::table('repartidores')
          ->where('id', $id)
          ->delete();
          
      }

    

      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::error($e);
    }
  //else de validacion

    

    // get user data
    //$user = $this->getUserData($id);

    // display page 
    return View::make('page.repartidor', array(
      'page' => 'repartidor',
      
     
    ));
     
   
  }

  public function deleteCliente($id)
  {

    

    
   
// get user data
    $user = DB::table('clientes')
      ->selectRaw('*')
      ->where('id', $id)
      ->first();
 // update
    DB::beginTransaction();
    try {
     // Session::flash('result', 'Los datos han sido eliminados con EXITO');
      if ($user) {
        Session::flash('result', 'Los datos han sido eliminados con EXITO');
        // update
        DB::table('clientes')
          ->where('id', $id)
          ->delete();
          
      }

    

      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::error($e);
    }
  //else de validacion

    

    // get user data
    //$user = $this->getUserData($id);

    // display page 
    return View::make('page.cliente', array(
      'page' => 'cliente',
      
     
    ));
     
   
  }


  public function deleteRuta($id)
  {

    $clientes = DB::table('clientes')
      ->selectRaw('*')
      
      ->get();

      $repartidores = DB::table('repartidores')
      ->selectRaw('*')
      
      ->get();

    // parameters
    $now = date('Y-m-d H:i:s');
   // $id = Input::get('ruta_id', 0);
    $cliente_id = trim(Input::get('cliente_id', ''));
    $repartidor_id = trim(Input::get('repartidor_id', ''));
    $pedido = trim(Input::get('pedido', ''));
     $nfactura = trim(Input::get('nfactura', ''));
      $norden = trim(Input::get('norden', ''));
       $nhr = trim(Input::get('nhr', ''));
     
     Log::info('id: ' . $id);
     Log::info('cliente_id: ' .  $cliente_id);
     Log::info('repartidor_id: ' . $repartidor_id);
     Log::info('pedido: ' . $pedido);
// get user data
    $user = DB::table('rutas')
      ->selectRaw('*')
      ->where('ruta_id', $id)
      ->first();
 // update
    DB::beginTransaction();
    try {
     // Session::flash('result', 'Los datos han sido eliminados con EXITO');
      if ($user) {
        Session::flash('result', 'Los datos han sido eliminados con EXITO');
        // update
        DB::table('rutas')
          ->where('ruta_id', $id)
          ->delete();
          
      }

    

      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::error($e);
    }
  //else de validacion

    

    // get user data
    //$user = $this->getUserData($id);

    // display page 
    return View::make('page.ruta', array(
      'page' => 'ruta',
      'clientes' => $clientes,
      'repartidores' => $repartidores,
     
    ));
     
   
  }

  //DELETE CLIENTE

  public function deleteUsuarios($id)
  {

  
    // parameters
    
     
 
// get user data
    $users = DB::table('usuarios')
      ->selectRaw('*')
      ->where('id', $id)
      ->first();

      $user = DB::table('repartidores')
      ->selectRaw('*')
      ->get();
 // update
    DB::beginTransaction();
    try {
     // Session::flash('result', 'Los datos han sido eliminados con EXITO');
      if ($users) {
        Session::flash('result', 'Los datos han sido eliminados con EXITO');
        // update
        DB::table('usuarios')
          ->where('id', $id)
          ->delete();
          
      }

    

      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::error($e);
    }
  //else de validacion

    

    // get user data
    //$user = $this->getUserData($id);

    // display page 
    return View::make('page.usuario', array(
      'page' => 'usuario',
      'users' => $users,
      'user' => $user,
     
    ));
     
   
  }



  public function SearchData($phone){

    if (strlen($phone)>=8){

$users = DB::table('user')
      ->selectRaw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user.disabled, user.created_at, user.updated_at, count(*) AS messages')
      ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->leftJoin('message', 'user.id', '=', 'message.user_id')
      //->where('user.phone','like', $phone)
      ->where('user.phone', 'LIKE', '%'.$phone.'%')
      ->orderBy('user.created_at', 'desc')
      ->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user.disabled, user.created_at, user.updated_at'))
      ->paginate(20);
   
// display page 
    return View::make('page.users', array(
      'page' => 'users',
      'users' => $users,
    ));
    }
    else{

      
$messages = DB::table('message')
      ->select('message.id', 'message.user_id', 'user.phone','user_info.firstname', 'user.telco', 'message.shortnumber', 'message.msg', 'message.msg_out', 'message.created_at')
      ->join('user', 'message.user_id', '=', 'user.id')
      ->join('user_info', 'user.id', '=', 'user_info.user_id')
      ->where('message.msg','like', $phone)
      ->orderBy('message.created_at', 'desc')
      ->paginate(20);

    // display page 
    return View::make('page.messages', array(
      'page' => 'messages',
      'messages' => $messages,
    ));


    }

    }



    ///BUSQUEDA CLIENTES
    public function SearchCliente($nombre){

    

 $users = DB::table('clientes')
      ->selectRaw('*')
      ->where('clientes.nombre','LIKE', '%'.$nombre.'%')
      //->where('message.msg_out', '0')
      //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      
      //->groupBy(DB::raw('rutas.ruta_id'))
      ->paginate(20);
   
// display page 
    return View::make('page.infoCliente', array(
      'page' => 'infoCliente',
      'users' => $users,
    ));
    
    

    }


      public function SearchReguardsData($phone){

    if (strlen($phone)>=8){

/*$users = DB::table('user')
      ->selectRaw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user.disabled, user.created_at, user.updated_at, count(*) AS messages')
      ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->leftJoin('message', 'user.id', '=', 'message.user_id')
      //->where('user.phone','like', $phone)
      ->where('user.phone', 'LIKE', '%'.$phone.'%')
      ->orderBy('user.created_at', 'desc')
      ->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user.disabled, user.created_at, user.updated_at'))
      ->paginate(20);*/

       $users = DB::table('reguards')
      ->selectRaw('reguards.id,reguards.user_id, reguards.codigo,reguards.estado, reguards.updated_at, user.phone, user.telco, user_info.firstname, user_info.lastname')
      ->leftJoin('user_info', 'reguards.user_id', '=', 'user_info.user_id')
      ->leftJoin('user', 'reguards.user_id', '=', 'user.id')
      ->where('validate','1')
      //->whereBetween('reguards.updated_at', array($inicio, $fin))
      ->where('user.phone', 'LIKE', '%'.$phone.'%')
       //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      //->groupBy(DB::raw('user.id'))
      ->paginate(50);
   
// display page 
    return View::make('page.searchReguard', array(
      'page' => 'searchReguard',
      'users' => $users,
    ));
    }
    else{

      
  $users = DB::table('reguards')
      ->selectRaw('reguards.id,reguards.user_id, reguards.codigo,reguards.estado, reguards.updated_at, user.phone, user.telco, user_info.firstname, user_info.lastname')
      ->leftJoin('user_info', 'reguards.user_id', '=', 'user_info.user_id')
      ->leftJoin('user', 'reguards.user_id', '=', 'user.id')
      ->where('validate','1')
      //->whereBetween('reguards.updated_at', array($inicio, $fin))
      ->where('reguards.codigo', 'LIKE', '%'.$phone.'%')
       //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      //->groupBy(DB::raw('user.id'))
      ->paginate(50);

    // display page 
    return View::make('page.searchReguard', array(
      'page' => 'searchReguard',
      'users' => $users,
    ));


    }

    }
public function exelRep($repartidor){
 // $data = DB::table('user_info')->get();
   set_time_limit(0);
  
   

     $data = DB::table('rutas')
      ->selectRaw('rutas.created_at,rutas.updated_at, rutas.ruta_id, clientes.nombre, clientes.direccion, clientes.ncuenta, rutas.pedido,rutas.direccion as direc, rutas.nfactura,rutas.norden,rutas.nhr, repartidores.nombre as rname, repartidores.apellido')
      //->where('message.msg_out', '0')
      //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      ->leftJoin('clientes', 'rutas.cliente_id', '=', 'clientes.id')
      ->leftJoin('repartidores', 'rutas.repartidor_id', '=', 'repartidores.id')
      ->where('repartidor_id',$repartidor)
      ->groupBy(DB::raw('rutas.ruta_id'))
      ->get();
   // Log::info("reguard: " . print_r($data, true));

  Excel::create($repartidor, function($excel) use($data) {

    $excel->sheet('Sheetname', function($sheet) use($data) {
              
        $sheet->cells('A2:k2', function($cells) {
                          $cells->setFont(array(
                                  'family'     => 'Calibri',
                                  'size'       => '16',
                                  'bold'       =>  true
                              ));
           });

              //TITULOS
              $sheet->fromArray(array( 
                    array('Fecha creacion','actualizacion','ruta N.','nombre cliente','direccion cliente','numero de cuenta','pedido','factura','numero orden','numero hr', 'repartidor')
              
              ));
            //CONTENIDO
            foreach ($data as $user) 
            {
              
              $sheet->fromArray(array(
                      array($user->created_at,$user->updated_at,$user->ruta_id,$user->nombre,$user->direccion,$user->ncuenta,$user->pedido,$user->nfactura,$user->norden,$user->nhr, $user->rname, $user->apellido)
              ));
            }
      });

   })->download('csv');//->download($tipo);
}



public function exelHR($hr){
 // $data = DB::table('user_info')->get();
   set_time_limit(0);
  
   

     $data = DB::table('rutas')
      ->selectRaw('rutas.created_at,rutas.updated_at, rutas.ruta_id, clientes.nombre, clientes.direccion, clientes.ncuenta, rutas.pedido,rutas.direccion as direc, rutas.nfactura,rutas.norden,rutas.nhr, repartidores.nombre as rname, repartidores.apellido')
      //->where('message.msg_out', '0')
      //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      ->leftJoin('clientes', 'rutas.cliente_id', '=', 'clientes.id')
      ->leftJoin('repartidores', 'rutas.repartidor_id', '=', 'repartidores.id')
      ->where('nhr',$hr)
      ->groupBy(DB::raw('rutas.ruta_id'))
      ->get();
   // Log::info("reguard: " . print_r($data, true));

  Excel::create($hr, function($excel) use($data) {

    $excel->sheet('Sheetname', function($sheet) use($data) {
              
        $sheet->cells('A2:k2', function($cells) {
                          $cells->setFont(array(
                                  'family'     => 'Calibri',
                                  'size'       => '16',
                                  'bold'       =>  true
                              ));
           });

              //TITULOS
              $sheet->fromArray(array( 
                    array('Fecha creacion','actualizacion','ruta N.','nombre cliente','direccion cliente','numero de cuenta','pedido','factura','numero orden','numero hr', 'repartidor')
              
              ));
            //CONTENIDO
            foreach ($data as $user) 
            {
              
              $sheet->fromArray(array(
                      array($user->created_at,$user->updated_at,$user->ruta_id,$user->nombre,$user->direccion,$user->ncuenta,$user->pedido,$user->nfactura,$user->norden,$user->nhr, $user->rname, $user->apellido)
              ));
            }
      });

   })->download('csv');//->download($tipo);
}



public function exelFec($fu, $fd){
 // $data = DB::table('user_info')->get();
   set_time_limit(0);
  $now = date('Y-m-d H:i:s');
   $data = DB::table('rutas')
      ->selectRaw('rutas.created_at,rutas.updated_at, rutas.ruta_id, clientes.nombre, clientes.direccion, clientes.ncuenta, rutas.pedido,rutas.direccion as direc, rutas.nfactura,rutas.norden,rutas.nhr, repartidores.nombre as rname, repartidores.apellido')
      //->where('message.msg_out', '0')
      //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      ->leftJoin('clientes', 'rutas.cliente_id', '=', 'clientes.id')
      ->leftJoin('repartidores', 'rutas.repartidor_id', '=', 'repartidores.id')
      //->where('repartidor_id',$repartidor)
      ->whereBetween('rutas.created_at', array($fu, $fd))
      ->groupBy(DB::raw('rutas.ruta_id'))
      ->get();
   // Log::info("reguard: " . print_r($data, true));

  Excel::create($now, function($excel) use($data) {

    $excel->sheet('Sheetname', function($sheet) use($data) {
              
        $sheet->cells('A2:k2', function($cells) {
                          $cells->setFont(array(
                                  'family'     => 'Calibri',
                                  'size'       => '16',
                                  'bold'       =>  true
                              ));
           });

              //TITULOS
              $sheet->fromArray(array( 
                    array('Fecha creacion','actualizacion','ruta N.','nombre cliente','direccion cliente','numero de cuenta','pedido','factura','numero orden','numero hr', 'repartidor')
              
              ));
            //CONTENIDO
            foreach ($data as $user) 
            {
              
              $sheet->fromArray(array(
                      array($user->created_at,$user->updated_at,$user->ruta_id,$user->nombre,$user->direccion,$user->ncuenta,$user->pedido,$user->nfactura,$user->norden,$user->nhr, $user->rname, $user->apellido)
              ));
            }
      });

   })->download('csv');//->download($tipo);
}


public function exelInfo(){
 // $data = DB::table('user_info')->get();
   set_time_limit(0);
 


    $data = DB::table('rutas')
      ->selectRaw('rutas.created_at,rutas.updated_at, rutas.ruta_id, clientes.nombre, clientes.direccion, clientes.ncuenta, rutas.pedido,rutas.nfactura,rutas.norden,rutas.nhr, repartidores.nombre as rname, repartidores.apellido')
      //->where('message.msg_out', '0')
      //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      ->leftJoin('clientes', 'rutas.cliente_id', '=', 'clientes.id')
      ->leftJoin('repartidores', 'rutas.repartidor_id', '=', 'repartidores.id')
      ->groupBy(DB::raw('rutas.ruta_id'))
      ->get();
     

  Excel::create('ruta_info', function($excel) use($data) {

    $excel->sheet('Sheetname', function($sheet) use($data) {
              
        $sheet->cells('A2:M2', function($cells) {
                          $cells->setFont(array(
                                  'family'     => 'Calibri',
                                  'size'       => '16',
                                  'bold'       =>  true
                              ));
           });

              //TITULOS
              $sheet->fromArray(array( 
                    array('Fecha creacion','actualizacion','ruta N.','nombre cliente','direccion cliente','numero de cuenta','pedido','factura','numero orden','numero hr', 'repartidor')
              
              ));
            //CONTENIDO
            foreach ($data as $user) 
            {
              
              $sheet->fromArray(array(
                      array($user->created_at,$user->updated_at,$user->ruta_id,$user->nombre,$user->direccion,$user->ncuenta,$user->pedido,$user->nfactura,$user->norden,$user->nhr, $user->rname, $user->apellido)
              ));
            }
      });

   })->download('csv');//->download($tipo);->store('csv', storage_path('excel/exports'))
} 

}
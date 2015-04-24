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
      ->selectRaw('rutas.created_at,rutas.updated_at, rutas.ruta_id, clientes.nombre, clientes.direccion, clientes.ncuenta, rutas.pedido,rutas.nfactura,rutas.norden,rutas.nhr, repartidores.nombre as rname, repartidores.apellido')
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

  public function showRuta()
  {
    // get user data
    //$user = $this->getUserData($id);
      $clientes = DB::table('clientes')
      ->selectRaw('*')
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


  public function showRutas($id)
  {
    $clientes = DB::table('clientes')
      ->selectRaw('*')
      
      ->get();

      $repartidores = DB::table('repartidores')
      ->selectRaw('*')
     
      ->get();

      $clientess = DB::table('clientes')
      ->selectRaw('*')
      
      ->first();

      $repartidoress = DB::table('repartidores')
      ->selectRaw('*')
     
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

  public function updateUser()
  {

    // parameters
    $now = date('Y-m-d H:i:s');
    $id = Input::get('user_id', 0);
    $firstname = trim(Input::get('firstname', ''));
    $lastname = trim(Input::get('lastname', ''));
    $email = trim(Input::get('email', ''));
    $dpi = trim(Input::get('dpi', ''));

    //$birthday = Input::get('birthday');
    $birthday = trim(Input::get('birthday', ''));
    $license = trim(Input::get('license', ''));
    $vehicle = trim(Input::get('vehicle', ''));
    $workplace = trim(Input::get('workplace', ''));
    $location = trim(Input::get('location', ''));
    $tons = trim(Input::get('tons', ''));
    $comments = trim(Input::get('comments', ''));


 
                
          
    Log::info('location: ' . $location);
    // Log::info('first name: ' . $firstname);
     //Log::info('birthday: ' . $birthday);

    // validating
    if ($id == 0) {
      return Redirect::route('users');
    }

    // get user data
    $user = DB::table('user')
      ->selectRaw('*')
      ->where('id', $id)
      ->first();
    $user_info = DB::table('user_info')
      ->selectRaw('*')
      ->where('user_id', $id)
      ->first();

    // exists?
    if (! $user) {
      return Redirect::route('users');
    }

    // update
    DB::beginTransaction();
    try {
      // user_info
      if ($user_info) {
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // update
        DB::table('user_info')
          ->where('user_id', $id)
          ->update(array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'dpi' => $dpi,
            'birthday' => $birthday,
            'license' => $license,
            'vehicle' => $vehicle,
            'workplace' => $workplace,
            'location' => $location,
            'tons' => $tons,
            'comments' => $comments,
          ));
      } else {
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // insert
        DB::table('user_info')->insert(
          array(
            'user_id' => $id,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'dpi' => $dpi,
            'birthday' => $birthday,
            'license' => $license,
            'vehicle' => $vehicle,
            'workplace' => $workplace,
            'location' => $location,
            'tons' => $tons,
            'comments' => $comments,
          )
        );
      }

      // user
      DB::table('user')
        ->where('id', $id)
        ->update(array(
          'updated_at' => $now,
        ));

      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::error($e);
    }
  //else de validacion

    

    // get user data
    $user = $this->getUserData($id);

    // display page 
    return View::make('page.user', array(
      'page' => 'user',
      'user' => $user,
    ));
     
   
  }


  public function updateCliente()
  {

    // parameters
    $now = date('Y-m-d H:i:s');
    //$id = Input::get('user_id', 0);
    $nombre = trim(Input::get('nombre', ''));
    $direccion = trim(Input::get('direccion', ''));
    $ncuenta = trim(Input::get('ncuenta', ''));
     //Log::info('first name: ' .  $nombre);
     //Log::info('birthday: ' .  $direccion);
     //Log::info('cienta: ' . $ncuenta);

 // update
    DB::beginTransaction();
    try {
      
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // insert
        DB::table('clientes')->insert(
          array(
            //'user_id' => $id,
            'nombre' => $nombre,
            'direccion' => $direccion,
            'ncuenta' => $ncuenta,
            
            
          )
        );
      

    

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
    //$id = Input::get('user_id', 0);
    $nombre = trim(Input::get('nombre', ''));
    $apellido = trim(Input::get('apellido', ''));
    $ncarne = trim(Input::get('ncarne', ''));
     //Log::info('first name: ' .  $nombre);
     //Log::info('birthday: ' .  $direccion);
     //Log::info('cienta: ' . $ncuenta);

 // update
    DB::beginTransaction();
    try {
      
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // insert
        DB::table('repartidores')->insert(
          array(
            //'user_id' => $id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'ncarne' => $ncarne,
            
            
          )
        );
      

    

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
      Session::flash('result', 'Los datos han sido actualizados con EXITO');
      if ($user) {
        Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // update
        DB::table('rutas')
          ->where('ruta_id', $id)
          ->update(array(
            'cliente_id' => $cliente_id,
            'repartidor_id' => $repartidor_id,
            'pedido' => $pedido,
            'nfactura' => $nfactura,
            'norden' => $norden,
            'nhr' => $nhr,
            'updated_at' => $now,
          ));
      }else{
        
        // insert
        DB::table('rutas')->insert(
          array(
            //'user_id' => $id,
            'cliente_id' => $cliente_id,
            'repartidor_id' => $repartidor_id,
            'pedido' => $pedido,
            'nfactura' => $nfactura,
            'norden' => $norden,
            'nhr' => $nhr,
            'created_at' => $now,
            
            
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
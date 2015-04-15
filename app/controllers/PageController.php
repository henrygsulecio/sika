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
    //$user;
    //$password;

    // user login
    Session::put('userLogged', 1);
    Session::regenerate();

    return Redirect::route('home');
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
    
    $users = DB::table('user')
      ->selectRaw('DISTINCT (user.phone) as telefono,user.created_at, user.telco, user_info.firstname, user_info.lastname, user_info.comments, count(message.msg_out) AS messages,message.user_id, user_info.location, user_info.vehicle,user_info.tons, 
      (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
        WHERE uc.user_id=user.id AND ct.name=\'cubeta\') AS cubetas,
      (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
      WHERE uc.user_id=user.id AND ct.name=\'galon\') AS galones')
      ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->leftJoin('point', 'user.id', '=', 'point.user_id')
      ->leftJoin('message', 'user.id', '=', 'message.user_id')
      ->leftJoin('user_code', 'user.id','=', 'user_code.user_id')
      ->leftJoin('code', 'user_code.code_id','=', 'code.id')
      ->leftJoin('code_type','code.code_type_id','=', 'code_type.id')
      ->where('message.msg_out', '0')
      //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      ->groupBy(DB::raw('user.id, message.msg_out'))
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
    $user = DB::table('user')
      ->selectRaw('user.*, user_info.*')
      ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->where('user.id', $id)
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


}
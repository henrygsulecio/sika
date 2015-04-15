<?php

class PageController extends BaseController {

  public function showDashboard()
  {
    $cache_time = 1;
    $days_to_display = 40;
    $init_promo_date = '2014-07-01';

    // getting traffic
    $traffic = Cache::remember('traffic-' . $days_to_display, $cache_time, function() use ($days_to_display, $init_promo_date) {
      $list = DB::table('message AS msg')
        ->selectRaw('DATE(msg.created_at) as day, COUNT(*) as messages, COUNT(DISTINCT msg.user_id) users')
        ->where('msg.msg_out', '0')
        ->whereRaw('DATE(msg.created_at) > ?', array($init_promo_date))
        ->whereRaw('DATE(msg.created_at) BETWEEN DATE_SUB(CURDATE(), INTERVAL ? DAY) AND CURDATE()', array($days_to_display))
        ->orderByRaw('DATE(msg.created_at) ASC')
        ->groupBy(DB::raw('DATE(msg.created_at)'))
        ->get();
      //Log::info(DB::getQueryLog());
      //adding visual help
      $pos = 0;
      foreach ($list as $key => $row) {
        $list[$key]->first = (($pos == 0) ? true : false);
        $list[$key]->last = (($pos == (count($list) - 1)) ? true : false);
        $list[$key]->even = (((($pos+1) % 2) == 0) ? true : false);
        $pos++;
      }
      //Log::info("traffic: " . print_r($list, true));
      return $list;
    });

    // resum all data
    $resum_all = Cache::remember('resum_all', $cache_time, function() use ($init_promo_date) {
      $list = DB::table('message AS msg')
        ->selectRaw('COUNT(*) as messages, COUNT(DISTINCT msg.user_id) users')
        ->where('msg.msg_out', '0')
        ->whereRaw('DATE(msg.created_at) > ?', array($init_promo_date))
        ->first();
      //Log::info($list);
      if ($list) {
        $list->playrate = ($list->users > 0) ? ($list->messages / $list->users) : 0;
      } else {
        $list = new SMSResum();
      }
      //Log::info("resum_all: " . print_r($list, true));
      return $list;
    });

    // resum by telcos
    $resum_telcos = Cache::remember('resum_telcos', $cache_time, function() use ($init_promo_date) {
      $telcos = new Telcos();
      $list = DB::table('message AS msg')
        ->selectRaw('u.telco, COUNT(*) as messages')
        ->leftJoin('user AS u', 'msg.user_id', '=', 'u.id')
        ->where('msg.msg_out', '0')
        ->whereRaw('DATE(msg.created_at) > ?', array($init_promo_date))
        ->groupBy('u.telco')
        ->get();
      //Log::info($list);
      foreach($list as $row) {
        switch ($row->telco) {
          case 'tigo':
            $telcos->tigo = $row->messages;
            break;
          case 'pcs':
            $telcos->claro = $row->messages;
            break;
          case 'movistar':
            $telcos->movistar = $row->messages;
            break;
        }
      }
      //Log::info("resum_telcos: " . print_r($telcos, true));
      return $telcos;
    });

    // resum week data
    $resum_week = Cache::remember('resum_week', $cache_time, function() use ($init_promo_date) {
      $list = DB::table('message AS msg')
        ->selectRaw('COUNT(*) as messages, COUNT(DISTINCT msg.user_id) users')
        ->where('msg.msg_out', '0')
        ->whereRaw('DATE(msg.created_at) > ?', array($init_promo_date))
        ->whereRaw('DATE(msg.created_at) BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND CURDATE()')
        ->first();
      //Log::info($list);
      if ($list) {
        $list->playrate = ($list->users > 0) ? ($list->messages / $list->users) : 0;
      } else {
        $list = new SMSResum();
      }
      //Log::info("resum_week: " . print_r($list, true));
      return $list;
    });

    // resum today data
    $resum_today = Cache::remember('resum_today', $cache_time, function() use ($init_promo_date) {
      $list = DB::table('message AS msg')
        ->selectRaw('COUNT(*) as messages, COUNT(DISTINCT msg.user_id) users')
        ->where('msg.msg_out', '0')
        ->whereRaw('DATE(msg.created_at) = CURDATE()')
        ->first();
      if ($list) {
        $list->playrate = ($list->users > 0) ? ($list->messages / $list->users) : 0;
      } else {
        $list = new SMSResum();
      }
      //Log::info("resum_today: " . print_r($list, true));
      return $list;
    });

    // display page 
    return View::make('page.dashboard', array(
      'page' => 'dashboard',
      'traffic' => $traffic,
      'resum_all' => $resum_all,
      'resum_telcos' => $resum_telcos,
      'resum_week' => $resum_week,
      'resum_today' => $resum_today,
      'cache_time' => $cache_time,
    ));
  }

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

  public function showUsers()
  {
    // users
    $users = DB::table('user')
      ->selectRaw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user.disabled, user.created_at, user.updated_at,message.msg, COUNT(*)as messages')
      ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->leftJoin('message', 'user.id', '=', 'message.user_id')
      ->where('message.msg_out', '0')
      ->orderBy('user.created_at', 'desc')
      ->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user.disabled, user.created_at, user.updated_at'))
      ->paginate(20);

    // display page 
    return View::make('page.users', array(
      'page' => 'users',
      'users' => $users,
    ));

   
  }

  public function showBirthday()
  {

    
    // users
    $users = DB::table('user')
      ->selectRaw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname,user_info.birthday, user.created_at, message.msg, COUNT(*)as messages')
      ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->leftJoin('message', 'user.id', '=', 'message.user_id')
      //->where('message.msg_out', '0')
      //->whereBetween('user_info.birthday', array($fromu,$tou))
      ->whereRaw('month(user_info.birthday)=month(CURDATE())')
      ->orderBy('user_info.birthday', 'desc')
      ->groupBy(DB::raw('user.id,user_info.birthday, user.phone, user.telco, user_info.firstname, user_info.lastname, user.created_at'))
      ->paginate(20);

    // display page 
    return View::make('page.birthday', array(
      'page' => 'birthday',
      'users' => $users,
    ));

   
  }

  public function showUserRecord($phone)
  {
    //validos
    $valid = DB::table('user')
      ->selectRaw('user.id, user.phone, user_info.firstname, user_info.lastname, code.code, point.points, user_code.created_at')
      ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->leftJoin('point', 'user.id', '=', 'point.user_id')
      ->leftJoin('message', 'user.id', '=', 'message.user_id')
      ->leftJoin('user_code', 'user.id', '=', 'user_code.user_id')
      ->leftJoin('code', 'user_code.code_id', '=', 'code.id')
      ->leftJoin('code_type', 'code.code_type_id', '=', 'code_type.id')
      //->where('message.msg_out', '0')
      ->where('user.phone', $phone)
      //->groupBy(DB::raw('user.phone, code_type.name'))
      ->groupBy(DB::raw('user.id,user.phone,code.code'))
      //->orderBy('user.phone')
      ->paginate(20);

    // users
    $users = DB::table('user')
      ->selectRaw('user.id, user.phone, code_type.name, user.telco, user_info.firstname, user_info.lastname, message.created_at,message.msg')
      ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->leftJoin('message', 'user.id', '=', 'message.user_id')
      ->leftJoin('user_code', 'user.id', '=', 'user_code.user_id')
      ->leftJoin('code', 'user_code.code_id', '=', 'code.id')
      ->leftJoin('code_type', 'code.code_type_id', '=', 'code_type.id')
      ->where('message.msg_out', '0')
      ->where('user.phone', $phone)
      ->groupBy(DB::raw('user.id,message.msg, code_type.name'))
      //->groupBy(DB::raw('code_type.name'))
      ->orderBy('user.phone')
      ->paginate(20);


    //Log::info("record: " . print_r($users, true));
    // display page 
    return View::make('page.record', array(
      'page' => 'record',
      'users' => $users,
      'valid' => $valid,
    ));

   
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


  public function showReguard($mes, $ano)
  {
    // info
    $inicio = ''.$ano.'-'.$mes.'-01';
    $fin = ''.$ano.'-'.$mes.'-31';

    Log::info("info datos: " . print_r($inicio, true));

    $users = DB::table('reguards')
      ->selectRaw('reguards.id,reguards.user_id, reguards.codigo,reguards.estado, reguards.updated_at, user.phone, user.telco, user_info.firstname, user_info.lastname')
      ->leftJoin('user_info', 'reguards.user_id', '=', 'user_info.user_id')
      ->leftJoin('user', 'reguards.user_id', '=', 'user.id')
      ->where('validate','1')
      ->whereBetween('reguards.updated_at', array($inicio, $fin))
       //->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      //->groupBy(DB::raw('user.id'))
      ->paginate(50);
     //Log::info("info datos: " . print_r($users, true));
    // display page 
    return View::make('page.reguard', array(
      'page' => 'reguard',
      'ano' => $ano,
      'users' => $users,
      'mes' => $mes,
    ));
  }

  // public function showReport($fu,$fd,$ft)
   public function showReport($mesu, $mesd, $mest, $ano)
  {
    set_time_limit(0);
    // info
    $now = date('Y-m-d H:i:s');
   
    $fu= ''.$ano.'-'.$mesu.'-01';
    $fd= ''.$ano.'-'.$mesd.'-01';
    $ft= ''.$ano.'-'.$mest.'-01';
    //Log::info("info datos: " . print_r($fu, true));
    
    $pm = DB::table('user')
      ->selectRaw('user.id,user.phone, user.created_at, user.telco, user_info.firstname, user_info.lastname, user_info.comments, count(message.msg_out) AS messages,message.user_id, user_info.location, user_info.vehicle,user_info.tons, 
      (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
        WHERE uc.user_id=user.id AND month(uc.created_at)=month("'.$fu.'") AND ct.name=\'cubeta\') AS cubetasu,
      (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
      WHERE uc.user_id=user.id AND month(uc.created_at)=month("'.$fu.'") AND ct.name=\'galon\') AS galonesu,
       (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
      WHERE uc.user_id=user.id AND month(uc.created_at)=month("'.$fd.'") AND ct.name=\'cubeta\') AS cubetasd,
        (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
      WHERE uc.user_id=user.id AND month(uc.created_at)=month("'.$fd.'") AND ct.name=\'galon\') AS galonesd,
         (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
      WHERE uc.user_id=user.id AND month(uc.created_at)=month("'.$ft.'") AND ct.name=\'cubeta\') AS cubetast,
          (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
      WHERE uc.user_id=user.id AND month(uc.created_at)=month("'.$ft.'") AND ct.name=\'galon\') AS galonest')
      ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->leftJoin('point', 'user.id', '=', 'point.user_id')
      ->leftJoin('message', 'user.id', '=', 'message.user_id')
      ->leftJoin('user_code', 'user.id','=', 'user_code.user_id')
      ->leftJoin('code', 'user_code.code_id','=', 'code.id')
      ->leftJoin('code_type','code.code_type_id','=', 'code_type.id')
      ->where('message.msg_out', '0')
      ->whereRaw('YEAR(message.created_at) = ?',array($ano))
      //->where('user_code.created_at','BETWEEN',$fechas)
      //->whereBetween('message.created_at', array($fromu,$tou))
      //->whereRaw('DATE(user_code.created_at) BETWEEN ? AND ?',array($fechau,$fechad))
      //->groupBy(DB::raw('user.id, message.msg_out'))
       ->groupBy(DB::raw('user.id'))
      ->paginate(30);


     //Log::info("info datos: " . print_r($users, true));
    // display page 
    return View::make('page.report', array(
      'page' => 'report',
      'pm' => $pm,
      'mesu' => $mesu,
      'mesd' => $mesd,
      'mest' => $mest,
      'ano' => $ano,
      
    ));
  }

  public function ShowRango(){

       return View::make('page.rangoReport', array(
      'page' => 'page.rangoReport',
      
    ));

  }

    public function ShowRangoMes(){

       return View::make('page.rangoReguard', array(
      'page' => 'page.rangoReguard',
      
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

public function exelInfo(){
 // $data = DB::table('user_info')->get();
   set_time_limit(0);
   /*$data = DB::table('user')
      ->selectRaw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user_info.comments, user.disabled, user.created_at, point.updated_at, point.points, point.description, count(*) AS messages')
       ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
       ->leftJoin('point', 'user.id', '=', 'point.user_id')
      ->leftJoin('message', 'user.id', '=', 'message.user_id')
      ->where('message.msg_out', '0')
      ->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.points, point.description'))
      ->get();
      */


    $data = DB::table('user')
      ->selectRaw('DISTINCT user.phone as telefono,user.created_at, user.telco, user_info.firstname, count(message.msg_out) AS messages,message.user_id, user_info.location, user_info.vehicle,user_info.tons, 
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
      ->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user_info.location, user_info.vehicle, user_info.tons, user.disabled, user.created_at, point.updated_at, point.description'))
      ->get();

  Excel::create('user_info', function($excel) use($data) {

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
                    array('Fecha','Nombre','Telefono','Telco','Mensaje','Compra galon','Compra Cubeta','Puntos','Departamento','Tipo Vehiculo','Toneladas')
              
              ));
            //CONTENIDO
            foreach ($data as $user) 
            {
              
              $sheet->fromArray(array(
                      array($user->created_at,$user->firstname,$user->telefono,$user->telco,$user->messages,$user->galones,$user->cubetas,($user->galones*20) + ($user->cubetas*50),$user->location,$user->vehicle,$user->tons)
              ));
            }
      });

   })->download('csv');//->download($tipo);->store('csv', storage_path('excel/exports'))
} 

public function exelMessage(){
 // $data = DB::table('user_info')->get();
   set_time_limit(0);
   $data = DB::table('message')
      ->select('message.id', 'message.user_id', 'user.phone', 'user.telco', 'message.shortnumber', 'message.msg', 'message.msg_out', 'message.created_at')
      ->join('user', 'message.user_id', '=', 'user.id')
      ->orderBy('message.created_at', 'desc')
      ->get();

  Excel::create('message', function($excel) use($data) {

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
                    array('Phone','Telcos','Msg','Message_OUT','Created_at')
              
              ));
            //CONTENIDO
            foreach ($data as $user) 
            {
              
              $sheet->fromModel(array(
                      array($user->phone,$user->telco,$user->msg,($user->msg_out) ? 'out' : 'in',$user->created_at)
              ));
            }
      });

   })->download('csv');//->export('csv');//->download($tipo);->store('csv', storage_path('excel/exports'))
}

public function exelBirthday(){
 // $data = DB::table('user_info')->get();
   set_time_limit(0);

     $data = DB::table('user')
      ->selectRaw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname,user_info.birthday, user.created_at, message.msg, COUNT(*)as messages')
      ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->leftJoin('message', 'user.id', '=', 'message.user_id')
      
      ->whereRaw('month(user_info.birthday)=month(CURDATE())')
      ->orderBy('user_info.birthday', 'desc')
      ->groupBy(DB::raw('user.id,user_info.birthday, user.phone, user.telco, user_info.firstname, user_info.lastname, user.created_at'))
      ->get();
  

  Excel::create('Birthday', function($excel) use($data) {

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
                    array('id','Phone','Telcos','firstname','lastname','birthday','created_at','N. sms')
              
              ));
            //CONTENIDO
            foreach ($data as $user) 
            {
              
              $sheet->fromModel(array(
                      array($user->id,$user->phone,$user->telco,$user->firstname,$user->lastname,$user->birthday,$user->created_at,$user->messages)
              ));
            }
      });

   })->download('csv');//->export('csv');//->download($tipo);->store('csv', storage_path('excel/exports'))
}


public function exelUser(){
 // $data = DB::table('user_info')->get();
   set_time_limit(0);
   $data = DB::table('user')
      ->selectRaw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user.disabled, user.created_at, user.updated_at, count(*) AS messages')
      ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->leftJoin('message', 'user.id', '=', 'message.user_id')
      ->where('message.msg_out', '0')
      ->orderBy('user.created_at', 'desc')
      ->groupBy(DB::raw('user.id, user.phone, user.telco, user_info.firstname, user_info.lastname, user.disabled, user.created_at, user.updated_at'))
      ->get();

  Excel::create('user', function($excel) use($data) {

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
                    array('Phone','Telcos','firstname','Message','disabled','created_at','updated_at')
              
              ));
            //CONTENIDO
            foreach ($data as $user) 
            {
              
              $sheet->fromArray(array(
                      array($user->phone,$user->telco,$user->firstname,$user->messages,$user->disabled,$user->created_at,$user->updated_at)
              ));
            }
      });

   })->store('csv', storage_path('excel/exports'))->download('csv');//->download($tipo);
}

public function exelReguards($mes, $ano){
 // $data = DB::table('user_info')->get();
   set_time_limit(0);
  
   $inicio = ''.$ano.'-'.$mes.'-01';
    $fin = ''.$ano.'-'.$mes.'-31';

    $data = DB::table('reguards')
      ->selectRaw('reguards.user_id, reguards.codigo, reguards.updated_at, user.phone, user.telco, user_info.firstname, user_info.lastname,reguards.estado')
      ->leftJoin('user_info', 'reguards.user_id', '=', 'user_info.user_id')
      ->leftJoin('user', 'reguards.user_id', '=', 'user.id')
      ->where('validate','1')
      ->whereBetween('reguards.updated_at', array($inicio, $fin))
      ->get();
   // Log::info("reguard: " . print_r($data, true));

  Excel::create('reguards', function($excel) use($data) {

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
                    array('Fecha','Apellido','Nombre','Telefono','Telco','Codigo','Estado')
              
              ));
            //CONTENIDO
            foreach ($data as $user) 
            {
              
              $sheet->fromArray(array(
                      array($user->updated_at,$user->lastname,$user->firstname,$user->phone,$user->telco,$user->codigo, $user->estado)
              ));
            }
      });

   })->download('csv');//->download($tipo);
}

public function exelReport($mesu, $mesd, $mest, $ano){
 // $data = DB::table('user_info')->get();
   set_time_limit(0);
  
    $fu= ''.$ano.'-'.$mesu.'-01';
    $fd= ''.$ano.'-'.$mesd.'-01';
    $ft= ''.$ano.'-'.$mest.'-01';


    $data = DB::table('user')
      ->selectRaw('user.id,user.phone, user.created_at, user.telco, user_info.firstname, user_info.lastname, user_info.comments, count(message.msg_out) AS messages,message.user_id, user_info.location, user_info.vehicle,user_info.tons, 
      (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
        WHERE uc.user_id=user.id AND month(uc.created_at)=month("'.$fu.'") AND ct.name=\'cubeta\') AS cubetasu,
      (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
      WHERE uc.user_id=user.id AND month(uc.created_at)=month("'.$fu.'") AND ct.name=\'galon\') AS galonesu,
       (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
      WHERE uc.user_id=user.id AND month(uc.created_at)=month("'.$fd.'") AND ct.name=\'cubeta\') AS cubetasd,
        (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
      WHERE uc.user_id=user.id AND month(uc.created_at)=month("'.$fd.'") AND ct.name=\'galon\') AS galonesd,
         (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
      WHERE uc.user_id=user.id AND month(uc.created_at)=month("'.$ft.'") AND ct.name=\'cubeta\') AS cubetast,
          (SELECT COUNT(*) 
        FROM user_code uc
        LEFT JOIN code c ON uc.code_id=c.id
        LEFT JOIN code_type ct ON c.code_type_id=ct.id
      WHERE uc.user_id=user.id AND month(uc.created_at)=month("'.$ft.'") AND ct.name=\'galon\') AS galonest')
      ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->leftJoin('point', 'user.id', '=', 'point.user_id')
      ->leftJoin('message', 'user.id', '=', 'message.user_id')
      ->leftJoin('user_code', 'user.id','=', 'user_code.user_id')
      ->leftJoin('code', 'user_code.code_id','=', 'code.id')
      ->leftJoin('code_type','code.code_type_id','=', 'code_type.id')
      ->where('message.msg_out', '0')
      ->whereRaw('YEAR(message.created_at) = ?',array($ano))
       ->groupBy(DB::raw('user.id'))
      ->get();

    //Log::info("report: " . print_r($data, true));

  Excel::create('report', function($excel) use($data) {

    $excel->sheet('Sheetname', function($sheet) use($data) {
              
        $sheet->cells('A2:k2', function($cells) {
                          $cells->setFont(array(
                                  'family'     => 'Calibri',
                                  'size'       => '16',
                                  'bold'       =>  true
                              ));
           });
              //Encabezados
              $sheet->fromArray(array( 
                    array('Datos','Primer mes', 'Segundo mes', 'Tercer mes')
              
              ));
              //TITULOS
              $sheet->fromArray(array( 
                    array('Apellido','Nombre','Telefono','Compra Galon','Compra Cubeta','Compra Galon','Compra Cubeta','Compra Galon','Compra Cubeta')
              
              ));
            //CONTENIDO
            foreach ($data as $user) 
            {
              
              $sheet->fromArray(array(
                      array($user->lastname,$user->firstname,$user->phone,$user->cubetasu,$user->galonesu, $user->cubetasd,$user->galonesd, $user->cubetast,$user->galonest)
              ));
            }
      });

   })->download('csv');//->download($tipo);
}

  public function showMessages()
  {
    // messages
   $messages = DB::table('message')
      ->select('message.id', 'message.user_id', 'user.phone','user_info.firstname', 'user.telco', 'message.shortnumber', 'message.msg', 'message.msg_out', 'message.created_at')
      ->leftJoin('user', 'message.user_id', '=', 'user.id')
      ->leftJoin('user_info', 'user.id', '=', 'user_info.user_id')
      ->orderBy('message.created_at', 'desc')
      ->paginate(20);

    // display page 
    return View::make('page.messages', array(
      'page' => 'messages',
      'messages' => $messages,
    ));
  }
}
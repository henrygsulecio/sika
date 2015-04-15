<?php

class SMSController extends BaseController
{
  const MSG_IN = 0;
  const MSG_OUT = 1;
  const CODE_OK = 1;
  const CODE_DUPLICATE = 2;
  const CODE_ERROR = -1;
  const PHONE_REGUARD = 3;
  const INIT_DATE = '2014-11-03';

  /**
   * receive a sms messafge
   * @param  number   $phone        user phone
   * @param  number   $shortnumber  shortnumber
   * @param  string   $telco        phone telco
   * @param  string   $msg          message
   * @return json     response msgs
   */
  public function receive($phone, $shortnumber, $telco, $msg)
  {
    $phone = intval(trim(preg_replace('(\+|\-|\.)', '', $phone)));
    $shortnumber = intval(trim(preg_replace('(\+|\-|\.)', '', $shortnumber)));
    $telco = trim(strtolower($telco));
    $msg = trim($msg);
    $now = date('Y-m-d H:i:s');
    $msg_array = explode(' ', trim($msg) . ' '); // message split in array
    $command = strtoupper(array_shift($msg_array)); // getting 1st parameter (command)
    $message_plain = trim(implode(' ', $msg_array) . ' '); // message without command
    $welcome = false;
    $responses = array(
      'welcome' => "Bienvenido al mundo Mobil Delvac \"larga vida para tu motor\" . Los mensajes recibidos NO tienen costo y obtienes muchos beneficios que solo Mobil te ofrece.",
      'help' => "Comunidad Hombre Camion, es un servicio de Mobil, que te ofrece muchos beneficios, si deseas salirte envia BAJA, si quieres saber tus puntos envia PUNTOS",
      'points' => "Actualmente tienes {total_points} puntos, los codigos de galones suman {galon_point} y los de Cubeta suman {cubeta_point}. Estos pueden ser cambiado por diferentes premios",
      'disable_on' => "Te has dado de BAJA de nuestro servicio HOMBRE CAMION, si deseas ingresar de nuevo envia un ALTA al {shortnumber} y activa de nuevo tus puntos y beneficios",
      'disable_off' => "Bienvenido de nuevo, has activado {total_points} puntos, recuerda cada codigo ingresado sigue sumando! Estos puntos se pueden canjear por muchos beneficios",
      'code_ok' => "Hola {name} el codigo ingresado es correcto, te transferimos Q{recharge_money} en tiempo de aire. Gracias por tu compra Mobil Delvac! Dudas al 22798400",
      'code_used' => "Este codigo ya fue ingresado",
      'code_err' => "El codigo esta incorrecto, por favor intentalo de nuevo",
      'suscribe' => "Te has suscrito al grupo {group}.",
      'suscribe_err' => "Lo sentimos no existe el grupo indicado",
      'unsuscribe' => "Te has dado de baja al grupo {group}",
      'unsuscribe_err' => "Lo sentimos no existe el grupo indicado",
      'list' => "Actualmente estas suscrito a {group_list}",
      'phone_reguard' => "Felicitaciones! Por ingresar 2 Cubetas de MOBIL DELVAC tienes 1 mes de ASISTENCIA EN EL CAMINO para tu vehiculo! Llama al 23385745 indicando tu codigo:{reguard}",
    );

    // getting user
    $user = $this->getUserByPhone($phone, $telco, $welcome, $now);
    if ($user['id'] == -1) return $this->response('ERROR (1)');
    $welcome = $user['welcome'];

    // insert message
    $message_id = $this->insertMsg($user['id'], $shortnumber, $msg, self::MSG_IN, $now);

    // procesing command
    $response = '';
    $response2 = '';
    switch ($command) {
      case 'HELP':
      case 'AYUDA':
        $response = $responses['help'];
        break;

      case 'POINTS':
      case 'PUNTOS':
        $response = $responses['points'];
        $user_points = $this->getUserPoints($user['id']);
        $code_types = $this->getCodeTypes();
        $response = str_replace('{total_points}', $user_points['total'], $response);
        $response = str_replace('{galon_point}', $code_types['galon'], $response);
        $response = str_replace('{cubeta_point}', $code_types['cubeta'], $response);
        break;

      case 'BAJA':
      case 'CANCELAR':
      case 'SALIR':
        $this->disableUser($user['id']);
        $response = $responses['disable_on'];
        $response = str_replace('{shortnumber}', $shortnumber, $response);
        break;

      case 'ALTA':
        $this->disableUser($user['id'], false);
        $response = $responses['disable_off'];
        $user_points = $this->getUserPoints($user['id']);
        $response = str_replace('{total_points}', $user_points['total'], $response);
        break;

      case 'SUSCRIBIR':
        // TODO: suscribe user
        $response = $responses['suscribe'];
        break;

      case 'DESUSCRIBIR':
        // TODO: unsuscribe user
        $response = $responses['unsuscribe'];
        break;

      default:
        $code = $this->processCode($user['id'], $command, $phone, $telco);
        switch ($code['status']) {
          case self::CODE_OK:
            $response = $responses['code_ok'];
            break;
          case self::PHONE_REGUARD:
            $user_reguard = $this->getReguard($user['id']);
            $response2 = $responses['phone_reguard'];
            $response2 = str_replace('{reguard}', $user_reguard['reguard'], $response2);
            $response = $responses['code_ok'];
            
            break;
          case self::CODE_DUPLICATE:
            $response = $responses['code_used'];
            break;
          

          default:
            $response = $responses['code_err'];
            break;
        }
        $user_info = $this->getUserInfo($user['id']);
        $user_points = $this->getUserPoints($user['id']);
        $response = str_replace('{name}', $user_info['name'], $response);
        $response = str_replace('{points}', $code['type_points'], $response);
        $recharge_money = ($code['type_points'] == 50) ? "25.00" : "5.00";
        $response = str_replace('{recharge_money}', $recharge_money, $response);
        $response = str_replace('{total_points}', $user_points['total'], $response);
    }

    // welcome
    
    if ($welcome) {
      $response2 = $responses['welcome'];
      $message_id = $this->insertMsg($user['id'], $shortnumber, $response2, self::MSG_OUT, $now);
    }

    // response
    $message_id = $this->insertMsg($user['id'], $shortnumber, $response, self::MSG_OUT, $now);
    return $this->response($response, $response2);
  }

  /**
   * get user id by phone
   * @param  number   $phone      user phone
   * @param  string   $telco      phone telco
   * @param  bool     $welcome    return true if is first time
   * @param  date     $now        creation date
   * @return array    user data
   */
  protected function getUserByPhone($phone, $telco, $welcome, $now='')
  {
    // response
    $response = array(
      'status' => 0,
      'id' => 0,
      'welcome' => $welcome,
    );

    // now value
    $now = (strlen($now) > 0) ? $now : date('Y-m-d H:i:s');

    // telco
    switch ($telco) {
      case 'tigo':
      case 'pcs':
      case 'movistar':
        break;
      default:
        $response['status'] = -1;
        return $response;
    }

    // getting user_id by phone
    $user = DB::table('user')
      ->select('id')
      ->where('phone', '=', $phone)
      ->first();
    if ($user) {
      $response['id'] = $user->id;
      return $response;
    }

    // user not found, inserting new one
    $user_id = DB::table('user')->insertGetId(
      array(
        'phone' => $phone,
        'telco' => $telco,
        'created_at' => $now,
        'updated_at' => $now,
      )
    );

    // user created (firts time)
    $response['id'] = $user_id;
    $response['welcome'] = true;
    return $response;
  }

  /**
   * insert sms message (in/out)
   * @param  number   $user_id      user id
   * @param  number   $shortnumber  shortnumber
   * @param  string   $msg          message
   * @param  bool     $msg_out      message in (0) or out (1)
   * @param  date     $now          creation date
   * @return number   message_id
   */
  protected function insertMsg($user_id, $shortnumber, $msg, $msg_out, $now='')
  {
    // now value
    $now = (strlen($now) > 0) ? $now : date('Y-m-d H:i:s');

    // insert message
    $msg_id = DB::table('message')->insertGetId(
      array(
        'user_id' => $user_id,
        'shortnumber' => $shortnumber,
        'msg' => $msg,
        'msg_out' => $msg_out,
        'created_at' => $now,
      )
    );

    return $msg_id;
  }

  /**
   * process code
   * @param   number  $user_id    user id
   * @param   string  $code       code to validate
   * @param   string  $phone      user phone
   * @param   string  $telco      phone telco
   * @return  array   code
   */
  protected function processCode($user_id, $code, $phone, $telco)
  {
    $now = date('Y-m-d H:i:s');

    // response
    $response = array(
      'status' => 0,
      'id' => 0,
      'type_name' => '',
      'type_points' => 0,
    );

    // valid code leng
    if (strlen($code) != 7) {
      $response['status'] = self::CODE_ERROR;
      return $response;
    }

    // code exist?
    $code_db = DB::table('code')
      ->select('code.id', 'code_type.name AS type_name', 'code_type.points AS type_points')
      ->join('code_type', 'code.code_type_id', '=', 'code_type.id')
      ->where('code', '=', $code)
      ->first();
    if ($code_db) {
      $response['id'] = $code_db->id;
      $response['type_name'] = $code_db->type_name;
      $response['type_points'] = $code_db->type_points;
    } else {
      $response['status'] = self::CODE_ERROR;
      return $response;
    }

    // user already send code
    $user_code = DB::table('user_code')
      ->select('created_at')
      //->where('user_id', '=', $user_id)
      ->where('code_id', '=', $code_db->id)
      ->first();
    if ($user_code) {
      $response['status'] = self::CODE_DUPLICATE;
      return $response;
    }

    // register user_code
    try {
      DB::table('user_code')->insert(
        array(
          'user_id' => $user_id,
          'code_id' => $code_db->id,
          'created_at' => $now,
        )
      );
    } catch (Exception $e) {
      //Log::error($e);
    }

    // register user_point
    try {
      DB::table('point')->insert(
        array(
          'user_id' => $user_id,
          'points' => $code_db->type_points,
          'description' => 'REPORT CODE: ' . $code . ' / TYPE: '  . $code_db->type_name,
          'created_at' => $now,
          'updated_at' => $now,
        )
      );
    } catch (Exception $e) {
      //Log::error($e);
    }
    

    //prototipe reguards
    // amount of reguards by this cubeta query cubeta
    if (strpos($code, "C")===0) {
    //Log::info('$code ' . $code);
      $user_bucket_count = DB::table('point')
      ->where('user_id', $user_id)
      ->where('points','50')
      ->whereBetween('created_at', array(self::INIT_DATE, $now))
      //->whereRaw('created_at between ? and CURDATE()',array(self::INIT_DATE))
      ->count();

      //Hay mas de 50 codigos reguards?
       $code_reguards_count = DB::table('reguards')
      ->where('validate', 'NULL')
      ->count();
    Log::info('quedan ' . $code_reguards_count);

     //Log::info('$user_bucket_count ' . $user_bucket_count);

    // phone_REGUARDS
   if (($user_bucket_count % 2) == 0) {

     $amount = ($code_db->type_points == 50) ? 25 : 5; // 50=cubeta / other=galon
     $this->rechargePhone($phone, $telco, $amount);

     /*if ($code_reguards_count <=50) {

      $data = array(
        'cont'=>$code_reguards_count,
        );
       $fromEmail = 'it@mymobiletarget.com';
       $fromName = 'IT';
       $toEmail = 'alejandro@mobiletarget.me';
      
       Mail::send('page.mail',$data,function($message) use ($fromEmail,$fromName,$toEmail)
       {
            $message->to($toEmail,$fromName);
            $message->from($fromEmail,$fromName);
            $message->subject('menos de 50 codigos asistencia mobil oil');
       });
       Log::info('numero se envio ' . $code_reguards_count);
      
     }*/

    //Log::info('recarga de ' . $amount);
      //Log::info('reguards dos ' . $user_bucket_count);
      $response['status'] = self::PHONE_REGUARD;

      return $response;
     }
    } 
    

    // adding recharge
    $amount = ($code_db->type_points == 50) ? 25 : 5; // 50=cubeta / other=galon
    $this->rechargePhone($phone, $telco, $amount);
    //Log::info('recarga de fuera ' . $amount);

    // code ok
    $response['status'] = self::CODE_OK;
    return $response;
  }

  /**
   * get the extra user info
   * @param   number  $user_id      user id
   * @return  array   user extra user info
   */
  protected function getUserInfo($user_id)
  {
    $user = array(
      'name' => '',
    );

    // user info
    $user_info = DB::table('user_info')
      ->select('firstname')
      ->where('user_id', '=', $user_id)
      ->first();
    if ($user_info) {
      $user['name'] = $user_info->firstname;
    }

    return $user;
  }

  /**
   * get Reguard user id
   * @param   number  user_id   
   * @return  array    user info reguard
   */
  protected function getReguard($user_id)
  {
    $now = date('Y-m-d H:i:s');
    $user = array(
      'reguard' => '',
    );

    // user info
    $user_info = DB::table('reguards')
      ->select('codigo')
      ->where('validate','=','0')
      //->where('user_id', '=', $user_id)
      ->first();
    if ($user_info) {
      $user['reguard'] = $user_info->codigo;
    }

    // update
    DB::beginTransaction();
    try {
      // user_info
      if ($user_info) {
        //Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // update
        DB::table('reguards')
          ->where('codigo', $user_info->codigo)
          ->update(array(
            'user_id' => $user_id,
            'validate' => 1,
            'updated_at' => $now,
            
          ));
      } else {
        //Session::flash('result', 'Los datos han sido actualizados con EXITO');
        // insert
        //DB::table('user_info')->insert(
        // array(
        //    'user_id' => $id,
        //    'firstname' => $firstname,
        //    'lastname' => $lastname,
        //    'email' => $email,
        //    'dpi' => $dpi,
        //    'birthday' => $birthday,
        //    'license' => $license,
        //    'vehicle' => $vehicle,
        //    'workplace' => $workplace,
        //    'location' => $location,
        //    'tons' => $tons,
        //    'comments' => $comments,
        //  )
        //);//findb
      }

      // user
      //DB::table('user')
      // ->where('id', $id)
      // ->update(array(
      //   'updated_at' => $now,
      //));

      DB::commit();
    } catch (Exception $e) {
      DB::rollback();
      Log::error($e);
    }

    return $user;
  }

  /**
   * get user points
   * @param   number  $user_id      user id
   * @return  array   user points
   */
  protected function getUserPoints($user_id)
  {
    $points = array(
      'total' => 0,
    );

    // user total points
    $user_points = DB::table('point')
      ->where('user_id', '=', $user_id)
      ->sum('points');
    if ($user_points) {
      $points['total'] = $user_points;
    }

    return $points;
  }

  /**
   * get code types
   * @return  array   code types
   */
  protected function getCodeTypes()
  {
    $codes = array();

    // get code types
    $code_types = DB::table('code_type')
      ->select('name', 'points')
      ->get();
    if ($code_types) {
      foreach ($code_types as $code_type) {
        $codes[$code_type->name] = $code_type->points;
      }
    }

    return $codes;
  }



  /**
   * disable/enable user
   * @param   number  $user_id      user id
   */
  protected function disableUser($user_id, $disable=true)
  {
    $disable_on = ($disable) ? 1 : 0;

    // updating user
    try {
      DB::table('user')
        ->where('id', $user_id)
        ->update(array(
          'disabled' => $disable_on,
        ));
    } catch (Exception $e) {
      //Log::error($e);
    }
  }


  /**
   * recharge user phone (air time)
   */
  protected function rechargePhone($phone, $telco, $amount)
  {
    try {
      $url = 'http://recharge.mobiletarget.me/API/recharge';
      $phone = substr($phone, -8);
      $parameters = array(
        'phone' => $phone,
        'telco' => $telco,
        'amount' => $amount,
        'promo' => 'mobil',
        'source' => 'digitalocean',
        'test' => 0,
      );
      $c = curl_init($url);
      curl_setopt($c, CURLOPT_POST, true);
      curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($parameters));
      curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
      $output = curl_exec($c);
      $status = curl_getinfo($c, CURLINFO_HTTP_CODE); // OK=200 - TODO Validation
      curl_close($c);
      //Log::debug(print_r($output,true));

      $response = json_decode($output);
      Log::debug(print_r($response, true));
      // TODO process response

    } catch (Exception $e) {
      Log::error($e);
    }
  }

  /**
   * response message
   * @param  string $msg1      response message
   * @param  string $msg2      extra response message (second)
   * @return json   response msgs
   */
  protected function response($msg1, $msg2="") {
    return Response::json(array('msg1' => $msg1, 'msg2' => $msg2));
  }
}

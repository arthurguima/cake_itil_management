<?php
  @session_start();

  /*
   * validacao de usuario e senha no ldap
   */
  function valida_ldap($ldap_server, $auth_user, $auth_pass, $converter, $token, $idFunc, $start_page)
  {
    if(strlen($token)===0)
    {
      $sr 		= "";
      $dn 		= "";
      $user		= $auth_user;
      $connect 	= @ldap_connect($ldap_server);
      ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3);
      ldap_set_option($connect, LDAP_OPT_REFERRALS, 0);
      if (preg_match("/([a-zA-Z])([0-9]+)/", $auth_user, $regs)) {
        $auth_user = $regs[2] ;
      }
      $srfor 		= "(|(uid=$auth_user)(employeeNumber=$auth_user)(employeeNumber=$auth_user))";
      /*
       * $sr = @ldap_search($connect, "ou=DATAPREV,dc=gov,dc=br", $srfor);
      * Resource id #6
      * $sr MENOS RESTRITIVO E PARA LOGAR OS ACESSOS EXTERNOS
      */
      $sr 	= @ldap_search($connect, "", $srfor);
      $info 	= @ldap_get_entries($connect, $sr);
      if ($info["count"] === 1) {
        $ldap_dn 	= $info[0]["dn"];
        $auth_user 	= $info[0]["employeenumber"][0];
        if (!($bind = @ldap_bind($connect, $ldap_dn , $auth_pass))) {
          return -2;
        }
        else{
          $_SESSION['cdUsuario'] 		= $info[0]['employeenumber'][0];
          $_SESSION['idFuncionario'] 	= $info[0]['uidnumber'][0];
          $_SESSION['estUser'] 		= $info[0]['rguf'][0];
          $_SESSION['nmUsuario'] 		= $info[0]['cn'][0];
          $_SESSION['telefone']       = $info[0]['telephonenumber'][0];
          $_SESSION['ou'] 			= $ldap_dn;
          $_SESSION['unidade']    	= isset($info[$i]['ou'][0]) ? $info[$i]['ou'][0] : 'N/A';
          $_SESSION['email']			= $info[0]['mail'][0];
          $_SESSION['entidade']		= '';
          $_SESSION['auth_user']		= $user;
          $_SESSION['auth_pass']		= $converter->encode($auth_pass);
          $_SESSION['senha_sistema']	= 'mdT_XGFO6P8tlA2zSHOWB5T_GGQUFdrkF4_yyyXH6rQ';
          $_SESSION['start_page']		= $start_page;
          $_SESSION['usu_nick']		= str_replace('.', '_', $user);
          $arr_nome 					= preg_split('(-)', $_SESSION['nmUsuario']);
          $_SESSION['nome'] 			= trim($arr_nome[0]);
          $_SESSION['mensagem']		= '';
          return 1;
        }
      }
      else
      {
        return -1;
      }
    }
  }
  /*
   * consulta nomes a partir dos emails dos participantes
   */
  function consulta_email($email){
    $serv		= ldap_connect("mmldapsp");
    $valor		= strtolower($email);
    if ($serv)
    {
      $campos = array("cn", "mail", "employeenumber", "uidnumber");
      $result	= ldap_search($serv, 'dc=gov,dc=br', "(|(mail=*$valor*))", $campos);
      $info 	= ldap_get_entries($serv, $result);
      $result = array();
      for ($i=0; $i<$info["count"]; $i++)
      {
        array_push($result, array(
        "name" => $info[$i]["cn"][0],
        "to" => $info[$i]["mail"][0],
        "id" => $info[$i]["employeenumber"][0],
        "uid" => $info[$i]["uidnumber"][0]
        ));
      }
      ldap_close($serv);
      return $result;
    }
    else
    {
      return $result;
    }
  }
  /*
   * para verificar as fotos
   */
  function consultaEmployeeNumber($email){
    $serv	= ldap_connect("mmldapsp");
    if ($serv)
    {
      $campos = array("cn", "mail", "employeeNumber");
      $result =ldap_search($serv, 'dc=gov,dc=br', "(|(mail=*$email*))", $campos);
      $info  = ldap_get_entries($serv, $result);
      $number = $info[0]['employeenumber'][0];
      return $number;
    }
  }
  /*
   * para verificar o telefone
   */
  function consultaTelephoneNumber($email){
    $serv	= ldap_connect("mmldapsp");
    if ($serv)
    {
      $campos = array("cn", "mail", "employeeNumber", "telephonenumber");
      $result =ldap_search($serv, 'dc=gov,dc=br', "(|(mail=*$email*))", $campos);
      $info  = ldap_get_entries($serv, $result);
      $number = $info[0]['telephonenumber'][0];
      return $number;
    }
  }
  /*
   * Formata m�scara
   */
  function mask($val, $mask){
    $maskared = '';
    $k = 0;
    for($i = 0; $i<=strlen($mask)-1; $i++){
      if($mask[$i] == '#'){
        if(isset($val[$k]))
        $maskared .= $val[$k++];
      }
      else{
        if(isset($mask[$i]))
          $maskared .= $mask[$i];
      }
    }
    return $maskared;
  }
?>

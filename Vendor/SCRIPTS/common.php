<?php
ini_set('max_execution_time', 0);

//In order to show more line using var_dump
      ini_set('xdebug.var_display_max_depth', 1000024);
      ini_set('xdebug.var_display_max_children', 1000024);
      ini_set('xdebug.var_display_max_data', 1000024);

  // pega o primeiro dia do mês atual no formato Unix Time que é o formato que o SDM armazena datas
    $primeiroDiaMes = mktime(0,0,0, date('m'),1,date('y'));
    $ultimoDiaMes = mktime(0,0,0, date('m')+1,1,date('y'));
    $primeiroDiaMes = mktime(0,0,0, date('m'),1,date('y'));
    $primeiroDiaAno = mktime(0,0,0, 1,1,date('y'));
    $primeiroDiaProxAno = mktime(0,0,0, 1,1,date('y')+1);
    $ultimoDiaMes = mktime(0,0,0, date('m')+1,1,date('y'));
    $hoje = strtotime('00:00:00');
    $amanha = strtotime('+1 day', $hoje);
    $ontem = strtotime('-1 day', $hoje);

// END - Define params ##########################################################

  function connectToSGS(){
    //SGS's HOST
     $hostBDSGS = "10.16.35.12";
     //$hostBDSGS = "127.0.0.1";
    //SGS's user
     $usernameBDSGS = "USR_APPS";
     //$usernameBDSGS = "root";
    //SGS's pswd
     $passwordBDSGS = "%apps&2014";
     //$passwordBDSGS = "";
    //SGS's database
     $nomenclaturaBDSGS = "DITE_SGD";
     //$nomenclaturaBDSGS = "sgd2";

    //conect to mysql
    $con = new mysqli($hostBDSGS, $usernameBDSGS, $passwordBDSGS, $nomenclaturaBDSGS);
    if ($con->connect_errno) {
      printf("A Conexão com SGS falhou: %s\n", $con->connect_error);
      exit();
    }
    if (!$con->set_charset("utf8")) {
      printf("Error loading character set utf8: %s\n", $con->error);
    exit();
    } else {
      //printf("Current character set: %s\n", $con->character_set_name());
    }

    return $con;
  }

  function getSistemasSgs(){
    $con = connectToSGS();
    //Select SGS Systems
      // DEBUG
        //$sql = "SELECT `id`, `id_sdm`, `nome`, `responsavel_id` FROM `servicos` WHERE `id` = 1";
      // DEBUG
    $sql = "SELECT `id`, `id_sdm`, `nome`, `responsavel_id` FROM `servicos` WHERE `id_sdm` IS NOT NULL and `responsavel_id` IS NOT NULL";
    $query = $con->query($sql);

    //Query to Array
    while($rows[] = mysqli_fetch_assoc($query));
    array_pop($rows);  // pop the last row off, which is an empty row
    //echo "<pre>" . var_dump($rows) . "</pre>";

    return $rows;
  }

  function executeQuerySGS(){
    $con = connectToSGS();
    $query = $con->query($sql);
  }

  function makeSOAPConnection(){
    //Define params #################################################################
      $wsdl = "http://v320p053:8080/axis/services/USD_R11_WebService?wsdl";
      $username = "acesso_soap_rest_DIPT";
      $password = "%Eingang$#2016";
      //if Development than trace = 1 && exception = 1
        $trace = 0;
        $exception = 0;
      $args = array('trace' => $trace, 'exceptions' => $exception, 'encoding'=>'UTF-8');
      $auth = array('username' => $username,'password' => $password);

      try{
        # I - Creates an object of the service we will send a Request
          $client = new SoapClient($wsdl, $args);
          # I.1 Set the Header to use CA's envelope
            $header = new SOAPHeader('http://schemas.xmlsoap.org/soap/envelope', 'Auth', $auth);
            $client->__setSoapHeaders($header);
        # II - Call the method Login
          $session = $client->Login(array('username' => $username,'password' => $password));
        return array("cliente" => $client, "session" => $session->loginReturn);
      }
      catch (Exception $e){
         echo "Erro na Conexão com o SDM! <br />";
         echo $e -> getMessage ();
         echo 'Last response: '. $client->__getLastResponse();
         exit();
      }
  }



?>

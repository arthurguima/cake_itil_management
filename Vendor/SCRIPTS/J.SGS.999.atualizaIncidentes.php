<html>
<header>
</header>
<body>
  <pre>
    /*
      *  Resgata as RDMs cadastradas no SDM e as cadastra no SGS para uma
      *  melhor gestão do Servico.
      *  Versão: 08/08/2016
      *  Arthur Henrique Guimarães de Oliveira - 354996
    */
    <?php echo date("d/m/Y h:m",strtotime('now')); ?>
  </pre>
<?php
header("Content-type: text/html;charset=utf-8");

require_once 'common.php';

/* Cria incidentes */

/* Atualiza incidentes */
function getIncidentesSgs(){
  $con = connectToSGS();

  $sql = "SELECT `id`, `num_evento`, `ano`, `dt_inicio`,
  `dt_fim` FROM `indisponibilidades` WHERE `dt_inicio` <= NOW() AND `dt_fim`IS NULL;";
  $query = $con->query($sql);

  //Query to Array
  while($rows[] = mysqli_fetch_assoc($query));
  array_pop($rows);  // pop the last row off, which is an empty row
  //echo "<pre>" . //var_dump($rows) . "</pre>";

  return $rows;
}

function getIncidenteSDM($incidente){
  $objectType  = "in";
  $rdmsAttr = array(
                        'ref_num',          //Identificador
                        'open_date',
                        'close_date',
                        'affected_service',
                   );
  $con = makeSOAPConnection();

  $request = array( "sid" => $con['session'],
                    "objectType" => $objectType,
                    "whereClause" => "ref_num = '" . $incidente['num_evento'] ."/" . $incidente['ano'] . "'",
                    "maxRows" => 1,
                    "attributes" => array("string" => $rdmsAttr)
                  );
  $response = simplexml_load_string($con['cliente']->DoSelect($request)->doSelectReturn);
  $json = json_encode($response);
  $response = json_decode($json,TRUE);

  return $response;
}

function getSistemaIC($sistema){
  $objectType  = "nr";
  $rdmsAttr = array('name','zAmbiente.sym','asset_num');
  $con = makeSOAPConnection();

  $request = array( "sid" => $con['session'],
                    "objectType" => $objectType,
                    "whereClause" => "name like '" . $sistema['id_sdm']. "' ",
                    "maxRows" => 1,
                    "attributes" => array("string" => $rdmsAttr)
                  );
  $response = simplexml_load_string($con['cliente']->DoSelect($request)->doSelectReturn);
  $json = json_encode($response);
  $response = json_decode($json,TRUE);

  return $response;
}

function updateIncidenteSGS($incidente,$update){
  //var_dump($update);
  $sql = "";
  $hoje = strtotime('00:00:00');

  if( is_string ($update['close_date']))
    $sql = $sql . "UPDATE `DITE_SGD`.`indisponibilidades` SET `dt_fim`= '". date("Y-m-d h:i:s", $update['close_date']) ."' WHERE `num_evento` = '" . $incidente['num_evento'] . "' and `ano` = " . $incidente['ano'] . ";";

  if($sql != "")
    createIncidenteSGS($sql);
}

function createIncidenteSGS($sql){
  var_dump($sql);
  $con = connectToSGS();
  if ($query = $con->query($sql) === TRUE) {
    printf("Incidente Cadastrado/Atualizado;\n");
  }
  else{
    printf("<pre>Incidente não foi cadastrado/atualizado;\n");
    printf("Erro: %s\n</pre>", $con->error);
  }
  $con->close();
}

function getIncidentesSDMBydate(){
  $objectType  = "in";
  $hoje = strtotime('now');
  $x = strtotime('-5 day', $hoje);
  $ontem = strtotime('-170 day', $hoje);
  //$d = strtotime('2016/05/31');
  $maxRows = 250;
  $rdmsAttr = array(
                        'ref_num',          // Identificador
                        'affected_service',
                        'affected_resource',
                        'affected_service.system_name', // Servico Afetado
                        'open_date',        // Data de abertura
                        'close_date',       // Data de resolução
                        'symptom_code',  // Sintoma
                        'summary',  // Resumo
                        'description', // Descrição
                        'requested_by', // Solicitante
                   );

  $con = makeSOAPConnection();

  $request = array( "sid" => $con['session'],
                    "objectType" => $objectType,
                    "whereClause" => "open_date < ". $hoje . " and open_date > " . $x ,
                    "maxRows" => $maxRows,
                    "attributes" => array("string" => $rdmsAttr)
                  );
  $response = simplexml_load_string($con['cliente']->DoSelect($request)->doSelectReturn);
  $json = json_encode($response);
  $response = json_decode($json,TRUE);

  return $response;
}

function getIC($ic){
  $objectType  = "nr";
  $rdmsAttr = array( "name", "zAmbiente.sym");
  $con = makeSOAPConnection();

  $request = array( "sid" => $con['session'],
                    "objectType" => $objectType,
                    "whereClause" => "id = U'" . $ic . "'",
                    "maxRows" => 1,
                    "attributes" => array("string" => $rdmsAttr)
                  );
  $response = simplexml_load_string($con['cliente']->DoSelect($request)->doSelectReturn);
  $json = json_encode($response);
  $response = json_decode($json,TRUE);

  return $response['UDSObject']['Attributes']['Attribute'];
}

function IncidentesPorIC($in){
  $ics = [];
  foreach ($in['UDSObject'] as $i) {
    //$sistema = $i['Attributes']['Attribute'][1]['AttrValue'];
    if(!is_array($i['Attributes']['Attribute'][1]['AttrValue'])){
      if(!isset($ics[$i['Attributes']['Attribute'][1]['AttrValue']]))
        $ics[$i['Attributes']['Attribute'][1]['AttrValue']] = [];

      array_push($ics[$i['Attributes']['Attribute'][1]['AttrValue']], $i);
    }
  }

  foreach ($ics as $i => $key) {
    $ics[getIC($i)[0]['AttrValue']] = $ics[$i];
    unset($ics[$i]);
  }

  return $ics;
}

function IncidenteAmbienteETL($string){
  $arrayAmbiente =  array(array(12,'Homologação'),
                    array(11,'Produção'),
                    array(13,'Treinamento'),
                    array(14,'Sustentação'),
                    array(15,'Desenvolvimento'),
                    array(16,'Testes'));
  $ambiente = "";
  for ($i=0; $i < 6; $i++) {
    if (stripos($string, $arrayAmbiente[$i][1]) === 0) {
      $ambiente = $arrayAmbiente[$i][0];
      break;
    }
  }
  //echo "<h2>Ambiente</h2> " . $string ." -> " . $ambiente;
  //var_dump($string);
  return $ambiente;
}

//TODO: Passar a variável por referência não é recomendado
function getAmbientes(&$sistemas){
  $ambientes = [];

  foreach ($sistemas as &$incidentes) {
    foreach ($incidentes as &$in) {
      $in['Attributes']['Attribute'][10]['AttrName'] = 'motivo_id';

      if(!is_array($in['Attributes']['Attribute'][2]['AttrValue'])){
        $ic_ambiente = $in['Attributes']['Attribute'][2]['AttrValue'];
        if(!isset($ambientes[$ic_ambiente]))
          $ambientes[$ic_ambiente] = getIC($ic_ambiente)[1]['AttrValue'];

        if(is_array($ambientes[$ic_ambiente]))
          $in['Attributes']['Attribute'][10]['AttrValue'] = IncidenteAmbienteETL("Produção");
        else
          $in['Attributes']['Attribute'][10]['AttrValue'] = IncidenteAmbienteETL($ambientes[$ic_ambiente]);
      }else{
        $in['Attributes']['Attribute'][10]['AttrValue'] = IncidenteAmbienteETL("Produção");
      }
    }
  }

  return $sistemas;
}

function simpleIncidente($incidente){
  $in = Array();
  foreach ($incidente as $i) {
    $in[$i['AttrName']] = $i['AttrValue'];
  }

  list($num, $ano) = explode("/", $in['ref_num']);
  $in['num_evento'] =  $num;
  $in['ano'] =  $ano;
  unset($in['ref_num']);

  $in['cliente'] = $in['affected_service.system_name'];
  unset($in['affected_service.system_name']);

  $in['observacao'] =  $in['summary'];
  unset($in['summary']);

  $in['dt_inicio'] =  date("Y-m-d h:m:s", $in['open_date']);
  unset($in['open_date']);

  //var_dump($in);
  return $in;
}

function getSistemaSGS($sistema){

    $nome = "";
    $sql = "SELECT `id`, `id_sdm`, `responsavel_id` FROM `servicos` WHERE `nome` = '" . $sistema . "'";

    $con = connectToSGS();
    $query = $con->query($sql);
    while($rows[] = mysqli_fetch_assoc($query));
    array_pop($rows);

    if(sizeof($rows) > 0){
      $nome = $rows;
    }
    else{
      $nome = 0;
    }
    $con->close();
    //var_dump($nome);
    return $nome;
}

function CadastraIncidentes($sistemas){
    foreach ($sistemas as $key => $incidentes) {
      $nome_sistema = getSistemaSGS($key);
      if($nome_sistema){
        foreach ($incidentes as $in) {
          $i = simpleIncidente($in['Attributes']['Attribute']);

          $insert_in = "INSERT INTO `indisponibilidades` (`num_evento`, `ano`, `user_id`, `observacao`, `dt_inicio`, `motivo_id`) VALUES (" .
           " '"  . $i['num_evento'] . "',  '" . date("Y") . "', " . $nome_sistema[0]['responsavel_id'] . ", '" .
           $i['observacao'] . "',  '" . $i['dt_inicio'] . "',  " . $i['motivo_id'] ."); ";
          $insert_rel = "INSERT INTO `indisponibilidades_servicos`  (`servico_id`, `indisponibilidade_id`) VALUES (" . $nome_sistema[0]['id'] . ", (SELECT `id` FROM `indisponibilidades` WHERE `num_evento` = " . " '"  . $i['num_evento'] . "')); ";

          var_dump($insert_in);
          $con = connectToSGS();
          if ($query = $con->query($insert_in) === TRUE) {
            printf("Incidente Cadastrado;\n");
          }
          else{
            printf("<pre>Incidente não foi cadastrado;\n");
            printf("Erro: %s\n</pre>", $con->error);
          }
          $con->close();

          var_dump($insert_rel);
          $con = connectToSGS();
          if ($query = $con->query($insert_rel) === TRUE) {
            printf("Associação do Incidente Cadastrada;\n");
          }
          else{
            printf("<pre>Associação do Incidente não foi cadastrada;\n");
            printf("Erro: %s\n</pre>", $con->error);
          }
          $con->close();

        }
      }
    }
}

function main(){
  //$sistemas = getSistemasSgs();
  //$arrayTipoIncidente = getIncidenteTiposSgs();

  // Cadastra novos Incidentes
  $incidentes = getIncidentesSDMBydate();
  $incidentes = IncidentesPorIC($incidentes);
  $incidentes = getAmbientes($incidentes);
  //var_dump($incidentes);
  $incidentes = CadastraIncidentes($incidentes);


  // Atualiza incidentes cadastrados
  /*$incidentes = getIncidentesSgs();
  foreach ($incidentes as $i) {
    $update = getIncidenteSDM($i);
    //var_dump($update);
    updateIncidenteSGS($i, simpleIncidente($update['UDSObject']['Attributes']['Attribute']));
  }*/
}

main();
?>
</body>
</html>

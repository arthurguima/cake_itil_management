<html>
<header>
</header>
<body>
  <pre>
    /*
      *  Resgata as RDMs cadastradas no SDM e as cadastra no SGS para uma
      *  melhor gestão do Servico.
      *  Versão: 08/07/2016
      *  Arthur Henrique Guimarães de Oliveira - 354996
    */
  </pre>
<?php
header("Content-type: text/html;charset=utf-8");

require_once 'common.php';
//require_once 'dic\tr_rdms.php';

function getRdmTiposSgs(){
  $con = connectToSGS();
  //Select SGS Systems
  $sql = "SELECT `id`, `nome` FROM `rdm_tipos`";
  $query = $con->query($sql);

  //Query to Array
  while($rows[] = mysqli_fetch_assoc($query));
  array_pop($rows);  // pop the last row off, which is an empty row
  //echo "<pre>" . //var_dump($rows) . "</pre>";

  return $rows;
}

function getRdmsSgs(){
  $con = connectToSGS();
  $hoje = strtotime('00:00:00');

  $sql = "SELECT `id`, `numero`, `ano`, `cab_approval`, `dt_prevista` FROM rdms WHERE sucesso = -1 AND cab_approval= 0 AND dt_prevista <= " . $hoje;
  $query = $con->query($sql);

  //Query to Array
  while($rows[] = mysqli_fetch_assoc($query));
  array_pop($rows);  // pop the last row off, which is an empty row
  //echo "<pre>" . //var_dump($rows) . "</pre>";

  return $rows;
}

function rdmAmbienteETL($string){
  $arrayAmbiente =  array(array(1,'HOMOLOGAÇÃO'),
                    array(2,'PRODUÇÃO'),
                    array(3,'TREINAMENTO'),
                    array(4,'SUSTENTAÇÃO'),
                    array(5,'DESENVOLVIMENTO'),
                    array(6,'TESTES'));
  $ambiente = "";
  for ($i=0; $i < 6; $i++) {
    if (stripos($string, $arrayAmbiente[$i][1])) {
      $ambiente = $arrayAmbiente[$i][0];
      break;
    }
  }
  return $ambiente;
}

function rdmTipoETL($tipo,$arrayTipoRDM){
  $codTipoRDM = "";

  foreach ($arrayTipoRDM as $t) {
    if (strpos($tipo,$t['nome'])) {
      $codTipoRDM = $t['id'];
      return $codTipoRDM;
    }
  }
  return "NULL";
}

/*Não estou utilizando*/
function rdmSucessoETL($string){
  $arraySucesso =  array(array(0,'NÃO'),
                    array(1,'Sim'),
                    array(2,'Cancelada'),
                    array(NULL,''));
  $sucesso = "";
  for ($i=0; $i < 4; $i++) {
    if (strpos($string, $arraySucesso[$i][1])) {
      $sucesso = $arraySucesso[$i][0];
      break;
    }
  }
  return $sucesso;
}

function rdmETL($RDM,$arrayTipoRDM){
  $rdm = $RDM;
  //Datas
  $rdm['need_by'] = date("d-m-Y",$rdm['need_by']);

  if(isset($rdm['open_date']))
    $rdm['open_date'] = date("d-m-Y",$rdm['open_date']);

  if(isset($rdm['sched_start_date']))
    if($rdm['sched_start_date'] != false)
      $rdm['sched_start_date'] = date("Y-m-d", $rdm['sched_start_date']);

  if($arrayTipoRDM != null){
    //Categoria
    $rdm['tipo'] = rdmTipoETL($rdm['category.sym'],$arrayTipoRDM);
    //Ambiente
    $rdm['ambiente'] = rdmAmbienteETL($rdm['category.sym']);
  }

  return $rdm;
}

function createSGSSql($RDM, $sistema, $arrayTipoRDM){

  $rdm = rdmETL($RDM,$arrayTipoRDM);

  return "INSERT INTO `rdms` (`id`, `nome`, `observacao`,
    `numero`, `ano`, `dt_prevista`, `dt_executada`, `versao`, `user_id`,
     `solicitante`, `ambiente`, `sucesso`, `autorizada`,
    `farm`, `rdm_tipo_id`, `servico_id`, `created`, `modified`,`cab_approval`)

     VALUES (NULL, '". addslashes($rdm['summary']) ."', '". addslashes($rdm['description'])."',
     ".$rdm['chg_ref_num'].", ".date("Y",strtotime($rdm['open_date'])).", '".date("Y-m-d",strtotime($rdm['need_by']))."', NULL, NULL, ".$sistema['responsavel_id'].",
     '".$rdm['requestor.last_name']."', ".$rdm['ambiente'].", -1, 0,
     0, ".$rdm['tipo'].", ".$sistema['id'].", '".date("Y-m-d",strtotime($rdm['open_date']))."', NULL, " . $rdm['cab_approval'] ."); ";
}

function createRdmSGS($sql){
  var_dump($sql);
  $con = connectToSGS();
  if ($query = $con->query($sql) === TRUE) {
    printf("RDM Cadastrada/Atualizada;\n");
  }
  else{
    printf("<pre>RDM não foi cadastrada/atualizada;\n");
    printf("Erro: %s\n</pre>", $con->error);
  }
  $con->close();
}

function updateRdmSGS($rdm,$update){
  //var_dump($update);
  $update = rdmETL($update, null);
  $sql = "";
  $hoje = strtotime('00:00:00');

  if($rdm['cab_approval'] == '0' &&  $update['status.sym'] == 'Aprovada pelo CAB')
    $sql = $sql . "UPDATE `DITE_SGD`.`rdms` SET `cab_approval`= 1 WHERE `numero` = '" . $rdm['numero'] . "' and `ano` = " . $rdm['ano'] . ";";

  if($sql != ""){
    createRdmSGS($sql);
    $sql = "";
  }

  if($update['sched_start_date'] != false)
    if($rdm['dt_prevista'] != $update['sched_start_date'])
      $sql = " UPDATE `DITE_SGD`.`rdms` SET `dt_prevista` = '" . $update['sched_start_date'] ."'  WHERE `numero` = '" . $rdm['numero'] . "' and `ano` = " . $rdm['ano'] . ";";

  if($sql != "")
    createRdmSGS($sql);
//  if(strtotime("Y-m-d",$rdm['dt_prevista']) != strtotime("Y-m-d",$update['sched_start_date']))
//  $sql = $sql . " UPDATE `DITE_SGD`.`rdms` SET `dt_prevista`= " . strtotime("Y-m-d", $update['sched_start_date']) . " WHERE `numero` = '" . $rdm['numero'] . "' and `ano` = " . $rdm['ano'] . ";";
}

function getRdmSDM($rdm){
  $objectType  = "chg";
  $rdmsAttr = array(
                        'chg_ref_num',          //Identificador
                        //'close_date',  //Data De Fechamento
                        'sched_start_date', //Data de início
                        'status.sym', //Status - Implementada COM sucesso / Aprovada pelo CAB etc
                        'cab_approval',      //Aprovada pelo CAB - 0 ou 1
                        'sched_start_date',
                        'need_by',
                   );
  $con = makeSOAPConnection();

  $request = array( "sid" => $con['session'],
                    "objectType" => $objectType,
                    "whereClause" => "chg_ref_num = '" . $rdm['numero'] ."'",
                    "maxRows" => 1,
                    "attributes" => array("string" => $rdmsAttr)
                  );
  $response = simplexml_load_string($con['cliente']->DoSelect($request)->doSelectReturn);
  $json = json_encode($response);
  $response = json_decode($json,TRUE);

  return $response;
}

function getRdmsSDM($sistema){
  $objectType  = "chg";
  $hoje = strtotime('00:00:00');
  $ontem = strtotime('-1 day', $hoje);
  //$d = strtotime('2016/05/31');
  $maxRows = 250;
  $rdmsAttr = array(
                        'chg_ref_num',          //Identificador
                        'summary',              //Título
                        'requestor.last_name',  //Solicitante
                        'project.name',         //Sistema
                        'project.system_name',  //Cliente
                        'category.sym',         //Categoria da Mudança
                        'chgtype',     //Tipo da RDM (emergencial(300),normal(200),padrão(100))
                        'need_by',     //Data Prevista (Solicitante)
                        'close_date',  //Data De Fechamento
                        'description', //Descrição da requisição
                        'status.sym', //Status - Implementada COM sucesso / Aprovada pelo CAB etc
                        'project.resource_contact.last_name', //Gestor do Sistema
                        'cab_approval',      //Aprovada pelo CAB - 0 ou 1
                        'sched_start_date',  //Data Agendada
                        'open_date',         //Data de Abertura
                      );

  $con = makeSOAPConnection();

  $request = array( "sid" => $con['session'],
                    "objectType" => $objectType,
                    "whereClause" => "open_date >= ".$ontem . " and project.name = '" . $sistema['id_sdm']."' ",
                    "maxRows" => $maxRows,
                    "attributes" => array("string" => $rdmsAttr)
                  );
  $response = simplexml_load_string($con['cliente']->DoSelect($request)->doSelectReturn);
  $json = json_encode($response);
  $response = json_decode($json,TRUE);

  return $response;
}

function simpleRDM($RDM){
  $rdm = Array();
  foreach ($RDM as $r) {
    $rdm[$r['AttrName']] = $r['AttrValue'];
  }
  return $rdm;
}

function main(){
  $sistemas = getSistemasSgs();
  $arrayTipoRDM = getRdmTiposSgs();

  foreach ($sistemas as $s) {
      $rdms = getRdmsSDM($s);
      if($rdms != NULL){
        if(array_key_exists('Handle',$rdms['UDSObject'])){ //Quando retorna apenas uma rdm
          $r = simpleRDM($rdms['UDSObject']['Attributes']['Attribute']);
          createRdmSGS(createSGSSql($r, $s,$arrayTipoRDM));
        }
        else{
          foreach ($rdms['UDSObject'] as $r) {
            $r = simpleRDM($r['Attributes']['Attribute']);
            createRdmSGS(createSGSSql($r, $s,$arrayTipoRDM));
          }
        }
      }
  }

  $rdms = getRdmsSgs();
  //var_dump($rdms);
  foreach ($rdms as $r) {
    $update = getRdmSDM($r);
    if(sizeof($update))
      updateRdmSGS($r, simpleRDM($update['UDSObject']['Attributes']['Attribute']));
  }
}

main();

?>
</body>
</html>

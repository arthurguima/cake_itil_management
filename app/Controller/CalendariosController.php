<?php class CalendariosController extends AppController {
    public $helpers = array('Html', 'Form', 'Times', 'Rdm');

    public function show($id = null){
      $this->set("id", $id);
      $this->set('servicos', $this->servicos());
      $this->set('clientes', $this->clientes());
    }

    /*
     * Recebe uma id que identifica quais dados serão utilizados
     * para montar o calendário. Pode também receber valores multiplos dos ids.
     * Valores multiplos indicam que mais de 1 item pode ser mostrado
     * RDMS: 2
     * SSES: 3
     * PES: 5
     * ORDS: 7
     * DEMANDAS: 11
    */
    public function json($id = null){
      $this->layout = "ajax";
      $data = array();

      if($id == 2310){
        $data = array_merge(
          $this->rdms($this->params),
          $this->sses($this->params),
          $this->pes($this->params),
          $this->ords($this->params),
          $this->demandas($this->params)
        );
      }
      else{
        if($id % 2 == 0)
          $data = array_merge($data,$this->rdms($this->params));
        if($id % 3 == 0)
          $data = array_merge($data,$this->sses($this->params));
        if($id % 5 == 0)
          $data = array_merge($data,$this->pes($this->params));
        if($id % 7 == 0)
          $data = array_merge($data,$this->ords($this->params));
        if($id % 11 == 0)
          $data = array_merge($data,$this->demandas($this->params));
        if($id % 13 == 0) // não aparece no padrão (2310)
          $data = array_merge($data,$this->indisponibilidades($this->params));
        if($id % 17 == 0)
          $data = array_merge($data,$this->subtarefas($this->params));
        if($id % 23 == 0)
          $data = array_merge($data,$this->chamados($this->params));
      }

      $this->set("json", json_encode($data));
  }

  private function servicos(){
    $this->loadModel('Servico');
    $this->Servico->Behaviors->load('Containable');
    $servicos = $this->Servico->find('list', array(
      'contain' => array('Cliente' => array()),
      'conditions' => array("Cliente.id" . $_SESSION['User']['clientes']),
      'fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia')
    ));
    return $servicos;
  }

  private function clientes(){
    $this->loadModel('Cliente');
    $this->Cliente->Behaviors->load('Containable');
    $clientes = $this->Cliente->find('list', array(
      'conditions' => array("Cliente.id" . $_SESSION['User']['clientes']),
      'fields' => array('Cliente.id', 'Cliente.sigla')
    ));
    return $clientes;
  }

  private function rdms($params){
    $p_servico = "";

    if(isset($params['url']['servico']) && $params['url']['servico'] != '')
      $p_servico = "Servico.id = " . $params['url']['servico'] . " && ";

    if(isset($params['url']['ambiente']) && $params['url']['ambiente'] != '')
      $p_servico = $p_servico . "Rdm.ambiente = " . $params['url']['ambiente'] . " && ";

    if(isset($params['url']['cliente']) && $params['url']['cliente'] != '')
      $p_servico = $p_servico . "Servico.cliente_id = " . $params['url']['cliente'] . " && ";

    $this->loadModel('Rdm');
    $this->Rdm->Behaviors->load('Containable');
    $this->Rdm->contain('Servico');
    $rdms = $this->Rdm->find('all', array('conditions'=>
              array($p_servico . "Servico.cliente_id" . $_SESSION['User']['clientes'] . '&& Rdm.dt_prevista >= "' . $params['url']['start'] . '" && Rdm.dt_prevista <= "' . $params['url']['end'] . '"')));
    //debug($rdms);

    $data = array();
    foreach($rdms as $rdm) {
      if($rdm['Rdm']['sucesso'] == 2){
        //$title = "RDM - Cancelada - " .  $rdm['Rdm']['numero'] . " - " .   $rdm['Rdm']['nome'];
        $class = 'calendar-rdm-cancelada';
      }
      else{
        //$title = "RDM " .  $rdm['Rdm']['numero'] . " - " .   $rdm['Rdm']['nome'];
        $class = 'calendar-rdm';
      }
      $data[] = array(
          'id' => $rdm['Rdm']['id'],
          'title'=> $rdm['Rdm']['numero'] . " - " .   $rdm['Rdm']['nome'], //$title,
          'start'=> date("Y-m-d", strtotime(str_replace('/', '-', $rdm['Rdm']['dt_prevista']))),
          'allDay' => true,
          'url' => Router::url('/') . 'rdms/view/'.$rdm['Rdm']['id'],
          'description' =>  "<span class='sistema-calendario'>" . $rdm['Servico']['sigla'] . " " . $rdm['Rdm']['versao'] . "</span> "  .
           $this->sucesso($rdm['Rdm']['sucesso'], $rdm['Rdm']['dt_executada'])
           . $this->getAmbiente($rdm['Rdm']['ambiente']),
          'className' => $class
      );
    }
    return $data;
  }


  private function chamados($params){
    $p_servico = "";

    if(isset($params['url']['servico']) && $params['url']['servico'] != '')
      $p_servico = "Servico.id = " . $params['url']['servico'] . " && ";

    if(isset($params['url']['cliente']) && $params['url']['cliente'] != '')
      $p_servico = $p_servico . "Servico.cliente_id = " . $params['url']['cliente'] . " && ";

    $this->loadModel('Chamado');
    $this->Chamado->Behaviors->load('Containable');
    $this->Chamado->contain("Status", "Servico", "User");
    $chamados = $this->Chamado->find('all', array('conditions'=>
              array($p_servico . "Servico.cliente_id" . $_SESSION['User']['clientes'] . '&& Chamado.dt_prev_resolv >= "' . $params['url']['start'] . '" && Chamado.dt_prev_resolv <= "' . $params['url']['end'] . '"')));
    //debug($rdms);

    $data = array();
    foreach($chamados as $ch) {
      $data[] = array(
          'id' => $ch['Chamado']['id'],
          'title'=> $ch['Chamado']['nome'], //$title,
          'start'=> date("Y-m-d", strtotime(str_replace('/', '-', $ch['Chamado']['dt_prev_resolv']))),
          'allDay' => true,
          'url' => Router::url('/') . 'chamados/view/'.$ch['Chamado']['id'],
          'description' => $ch['Chamado']['numero'] . " - <span class='sistema-calendario'>" .$ch['Servico']['sigla'] . "</span> " . $this->yesOrNo($ch['Chamado']['aberto']),
          'className' => "calendar-ss"
      );
    }
    return $data;
  }

  private function yesOrNo($bol, $class="") {
      if ($bol):
        return "<span class='label label-success' id='" . $class . "'>Aberto</span>";
      else:
        return "<span class='label label-default' id='" . $class . "'>Fechado</span>";
      endif;
  }

  /*
  * Destaca se a RDM foi concluida ou cancelada
  */
  private function sucesso($bol, $dt_executada, $class="") {
    if($bol == null){
        return " ";
    }

    switch ($bol) {
    case 0:
        return "<span class='label label-default' id='" . $class . "'>Sem Sucesso</span>";
    case 1:
      if($dt_executada != null)
        return "<span class='label label-success' id='" . $class . "'>Sucesso</span>";
      else
        return "";
    case 2:
      return "<span class='label label-danger' id='" . $class . "'>Cancelada</span>";
    default:
      return " ";
    }
  }

  private function indisAberta($dt_fim) {
    if($dt_fim != null)
        return " ";
    else
      return "<span class='label label-default'>Aberto</span>";
  }

  private function getAmbiente($value){
    switch ($value):
      case 1: return "<span class='label label-warning'>Homologação</span>";
      case 2: return "<span class='label label-info'>Produção</span>";
      case 3: return "<span class='label label-primary'>Treinamento</span>";
      case 4: return "<span class='label label-success'>Sustentação</span>";
    endswitch;
    return "<span class='label label-warning'>Homologação</span>";
  }

  private function sses($params){
    if(isset($params['url']['servico']) && $params['url']['servico'] != '')
      $p_servico = "Servico.id = " . $params['url']['servico'] . " && ";
    else
      $p_servico = "";

    $this->loadModel('Ss');
    $this->Ss->Behaviors->load('Containable');
    $this->Ss->contain('Servico');
    $sses = $this->Ss->find('all', array('conditions'=>
              array($p_servico . "Servico.cliente_id" . $_SESSION['User']['clientes'] . '&& Ss.dt_prazo >= "' . $params['url']['start'] . '" && Ss.dt_prazo <= "' . $params['url']['end'] . '"')));

    $data = array();
    foreach($sses as $ss) {
      $data[] = array(
          'id' => $ss['Ss']['id'],
          'title'=> "SS - " .  $ss['Ss']['numero'] . "/" . $ss['Ss']['ano'],
          'start'=> date("Y-m-d", strtotime(str_replace('/', '-', $ss['Ss']['dt_prazo']))),
        //'end' => $demanda['Demanda']['dt_prevista'],
          'allDay' => true,
          'url' => Router::url('/') . 'sses/view/'.$ss['Ss']['id'],
          'description' => $ss['Servico']['sigla'],
          'className' => 'calendar-ss'
      );
    }
    return $data;
  }

  private function pes($params){
    if(isset($params['url']['servico']) && $params['url']['servico'] != '')
      $p_servico = "Servico.id = " . $params['url']['servico'] . " && ";
    else
      $p_servico = "";

    $this->loadModel('Pe');
    $this->Pe->Behaviors->load('Containable');
    $this->Pe->contain('Servico');
    $pes = $this->Pe->find('all', array('conditions'=>
            array($p_servico . "Servico.cliente_id" . $_SESSION['User']['clientes'] . '&& (Pe.validade_pdd >= "' . $params['url']['start'] . '") && (Pe.validade_pdd <= "' . $params['url']['end'] .'") ')));

    $data = array();
    foreach($pes as $pe) {
      $data[] = array(
          'id' => $pe['Pe']['id'],
          'title'=> "PA " .  $pe['Pe']['numero'] . "/" . $pe['Pe']['ano'] . " - Validade PDD ",
          'start'=> date("Y-m-d", strtotime(str_replace('/', '-', $pe['Pe']['validade_pdd']))),
          'allDay' => true,
          'url' => Router::url('/') . 'pes/view/'.$pe['Pe']['id'],
          'description' => $pe['Servico']['sigla'],
          'className' => 'calendar-pa'
      );
    }

    return $data;
  }

  private function ords($params){
    if(isset($params['url']['servico']) && $params['url']['servico'] != '')
      $p_servico = "Servico.id = " . $params['url']['servico'] . " && ";
    else
      $p_servico = "";

    $this->loadModel('Ord');
    $this->Ord->Behaviors->load('Containable');
    $this->Ord->contain('Ss', 'Servico');
    $ords = $this->Ord->find('all', array('conditions'=>
              array($p_servico . "Servico.cliente_id" . $_SESSION['User']['clientes'] . '&& Ord.dt_fim_pdd >= "' . $params['url']['start'] . '" && Ord.dt_fim_pdd <= "' . $params['url']['end'] . '"')));

    $data = array();
    foreach($ords as $ord) {
      $data[] = array(
          'id' => $ord['Ord']['id'],
          'title'=> "OS " .  $ord['Ord']['numero'] . "/" . $ord['Ord']['ano'],
          'start'=> date("Y-m-d", strtotime(str_replace('/', '-', $ord['Ord']['dt_fim_pdd']))),
          'allDay' => true,
          'url' => Router::url('/') . 'ords/view/'.$ord['Ord']['id'],
          'description' => $ord['Servico']['sigla'] . "- SS: " . $ord['Ss']['numero'] . "/" . $ord['Ss']['ano'],
          'className' => 'calendar-os'
      );
    }
    return $data;
  }

  private function demandas($params){
    $p_servico = "";

    if(isset($params['url']['servico']) && $params['url']['servico'] != '')
      $p_servico = "Servico.id = " . $params['url']['servico'] . " && ";

    if(isset($params['url']['cliente']) && $params['url']['cliente'] != '')
      $p_servico = $p_servico . "Servico.cliente_id = " . $params['url']['cliente'] . " && ";


    $this->loadModel('Demanda');
    $this->Demanda->Behaviors->load('Containable');
    $this->Demanda->contain('DemandaTipo', 'Servico');
    $demandas = $this->Demanda->find('all', array('conditions'=>
                  array($p_servico . "Servico.cliente_id" . $_SESSION['User']['clientes'] . '&& Demanda.dt_prevista >= "' . $params['url']['start'] . '" && Demanda.dt_prevista <= "' . $params['url']['end'] .'"')));

    $data = array();
    foreach($demandas as $demanda) {
      $data[] = array(
          'id' => $demanda['Demanda']['id'],
          'title'=> $demanda['Demanda']['clarity_dm_id'] . " - " . $demanda['Demanda']['nome'],
          'start'=> date("Y-m-d", strtotime(str_replace('/', '-', $demanda['Demanda']['dt_prevista']))),
        //  'end' => $demanda['Demanda']['dt_prevista'],
          'allDay' => true,
          'url' => Router::url('/') . 'demandas/view/'.$demanda['Demanda']['id'],
          'description' => "<span class='sistema-calendario'>" . $demanda['Servico']['sigla'] . "</span> - " . $demanda['DemandaTipo']['nome'],
          'className' => 'calendar-demanda'
      );
    }
    return $data;
  }

  private function subtarefas($params){
    $p_servico = "";

    if(isset($params['url']['servico']) && $params['url']['servico'] != '')
      $p_servico = "Servico.id = " . $params['url']['servico'] . " && ";

    if(isset($params['url']['cliente']) && $params['url']['cliente'] != '')
      $p_servico = $p_servico . "Servico.cliente_id = " . $params['url']['cliente'] . " && ";

    $this->loadModel('Subtarefa');
    $this->Subtarefa->Behaviors->load('Containable');
    $subtarefas = $this->Subtarefa->find('all', array(
      'contain' => array(
				'Servico' => array(),
				'Demanda' => array(),
				'Rdm' => array(),
				'Chamado' => array(),
				'Release' => array()
			),
      'conditions'=>
         array($p_servico . 'Subtarefa.user_id = ' . $this->Session->read('User.uid') . '&& Subtarefa.dt_prevista >= "' . $params['url']['start'] . '" && Subtarefa.dt_prevista <= "' . $params['url']['end'] .'"'))
		);
		$this->set('subtarefas', $subtarefas);

    $data = array();
    foreach($subtarefas as $sub) {
      $id = "";
      $url = "#";
      if(isset($sub['Demanda']['clarity_dm_id'])){
        $id = " - " . $sub['Demanda']['clarity_dm_id'];
        $url = Router::url('/') . 'demandas/view/'. $sub['Demanda']['id'];
      }
      elseif(isset($sub['Chamado']['numero'])){
        $id = " - Chamado: " . $sub['Chamado']['numero'] . "/" . $sub['Chamado']['ano'];
        $url = Router::url('/') . 'chamados/view/'. $sub['Chamado']['id'];
      }
      elseif(isset($sub['Rdm']['numero'])){
        $id = " - RDM: " . $sub['Rdm']['numero'] . "/" . $sub['Rdm']['ano'];
        $url = Router::url('/') . 'rdms/view/'. $sub['Rdm']['id'];
      }
      elseif(isset($sub['Release']['id'])){
        $id = " - Release: " . $sub['Release']['versao'];
        $url = Router::url('/') . 'releases/view/'. $sub['Release']['id'];
      }

      $data[] = array(
          'id' => $sub['Subtarefa']['id'],
          'title'=>  $sub['Subtarefa']['descricao'],
          'start'=> date("Y-m-d", strtotime(str_replace('/', '-', $sub['Subtarefa']['dt_prevista']))),
        //  'end' => $demanda['Demanda']['dt_prevista'],
          'allDay' => true,
          'url' => $url,
          'description' => "<span class='sistema-calendario'>" . $sub['Servico']['sigla'] . "</span> " . $id . " " . $this->subtarefaFinalizada($sub['Subtarefa']['check']),
          'className' => 'calendar-os'
      );
    }
    return $data;
  }

  private function subtarefaFinalizada($check){
    if($check == 0)
      return "<span class='label label-success'>Em andamento</span>";
    elseif($check == 2)
      return "<span class='label label-info'>Aguardando Início</span>";
    else
      return "<span class='label label-default'>Finalizada</span>";
  }

  private function indisponibilidades($params){
    $p_servico = "";

    if(isset($params['url']['servico']) && $params['url']['servico'] != '')
      $p_servico = "IndisponibilidadesServico.servico_id = " . $params['url']['servico'] . " && ";

    if(isset($params['url']['ambiente']) && $params['url']['ambiente'] != '')
      $p_servico = $p_servico . "Motivo.ambiente = " . $params['url']['ambiente'] . " && ";


    $this->loadModel('Indisponibilidade');
    $this->Indisponibilidade->Behaviors->load('Containable');
    $this->Indisponibilidade->bindModel(array('hasOne' => array('IndisponibilidadesServico')), false);
    $this->Indisponibilidade->contain('Motivo', 'Servico', 'IndisponibilidadesServico');

    $indisponibilidades = $this->Indisponibilidade->find('all', array(
      'conditions'=>
                  array($p_servico . 'Indisponibilidade.dt_inicio >= "' . $params['url']['start'] . '" && Indisponibilidade.dt_inicio <= "' . $params['url']['end'] .'"'),
    ));

    $data = array();
    foreach($indisponibilidades as $indisponibilidade) {
      $servicos = "";
      foreach($indisponibilidade['Servico'] as $servico):
        $servicos = $servicos . $servico['sigla'] . ";  ";
      endforeach;

      if($indisponibilidade['Indisponibilidade']['dt_fim'] == null){
        $fim = date("Y-m-d H:i:s");
        $servicos =  $this->indisAberta($indisponibilidade['Indisponibilidade']['dt_fim']) . " " . $servicos;
      }
      else{
        $fim = null;
      }

      $data[] = array(
          'id' => $indisponibilidade['Indisponibilidade']['id'],
          'title'=> " - nº " . $indisponibilidade['Indisponibilidade']['num_evento'] . " - " . $indisponibilidade['Motivo']['nome'],
          'start'=> $indisponibilidade['Indisponibilidade']['dt_inicio'],
          'end' => $fim,
          'allDay' => false,
          'url' => Router::url('/') . 'indisponibilidades/view/'. $indisponibilidade['Indisponibilidade']['id'],
          'description' => $this->getAmbiente($indisponibilidade['Motivo']['ambiente']) ." " . $servicos,
          'className' => 'calendar-indis'
      );
    }
    return $data;
  }
}
?>

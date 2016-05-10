<?php class CalendariosController extends AppController {
    public $helpers = array('Html', 'Form', 'Times', 'Rdm');

    public function show($id = null){

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
      }

      $this->set("json", json_encode($data));
  }

  private function rdms($params){
    $this->loadModel('Rdm');
    $this->Rdm->Behaviors->load('Containable');
    $this->Rdm->contain('Servico');
    $rdms = $this->Rdm->find('all', array('conditions'=>
              array("Servico.cliente_id" . $_SESSION['User']['clientes'] . '&& Rdm.dt_prevista >= "' . $params['url']['start'] . '" && Rdm.dt_prevista <= "' . $params['url']['end'] . '"')));
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
          'title'=> "RDM " .  $rdm['Rdm']['numero'] . " - " .   $rdm['Rdm']['nome'], //$title,
          'start'=> date("Y-m-d", strtotime(str_replace('/', '-', $rdm['Rdm']['dt_prevista']))),
          'allDay' => true,
          'url' => Router::url('/') . 'rdms/view/'.$rdm['Rdm']['id'],
          'description' =>  $this->sucesso($rdm['Rdm']['sucesso'], $rdm['Rdm']['dt_executada'])
                           . " " . $rdm['Servico']['sigla'] . " " . $rdm['Rdm']['versao'] . " "  . $this->getAmbiente($rdm['Rdm']['ambiente']),
          'className' => $class
      );
    }
    return $data;
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
    $this->loadModel('Ss');
    $this->Ss->Behaviors->load('Containable');
    $this->Ss->contain('Servico');
    $sses = $this->Ss->find('all', array('conditions'=>
              array("Servico.cliente_id" . $_SESSION['User']['clientes'] . '&& Ss.dt_prazo >= "' . $params['url']['start'] . '" && Ss.dt_prazo <= "' . $params['url']['end'] . '"')));

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
    $this->loadModel('Pe');
    $this->Pe->Behaviors->load('Containable');
    $this->Pe->contain('Servico');
    $pes = $this->Pe->find('all', array('conditions'=>
            array("Servico.cliente_id" . $_SESSION['User']['clientes'] . '&& (Pe.validade_pdd >= "' . $params['url']['start'] . '") && (Pe.validade_pdd <= "' . $params['url']['end'] .'") ')));

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
    $this->loadModel('Ord');
    $this->Ord->Behaviors->load('Containable');
    $this->Ord->contain('Ss', 'Servico');
    $ords = $this->Ord->find('all', array('conditions'=>
              array("Servico.cliente_id" . $_SESSION['User']['clientes'] . '&& Ord.dt_fim_pdd >= "' . $params['url']['start'] . '" && Ord.dt_fim_pdd <= "' . $params['url']['end'] . '"')));

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
    $this->loadModel('Demanda');
    $this->Demanda->Behaviors->load('Containable');
    $this->Demanda->contain('DemandaTipo', 'Servico');
    $demandas = $this->Demanda->find('all', array('conditions'=>
                  array("Servico.cliente_id" . $_SESSION['User']['clientes'] . '&& Demanda.dt_prevista >= "' . $params['url']['start'] . '" && Demanda.dt_prevista <= "' . $params['url']['end'] .'"')));

    $data = array();
    foreach($demandas as $demanda) {
      $data[] = array(
          'id' => $demanda['Demanda']['id'],
          'title'=> "DI - "  . $demanda['Demanda']['nome'],
          'start'=> date("Y-m-d", strtotime(str_replace('/', '-', $demanda['Demanda']['dt_prevista']))),
        //  'end' => $demanda['Demanda']['dt_prevista'],
          'allDay' => true,
          'url' => Router::url('/') . 'demandas/view/'.$demanda['Demanda']['id'],
          'description' => $demanda['Servico']['sigla'] . " - " . $demanda['DemandaTipo']['nome'],
          'className' => 'calendar-demanda'
      );
    }
    return $data;
  }

  private function indisponibilidades($params){
    $this->loadModel('Indisponibilidade');
    $this->Indisponibilidade->Behaviors->load('Containable');
    $this->Indisponibilidade->contain('Motivo', 'Servico');
    $indisponibilidades = $this->Indisponibilidade->find('all', array('conditions'=>
                  array('Indisponibilidade.dt_inicio >= "' . $params['url']['start'] . '" && Indisponibilidade.dt_fim <= "' . $params['url']['end'] .'"')));

    $data = array();
    foreach($indisponibilidades as $indisponibilidade) {
      $servicos = "";
      foreach($indisponibilidade['Servico'] as $servico):
        $servicos = $servicos . $servico['sigla'] . ";  ";
      endforeach;

      $data[] = array(
          'id' => $indisponibilidade['Indisponibilidade']['id'],
          'title'=> $indisponibilidade['Motivo']['nome'],
          'start'=> $indisponibilidade['Indisponibilidade']['dt_inicio'],
          'end' => $indisponibilidade['Indisponibilidade']['dt_fim'],
          'allDay' => false,
          'url' => Router::url('/') . 'indisponibilidades/view/'. $indisponibilidade['Indisponibilidade']['id'],
          'description' => $servicos,
          'className' => 'calendar-indis'
      );
    }
    return $data;
  }
}
?>

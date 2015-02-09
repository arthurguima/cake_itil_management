<?php class CalendariosController extends AppController {
    public $helpers = array('Html', 'Form', 'Times', 'Rdm');

    public function show(){

    }

    public function json(){
      $this->layout = "ajax";

      /* PE */
      $this->loadModel('Pe');
      $this->Pe->Behaviors->load('Containable');
      $this->Pe->contain('Servico');
      $pes = $this->Pe->find('all', array('conditions'=>array('Pe.validade_pdd !=' => null)));

      foreach($pes as $pe) {
        $data[] = array(
            'id' => $pe['Pe']['id'],
            'title'=> "PA " .  $pe['Pe']['numero'] . "/" . $pe['Pe']['ano'] . "; Validade PDD ",
            'start'=> date("Y-m-d", strtotime(str_replace('/', '-', $pe['Pe']['validade_pdd']))),
            'allDay' => true,
            'url' => Router::url('/') . 'pes/view/'.$pe['Pe']['id'],
            'description' => $pe['Servico']['sigla'],
            'className' => 'calendar-pa'
        );
      }

      /* ORD */
      $this->loadModel('Ord');
      $this->Ord->Behaviors->load('Containable');
      $this->Ord->contain('Ss', 'Servico');
      $ords = $this->Ord->find('all', array('conditions'=>array('Ord.dt_fim_pdd !=' => null)));

      foreach($ords as $ord) {
        $data[] = array(
            'id' => $ord['Ord']['id'],
            'title'=> "OS " .  $ord['Ord']['numero'] . "/" . $ord['Ord']['ano'] . "; SS - " . $ord['Ss']['numero'] . "/" . $ord['Ss']['ano'],
            'start'=> date("Y-m-d", strtotime(str_replace('/', '-', $ord['Ord']['dt_fim_pdd']))),
            'allDay' => true,
            'url' => Router::url('/') . 'ords/view/'.$ord['Ord']['id'],
            'description' => $ord['Servico']['sigla'],
            'className' => 'calendar-os'
        );
      }

      /* RDM */
      $this->loadModel('Rdm');
      $this->Rdm->Behaviors->load('Containable');
      $this->Rdm->contain('Servico');
      $rdms = $this->Rdm->find('all', array('conditions'=>array('Rdm.dt_prevista !=' => null)));

      foreach($rdms as $rdm) {
        $data[] = array(
            'id' => $rdm['Rdm']['id'],
            'title'=> "RDM - " .  $rdm['Rdm']['nome'],
            'start'=> date("Y-m-d", strtotime(str_replace('/', '-', $rdm['Rdm']['dt_prevista']))),
            'allDay' => true,
            'url' => Router::url('/') . 'rdms/view/'.$rdm['Rdm']['id'],
            'description' => $rdm['Servico']['sigla'] . " " . $rdm['Rdm']['versao'] . ($rdm['Rdm']['versao'] == 1 ? ' Homologação' : ' Produção'),
            'className' => 'calendar-rdm'
        );
      }

      /* SS */
      $this->loadModel('Ss');
      $this->Ss->Behaviors->load('Containable');
      $this->Ss->contain('Servico');
      $sses = $this->Ss->find('all', array('conditions'=>array('Ss.dt_prazo !=' => null)));

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
      //debug($data);

      /* Demandas Internas */
      $this->loadModel('Demanda');
      $this->Demanda->Behaviors->load('Containable');
      $demandas = $this->Demanda->find('all', array('conditions'=>array('Demanda.dt_prevista !=' => null)));

      foreach($demandas as $demanda) {
        $data[] = array(
            'id' => $demanda['Demanda']['id'],
            'title'=> "DI - " . $demanda['Demanda']['nome'],
            'start'=> date("Y-m-d", strtotime(str_replace('/', '-', $demanda['Demanda']['dt_prevista']))),
          //  'end' => $demanda['Demanda']['dt_prevista'],
            'allDay' => true,
            'url' => Router::url('/') . 'demandas/view/'.$demanda['Demanda']['id'],
            //'details' => $demanda['Demanda']['details'],
            'className' => 'calendar-demanda'
        );
      }
      //debug($data);

      $this->set("json", json_encode($data));
  }
}
?>

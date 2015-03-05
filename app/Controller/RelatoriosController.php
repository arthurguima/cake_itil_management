<?php class RelatoriosController extends AppController {

 /**
  * Indisponibilidade por serviço e data
  * ? => relatorios/indisponibilidades?servico=1&dt_inicio="2010-12-10"&dt_fim="2014-12-10"
  */
  public function indisponibilidades() {
    /* Lista de Servicos */
    $this->loadModel('Servico');
    $this->Servico->Behaviors->attach('Containable');
    $this->Servico->recursive = 2;

    if(isset($this->request->data['servico_id']) && isset($this->request->data['dt_inicio']) && isset($this->request->data['dt_fim'])){
      $fim = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$this->request->data['dt_fim']);
      $inicio = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$this->request->data['dt_inicio']);

      $conditions = '(Indisponibilidade.dt_inicio >= "'. $inicio .'") && (Indisponibilidade.dt_fim <= "'. $fim .'")';

      if($this->request->data['motivo_id'] != ''){
        $conditions = $conditions . " && (Indisponibilidade.motivo_id = " . $this->request->data['motivo_id'] .")";
      }

      $this->set('servico', $this->Servico->find('first', array(
        'conditions' => array('id' => $this->request->data['servico_id']),
        'contain' => array(
          'Indisponibilidade' => array(
            'Motivo' => array(),
            'conditions' => array($conditions)
          )
        )
      )));
    }

    /* Filtros */
    $this->set('servicos', $this->Servico->find('list', array('fields' => array('Servico.id', 'Servico.nome'))));
    $this->set(compact('servicos'));

    $this->loadModel('Motivo');
    $this->Motivo->Behaviors->attach('Containable');

    $this->set('motivos', $this->Motivo->find('list', array('fields' => array('Motivo.id', 'Motivo.nome'))));
    $this->set(compact('motivos'));
  }

  public function servicos() {
    /* Lista de Servicos */
    $this->loadModel('Servico');
    //$this->Servico->recursive = 3;
    $this->Servico->Behaviors->attach('Containable');
    $this->Servico->contain('Demanda');

    if(isset($this->request->data['servico_id']) && isset($this->request->data['dt_inicio']) && isset($this->request->data['dt_fim'])){
      $fim = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$this->request->data['dt_fim']);
      $inicio = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$this->request->data['dt_inicio']);

      $conditions = '(Demanda.data_cadastro >= "'. $inicio .'") && (Demanda.data_cadastro <= "'. $fim .'")';

      /*(if($this->request->data['motivo_id'] != ''){
        $conditions = $conditions . " && (Demanda.motivo_id = " . $this->request->data['motivo_id'] .")";
      }*/


      $this->set('servico', $this->Servico->find('first', array(
        'conditions' => array('id' => $this->request->data['servico_id']),
        'contain' => array(
          'Demanda' => array(
            'conditions' => array($conditions)
          )
        )
      )));
    }

    /* Filtros */
    $this->set('servicos', $this->Servico->find('list', array('fields' => array('Servico.id', 'Servico.nome'))));
    $this->set(compact('servicos'));

    /*$this->loadModel('Motivo');
    $this->Motivo->Behaviors->attach('Containable');

    $this->set('motivos', $this->Motivo->find('list', array('fields' => array('Motivo.id', 'Motivo.nome'))));
    $this->set(compact('motivos'));*/

  }

  public function contratos(){
    /* Lista de Contratos */
    $this->loadModel('Pe');
    $this->Pe->recursive = 3;
    $this->Pe->Behaviors->attach('Containable');

    debug($this->request->data);

    if(isset($this->request->data['contrato_id'])){
      if(($this->request->data['Aditivo']['Aditivo']['0'] != 'Aditivo' )){
        $conditions = '(Item.aditivo_id = "'. $this->request->data['Aditivo']['Aditivo']['0'] .'")';
      }
      else{
        $conditions = '(Item.contrato_id = "'. $this->request->data['contrato_id'] .'")';
      }

      $this->set('pes', $this->Pe->find('first', array(
        //'conditions' => array($conditions),
        'contain' => array(
          'Item' => array(
            'conditions' => array($conditions)
          )
        )
      )));
    }

    /* Filtros */
    $this->loadModel('Contrato');
    $this->set('contratos', $this->Contrato->find('list', array('fields' => array('Contrato.id', 'Contrato.numero'))));
    $this->set(compact('contratos'));

    // Os filtros de aditivos & itens de contrato são montados via ajax
  }

}

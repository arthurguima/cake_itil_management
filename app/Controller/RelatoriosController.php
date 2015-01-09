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

}

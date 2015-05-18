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

      $conditions = '((Indisponibilidade.dt_inicio >= "'. $inicio .'") && (Indisponibilidade.dt_inicio <= "'. $fim .'"))
                     && ((Indisponibilidade.dt_fim <= "'. $fim .'") || (Indisponibilidade.dt_fim IS NULL))';

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
    else{
      if(isset($this->params['url']['servico_id']) && isset($this->params['url']['dt_inicio']) && isset($this->params['url']['dt_fim'])){
        $fim = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$this->params['url']['dt_fim']);
        $inicio = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$this->params['url']['dt_inicio']);

        $conditions = '((Indisponibilidade.dt_inicio >= "'. $inicio .'") && (Indisponibilidade.dt_inicio <= "'. $fim .'"))
                       && ((Indisponibilidade.dt_fim <= "'. $fim .'") || (Indisponibilidade.dt_fim IS NULL))';

        $this->set('servico', $this->Servico->find('first', array(
          'conditions' => array('id' => $this->params['url']['servico_id']),
          'contain' => array(
            'Indisponibilidade' => array(
              'Motivo' => array(),
              'conditions' => array($conditions)
            )
          )
        )));
      }
    }

    /* Filtros */
    $this->set('servicos', $this->Servico->find('list', array('fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'))));
    $this->set(compact('servicos'));

    $this->loadModel('Motivo');
    $this->Motivo->Behaviors->attach('Containable');

    $this->set('motivos', $this->Motivo->find('list', array('fields' => array('Motivo.id', 'Motivo.nome'))));
    $this->set(compact('motivos'));
  }

  public function indis_total() {
    /* Lista de Servicos */
    $this->loadModel('Servico');
    $this->Servico->Behaviors->attach('Containable');
    $this->Servico->recursive = 2;

    if(isset($this->request->data['dt_inicio']) && isset($this->request->data['dt_fim'])){
      $fim = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$this->request->data['dt_fim']);
      $inicio = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$this->request->data['dt_inicio']);

      $conditions = '(Indisponibilidade.dt_inicio >= "'. $inicio .'") && (Indisponibilidade.dt_fim <= "'. $fim .'")';

      if($this->request->data['motivo_id'] != ''){
        $conditions = $conditions . " && (Indisponibilidade.motivo_id = " . $this->request->data['motivo_id'] .")";
      }

      $servicos = $this->Servico->find('all', array(
        //'conditions' => array('id' => $this->request->data['servico_id']),
        'contain' => array(
          'Indisponibilidade' => array(
            'Servico' => array('Area' => array('Cliente'=> array()) ),
            'Motivo' => array(),
            'conditions' => array($conditions)
          )
        )
      ));
    }

    $this->set('clientes', $this->IndiPorServicoPorCliente($servicos));

    /* Filtros */
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
    $this->set('servicos', $this->Servico->find('list', array('fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'))));
    $this->set(compact('servicos'));

    /*$this->loadModel('Motivo');
    $this->Motivo->Behaviors->attach('Containable');

    $this->set('motivos', $this->Motivo->find('list', array('fields' => array('Motivo.id', 'Motivo.nome'))));
    $this->set(compact('motivos'));*/

  }

  public function contratos(){

    /* Filtros */
    $this->loadModel('Cliente');
    $this->set('clientes', $this->Cliente->find('list', array('fields' => array('Cliente.id', 'Cliente.sigla'))));
    $this->set(compact('clientes'));

    // Os filtros de contratos, aditivos são montados via ajax
  }

  //TODO: Filtrar o cliente na SQL de consulta
  public function demandas(){

    /* Lista de Servicos */
    $this->loadModel('Demanda');
    //$this->Servico->recursive = 3;
    $this->Demanda->Behaviors->attach('Containable');

    $demandas = $this->Demanda->find('all', array(
      //'group' => array('Demanda.servico_id'),
      'contain' => array(
        'Servico' => array('Area' => array('Cliente'=> array()) ),
        'DemandaTipo' => array(),
        'Status' => array(),
      ),
      'joins' => array(
        array(
          'table'=>'statuses',
          'alias' => 'Status_',
          'type'=>'inner',
          'conditions'=> array(
            'Status_.id = Demanda.status_id',
            'Status_.fim =' => null,
          ),
        )
      )
    ));

    if(isset($this->request->data['cliente_id']))
      $this->set('servicos',$this->servicos_demandas($demandas,$this->request->data['cliente_id']));
    else
      $this->set('servicos',$this->servicos_demandas($demandas,null));

    /* Filtro Por Clientes */
    $this->loadModel('Cliente');
    $this->Cliente->Behaviors->attach('Containable');

    $this->set('clientes', $this->Cliente->find('list', array('fields' => array('Cliente.id', 'Cliente.sigla'))));
    $this->set(compact('clientes'));
  }

  public function dematrasadas(){
    $this->loadModel('Demanda');
    $this->Demanda->Behaviors->attach('Containable');

    $demandas = $this->Demanda->find('all', array(
      'conditions' => array("data_homologacao IS NULL && dt_prevista IS NOT NULL && dt_prevista < '" . date('Y-m-d') . "'"),
      'contain' => array(
        'Servico' => array('Area' => array('Cliente'=> array()) ),
        'DemandaTipo' => array(),
        'Status' => array(),
      ),
      'joins' => array(
        array(
          'table'=>'statuses',
          'alias' => 'Status_',
          'type'=>'inner',
          'conditions'=> array(
            'Status_.id = Demanda.status_id',
            'Status_.fim =' => null,
          ),
        )
      )
    ));

    if(isset($this->request->data['cliente_id']))
      $this->set('atrasos', $this->atraso_demandas($demandas,$this->request->data['cliente_id']));
    else
      $this->set('atrasos', $this->atraso_demandas($demandas,null));

    /* Filtro Por Clientes */
    $this->loadModel('Cliente');
    $this->Cliente->Behaviors->attach('Containable');

    $this->set('clientes', $this->Cliente->find('list', array('fields' => array('Cliente.id', 'Cliente.sigla'))));
    $this->set(compact('clientes'));
  }

  /* Funções de Apoio */

  private function IndiPorServicoPorCliente($servicos){
    $clientes = array();
    foreach ($servicos as $ser){
      $clientes[$ser['Area']['0']['Cliente']['sigla']][] = $ser;
    }

    return $clientes;
  }

  /*
   * Recebe um array de demandas e separa por serviço
  */
  private function servicos_demandas($demandas,$cliente=null){
    $demandasAUX = array();
    foreach ($demandas as $dem){
      if(isset($cliente)){
        if($dem['Servico']['Area']['0']['Cliente']['id'] == $cliente){
          $demandasAUX[$dem['Servico']['sigla']][] = $dem;
        }
      }
      else
        $demandasAUX[$dem['Servico']['sigla']][] = $dem;
    }

    return $demandasAUX;
  }

  /*
   * Recebe um array de demandas e separa por tempo de atraso
  */
  private function atraso_demandas($demandas,$cliente=null){
    $demandasAUX = array();
    $demandasAUX['Atrasadas entre 1 e 15 dias'] = array();
    $demandasAUX['Atrasadas entre 16 e 30 dias'] = array();
    $demandasAUX['Atrasadas entre 31 e 60 dias'] = array();
    $demandasAUX['Atrasadas há mais de 60 dias'] = array();

    foreach ($demandas as $dem){
      if(isset($cliente)){
        if($dem['Servico']['Area']['0']['Cliente']['id'] == $cliente){
          $t1 = date_create(preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$dem['Demanda']['dt_prevista']));
          $t2 = date_create(date('Y-m-d'));
          $total = date_diff($t1,$t2);

          if($total->days <= 15){
            $demandasAUX['Atrasadas entre 1 e 15 dias'][] = $dem;
          }else{
            if($total->days <= 30){
              $demandasAUX['Atrasadas entre 16 e 30 dias'][] = $dem;
            }else{
              if($total->days <= 60){
                $demandasAUX['Atrasadas entre 31 e 60 dias'][] = $dem;
              }
              else{
                $demandasAUX['Atrasadas há mais de 60 dias'][] = $dem;
              }
            }
          }
        }
      }
    }

    return $demandasAUX;
  }

}

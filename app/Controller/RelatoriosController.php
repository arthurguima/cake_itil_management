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
    $this->set('servicos', $this->Servico->find('list', array(
      'conditions' => array("Servico.cliente_id" . $_SESSION['User']['clientes']),
      'fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'))));
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
        'conditions' => array("Servico.cliente_id" . $_SESSION['User']['clientes']),
        'contain' => array(
          'Indisponibilidade' => array(
            'Servico' => array('Cliente'=> array() ),
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

    if($this->request->data !=null){
      $this->loadModel('ItemPe');
      $this->ItemPe->Behaviors->load('Containable');

      if($this->request->data['Contrato']['Contrato'][0] != "Contrato"){

        // Resgasta o que foi planejado nas PAS do contrato X
        // A partir disso pode-se fazer o batimento com o que realmente foi utilizado
        if($this->request->data['Aditivo']['Aditivo'][0] != "Aditivo"){
          $conditions = 'ItemPe.aditivo_id = '.$this->request->data['Aditivo']['Aditivo'][0];

          $this->loadModel('Aditivo');
          $this->Aditivo->Behaviors->load('Containable');
          $this->Aditivo->contain('Contrato');
          $this->set('aditivo', $this->Aditivo->find('first', array('conditions'=> array('Aditivo.id = ' .$this->request->data['Aditivo']['Aditivo'][0]))));
          $this->set(compact('aditivo'));
        }
        else{
          $conditions = 'ItemPe.contrato_id = '. $this->request->data['Contrato']['Contrato'][0] . "&& ItemPe.aditivo_id  IS NULL";

          $this->loadModel('Contrato');
          $this->set('contrato', $this->Contrato->find('first', array('conditions'=> array('Contrato.id = ' .$this->request->data['Contrato']['Contrato'][0]))));
          $this->set(compact('contrato'));
        }

        $this->set('items', $this->itemsEmpenhados(
          $this->ItemPe->find('all', array(
            'contain' => array(
              'ItemPeFilha' => array(),
              'Item' => array(),
              'Pe' => array('Ord' => array())
            ),
            'conditions'=> array(
                $conditions . ' && ItemPe.itempe_id IS NULL'
            )
          )
        )));
      }
    }

    /* Filtros */
    $this->loadModel('Cliente');
    $this->set('clientes', $this->Cliente->find('list', array(
      'conditions' => array("Cliente.id" . $_SESSION['User']['clientes']),
      'fields' => array('Cliente.id', 'Cliente.sigla'))));
    $this->set(compact('clientes'));

    // Os filtros de contratos, aditivos são montados via ajax
  }

  //TODO: Filtrar o cliente na SQL de consulta
  public function demandas(){

    /* Lista de Servicos */
    $this->loadModel('Demanda');
    //$this->Servico->recursive = 3;
    $this->Demanda->Behaviors->attach('Containable');

    $conditions_serv = "Servico.cliente_id" . $_SESSION['User']['clientes'];
    if(isset($this->request->data['cliente_id']) && !empty($this->request->data['cliente_id'])){
      $conditions_serv = 'Servico_.cliente_id = ' . $this->request->data['cliente_id'];
    }

    $conditions = "";
    $and = false;
    if(isset($this->request->data['origem_cliente']) && $this->request->data['origem_cliente'] != ''){
      $conditions = $conditions . 'Demanda.origem_cliente = ' . $this->request->data['origem_cliente'];
      $and = true;
    }
    if(isset($this->request->data['demanda_tipo_id']) && $this->request->data['demanda_tipo_id'] != ''){
      $and ? ($conditions = $conditions . ' AND ' ) : ($conditions = $conditions);
      $conditions = $conditions . 'Demanda.demanda_tipo_id = ' . $this->request->data['demanda_tipo_id'];
      $and = true;
    }
    if(isset($this->request->data['user_id']) && $this->request->data['user_id'] != ''){
      $and ? ($conditions = $conditions . ' AND ' ) : ($conditions = $conditions);
      $conditions = $conditions . 'Demanda.user_id = ' . $this->request->data['user_id'];
    }

    $demandas = $this->Demanda->find('all', array(
      //'group' => array('Demanda.servico_id'),
      'contain' => array(
        'Servico' => array('Cliente'=> array() ),
        'DemandaTipo' => array(),
        'Status' => array(),
      ),
      'conditions' => array($conditions),
      'joins' => array(
        array(
          'table'=>'statuses',
          'alias' => 'Status_',
          'type'=>'inner',
          'conditions'=> array(
            'Status_.id = Demanda.status_id',
            'Status_.fim =' => null,
          ),
        ),
        array(
          'table'=>'servicos',
          'alias' => 'Servico_',
          'type'=>'inner',
          'conditions'=> array('Servico_.id = Demanda.servico_id', $conditions_serv),
        )
      )
    ));

    $this->set('servicos',$this->servicos_demandas($demandas,null));

    /* Filtro Por Clientes */
    $this->loadModel('Cliente');
    $this->Cliente->Behaviors->attach('Containable');

    $this->set('clientes', $this->Cliente->find('list', array(
      'conditions' => array("Cliente.id" . $_SESSION['User']['clientes']),
      'fields' => array('Cliente.id', 'Cliente.sigla'))));
    $this->set(compact('clientes'));

    $demandaTipos = $this->Demanda->DemandaTipo->find('list', array('fields' => array('DemandaTipo.id', 'DemandaTipo.nome')));
    $this->set(compact('demandaTipos'));

    $users = $this->Demanda->User->find('list', array('fields' => array('User.id', 'User.nome')));
    $this->set(compact('users'));
  }

  public function demandas_cliente(){

    /* Lista de Servicos */
    $this->loadModel('Demanda');
    //$this->Servico->recursive = 3;
    $this->Demanda->Behaviors->attach('Containable');

    $conditions_serv = "Servico.cliente_id" . $_SESSION['User']['clientes'];
    if(isset($this->request->data['cliente_id']) && !empty($this->request->data['cliente_id'])){
      $conditions_serv = 'Servico_.cliente_id = ' . $this->request->data['cliente_id'];
    }

    $conditions = "";
    $and = false;
    if(isset($this->request->data['origem_cliente']) && $this->request->data['origem_cliente'] != ''){
      $conditions = $conditions . 'Demanda.origem_cliente = ' . $this->request->data['origem_cliente'];
      $and = true;
    }
    if(isset($this->request->data['demanda_tipo_id']) && $this->request->data['demanda_tipo_id'] != ''){
      $and ? ($conditions = $conditions . ' AND ' ) : ($conditions = $conditions);
      $conditions = $conditions . 'Demanda.demanda_tipo_id = ' . $this->request->data['demanda_tipo_id'];
      $and = true;
    }
    if(isset($this->request->data['user_id']) && $this->request->data['user_id'] != ''){
      $and ? ($conditions = $conditions . ' AND ' ) : ($conditions = $conditions);
      $conditions = $conditions . 'Demanda.user_id = ' . $this->request->data['user_id'];
    }

    $demandas = $this->Demanda->find('all', array(
      'contain' => array(
        'Servico' => array('Cliente'=> array() ),
        'DemandaTipo' => array(),
        'Status' => array(),
        'Historico' => array(
          'order' => 'Historico.created DESC',
          'limit' => 2
        )
      ),
      'conditions' => array($conditions),
      'joins' => array(
        array(
          'table'=>'statuses',
          'alias' => 'Status_',
          'type'=>'inner',
          'conditions'=> array(
            'Status_.id = Demanda.status_id',
            'Status_.fim =' => null,
          ),
        ),
        array(
          'table'=>'servicos',
          'alias' => 'Servico_',
          'type'=>'inner',
          'conditions'=> array('Servico_.id = Demanda.servico_id', $conditions_serv),
        )
      )
    ));

    $this->set('demandas', $demandas);

    /* Filtro Por Clientes */
    $this->loadModel('Cliente');
    $this->Cliente->Behaviors->attach('Containable');

    $this->set('clientes', $this->Cliente->find('list', array(
      'conditions' => array("Cliente.id" . $_SESSION['User']['clientes']),
      'fields' => array('Cliente.id', 'Cliente.sigla'))));
    $this->set(compact('clientes'));

    $demandaTipos = $this->Demanda->DemandaTipo->find('list', array('fields' => array('DemandaTipo.id', 'DemandaTipo.nome')));
    $this->set(compact('demandaTipos'));

    $users = $this->Demanda->User->find('list', array('fields' => array('User.id', 'User.nome')));
    $this->set(compact('users'));
  }

  public function dematrasadas(){
    $this->loadModel('Demanda');
    $this->Demanda->Behaviors->attach('Containable');

    $conditions_serv = "Servico.cliente_id" . $_SESSION['User']['clientes'];
    if(isset($this->request->data['cliente_id']) && !empty($this->request->data['cliente_id'])){
      $conditions_serv = 'Servico_.cliente_id = ' . $this->request->data['cliente_id'];
    }

    $conditions = "";
    if(isset($this->request->data['origem_cliente']) && $this->request->data['origem_cliente'] != ''){
      $conditions = $conditions . ' && origem_cliente = ' . $this->request->data['origem_cliente'];
    }
    if(isset($this->request->data['demanda_tipo_id']) && $this->request->data['demanda_tipo_id'] != ''){
      $conditions = $conditions . ' && demanda_tipo_id = ' . $this->request->data['demanda_tipo_id'];
    }
    if(isset($this->request->data['user_id']) && $this->request->data['user_id'] != ''){
      $conditions = $conditions . ' && user_id = ' . $this->request->data['user_id'];
    }

    $demandas = $this->Demanda->find('all', array(
      'conditions' => array(
        "data_homologacao IS NULL && dt_prevista IS NOT NULL && dt_prevista < '" .
        date('Y-m-d') . "'" . $conditions
      ),
      'contain' => array(
        'Servico' => array('Cliente'=> array() ),
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
        ),
        array(
          'table'=>'servicos',
          'alias' => 'Servico_',
          'type'=>'inner',
          'conditions'=> array('Servico_.id = Demanda.servico_id', $conditions_serv),
        )
      )
    ));

    $this->set('atrasos', $this->atraso_demandas($demandas,null));

    /* Filtro Por Clientes */
    $this->loadModel('Cliente');
    $this->Cliente->Behaviors->attach('Containable');

    $this->set('clientes', $this->Cliente->find('list', array(
      'conditions' => array("Cliente.id" . $_SESSION['User']['clientes']),
      'fields' => array('Cliente.id', 'Cliente.sigla'))));
    $this->set(compact('clientes'));

    $demandaTipos = $this->Demanda->DemandaTipo->find('list', array('fields' => array('DemandaTipo.id', 'DemandaTipo.nome')));
    $this->set(compact('demandaTipos'));

    $users = $this->Demanda->User->find('list', array('fields' => array('User.id', 'User.nome')));
    $this->set(compact('users'));
  }

  public function prioridades(){
    $this->loadModel('Demanda');
    $this->Demanda->Behaviors->attach('Containable');

    $conditions = "";
    if(isset($this->request->data['servico_id']) && !empty($this->request->data['servico_id'])){
      $conditions = $conditions . 'servico_id = ' . $this->request->data['servico_id'];
    }
    if(isset($this->request->data['origem_cliente']) && $this->request->data['origem_cliente'] != ''){
      $conditions = $conditions . ' && origem_cliente = ' . $this->request->data['origem_cliente'];
    }
    if(isset($this->request->data['demanda_tipo_id']) && $this->request->data['demanda_tipo_id'] != ''){
      $conditions = $conditions . ' && demanda_tipo_id = ' . $this->request->data['demanda_tipo_id'];
    }
    if(isset($this->request->data['user_id']) && $this->request->data['user_id'] != ''){
      $conditions = $conditions . ' && user_id = ' . $this->request->data['user_id'];
    }
    if(isset($this->request->data['servico_id']) && !empty($this->request->data['servico_id'])){
      $demandas = $this->Demanda->find('all', array(
        'conditions' => array(
          $conditions
        ),
        'contain' => array(
          'DemandaTipo' => array(),
          'Status' => array(),
          'Rdm' => array('Release' => array())
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

      $this->set('demandas', $demandas);
    }

    /* Filtro Por Clientes */
    $this->loadModel('Servico');
    $this->Servico->Behaviors->attach('Containable');

    $this->set('servicos', $this->Servico->find('list', array(
      'conditions' => array("Servico.cliente_id" . $_SESSION['User']['clientes']),
      'fields' => array('Servico.id', 'Servico.sigla'))));
    $this->set(compact('servicos'));

    $demandaTipos = $this->Demanda->DemandaTipo->find('list', array('fields' => array('DemandaTipo.id', 'DemandaTipo.nome')));
    $this->set(compact('demandaTipos'));

    $users = $this->Demanda->User->find('list', array('fields' => array('User.id', 'User.nome')));
    $this->set(compact('users'));
  }

  /*
   * Mostra uma visão diferenciada para gestão de idéias (SSs)
  */
  public function gsses(){
    $this->loadModel('Ss');
    $this->Ss->Behaviors->attach('Containable');

    $sses = $this->Ss->find('all', array(
      'conditions' => array("Servico.cliente_id" . $_SESSION['User']['clientes']),
      'contain' => array(
        'Servico' => array(/*'Cliente'=> array() */),
        'Pe' => array('ItemPe' => array('Item' => array())),
        'Ord' => array('ItemPe'=> array('ItemPePai' => array('Item'=> array()))),
        'Demanda' => array(),
        'Status' => array()
      ),
      'joins' => array(
        array(
          'table'=>'statuses',
          'alias' => 'Status_',
          'type'=>'inner',
          'conditions'=> array(
            'Status_.id = Ss.status_id',
            'Status_.fim =' => null,
          ),
        )
      )
    ));

    $this->set('sses', $sses);
  }

  /*
   * Mostra os releases de um serviço como Timeline
  */
  public function releases(){
    $this->loadModel('Release');
    $this->Release->Behaviors->attach('Containable');

    $conditions = "";
    if(isset($this->request->data['servico_id']) && !empty($this->request->data['servico_id'])){
      $conditions = $conditions . 'Release.servico_id = ' . $this->request->data['servico_id'];


      $releases = $this->Release->find('all', array(
        'conditions' => array(
          $conditions
        ),
        'order' => array("Rdm.dt_executada" => "DESC"),
        'contain' => array(
          'Servico' => array(),
          'Rdm' => array('Demanda' => array(), 'Chamado' => array()),
          'Note' => array()
        )
      ));

      $this->set('releases', $releases);
    }

    $this->loadModel('Servico');
    $this->Servico->Behaviors->attach('Containable');

    $this->set('servicos', $this->Servico->find('list', array(
      'conditions' => array("Servico.cliente_id" . $_SESSION['User']['clientes']),
      'fields' => array('Servico.id', 'Servico.sigla'))));
    $this->set(compact('servicos'));
  }

  /*
   * Relatório de atividades
   * Procurar por todas as tarefas no nome do usuário em um período
  */
  public function tarefasusuario(){
    $this->loadModel('Subtarefa');
    $this->Subtarefa->Behaviors->attach('Containable');

    $conditions = "";
    if(isset($this->request->data['user_id']) && !empty($this->request->data['user_id'])){
      $conditions = $conditions . 'Subtarefa.user_id = ' . $this->request->data['user_id'];

    if(isset($this->request->data['dt_inicio']) && !empty($this->request->data['dt_inicio'])){
      $inicio = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$this->request->data['dt_inicio']);
      $conditions = $conditions . " && Subtarefa.created >= '" . $inicio . "'";
    }

    if(isset($this->request->data['dt_fim']) && !empty($this->request->data['dt_fim'])){
      $fim = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$this->request->data['dt_fim']);
      $conditions = $conditions . " && Subtarefa.dt_prevista <= '" . $fim . "'";
    }

    if((($this->request->data['check'] == 1) || ($this->request->data['check'] == 0)) && ($this->request->data['check'] != ''))
      $conditions = $conditions . " && Subtarefa.check = " .  $this->request->data['check'];

      $subtarefas = $this->Subtarefa->find('all', array(
        'conditions' => array(
          $conditions
        ),
        'order' => array("Subtarefa.dt_prevista" => "ASC", "Subtarefa.created" => "ASC"),
        'contain' => array(
  				'Servico' => array(),
  				'Demanda' => array(),
  				'Chamado' => array(),
  				'Release' => array(),
          'Rdm' => array(),
  			),
      ));

      $this->set('subtarefas', $subtarefas);
    }

    $this->loadModel('User');
    $this->User->Behaviors->attach('Containable');

    $this->set('users', $this->User->find('list', array(
      'fields' => array('User.id', 'User.nome'))));
    $this->set(compact('users'));
  }

  /*
   * Se existe uma contagem para a Pa automaticamente RESERVAMOS o valor
   * Se existe também uma OS para a Pa o valor está EMPENHADO
   * se já foi feita a contagem final o valor foi utilizado
  */
  private function itemsEmpenhados($itemPes){
    $item = array();
    foreach ($itemPes as $i){
      if(!isset($item[$i['Item']['id']])){
        $item[$i['Item']['id']] = $i['Item'];
        $item[$i['Item']['id']]['Reservado'] = 0;
        $item[$i['Item']['id']]['Empenhado'] = 0;
        $item[$i['Item']['id']]['Utilizado'] = 0;
      }
      if(!isset($i['Pe']['Ord']['id'])) //PA sem OS
        $item[$i['Item']['id']]['Reservado'] += $i['ItemPe']['volume'];
      else{
        if(isset($i['ItemPeFilha']['id']))// Possui OS com contagem final
          $item[$i['Item']['id']]['Utilizado'] += $i['ItemPe']['volume'];
        else
          $item[$i['Item']['id']]['Empenhado'] += $i['ItemPe']['volume'];//OS sem contagem final
      }
    }

    return $item;
  }

  /* Funções de Apoio */

  private function IndiPorServicoPorCliente($servicos){
    $clientes = array();
    foreach ($servicos as $ser){
      $clientes[$ser['Cliente']['sigla']][] = $ser;
    }

    return $clientes;
  }

  /*
   * Recebe um array de demandas e separa por serviço
  */
  private function servicos_demandas($demandas,$cliente=null){
    $demandasAUX = array();
    foreach ($demandas as $dem){
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

    return $demandasAUX;
  }

}

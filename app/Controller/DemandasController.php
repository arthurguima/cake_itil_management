<?php class DemandasController extends AppController {

  public $helpers = array('Times');

/**
 * index method
 *
 * @return void
 */
  public function index() {
    // Add filter
    $this->Filter->addFilters(
      array(
        'nome_' => array(
          'Demanda.nome' => array('operator' => 'LIKE')
        ),
        'origem_cliente' => array(
          'Demanda.origem_cliente' => array(
            'select' => $this->Filter->select('Solicitada pelo cliente?', array(1 => 'Sim', 0 => 'Não') )
          )
        ),
        'responsavel' => array(
          'Demanda.user_id' => array(
						'select' => $this->Filter->select('Responsável', $this->Demanda->User->find('list',
									array('conditions' => array(), 'fields' => array('User.id', 'User.nome'))))
					)
        ),
        'servico' => array(
          'Demanda.servico_id' => array(
            'select' => $this->Filter->select('Serviço', $this->Demanda->Servico->find('list',
                    array('conditions'=> array("Servico.cliente_id" . $_SESSION['User']['clientes']),
                          'fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'))))
          )
        ),
        'status' => array(
          'Demanda.status_id' => array(
            'select' => $this->Filter->select('Status', $this->Demanda->Status->find('list',
                  array('conditions' => array('Status.tipo' => 1), 'fields' => array('Status.id', 'Status.nome'))))
          )
        ),
        'status_diferente' => array(
          'Demanda.status_id' => array(
            'select' => $this->Filter->select('Status Diferente de', $this->Demanda->Status->find('list',
                  array('conditions' => array('Status.tipo' => 1), 'fields' => array('Status.id', 'Status.nome')))),
            'operator'    => '!='
          )
        ),
        'status_diferente2' => array(
          'Demanda.status_id' => array(
            'select' => $this->Filter->select('Status Diferente de', $this->Demanda->Status->find('list',
                  array('conditions' => array('Status.tipo' => 1), 'fields' => array('Status.id', 'Status.nome')))),
            'operator'    => '!='
          )
        ),
        'status_diferente3' => array(
          'Demanda.status_id' => array(
            'select' => $this->Filter->select('Status Diferente de', $this->Demanda->Status->find('list',
                  array('conditions' => array('Status.tipo' => 1), 'fields' => array('Status.id', 'Status.nome')))),
            'operator'    => '!='
          )
        ),
        'status_diferente4' => array(
          'Demanda.status_id' => array(
            'select' => $this->Filter->select('Status Diferente de', $this->Demanda->Status->find('list',
                  array('conditions' => array('Status.tipo' => 1), 'fields' => array('Status.id', 'Status.nome')))),
            'operator'    => '!='
          )
        ),
        'clarity_dm' => array(
          'Demanda.clarity_dm_id' => array('operator' => 'LIKE'),
        ),
        'tipo' => array(
          'Demanda.demanda_tipo_id' => array(
            'select' => $this->Filter->select('Tipo de Demanda', $this->Demanda->DemandaTipo->find('list', array('fields' => array('DemandaTipo.id', 'DemandaTipo.nome'))))
          )
        ),
        'dtprevisao' => array(
          'Demanda.dt_prevista' => array(
            'operator' => 'BETWEEN',
            'between' => array(
              'text' => ' a ',
            )
          )
        ),
        'dtcadastro' => array(
          'Demanda.data_cadastro' => array(
            'operator' => 'BETWEEN',
            'between' => array(
              'text' => ' a ',
            )
          )
        ),
        'prioridade' => array(
          'Demanda.prioridade' => array('operator' => '>=')
        )
      )
    );
    //$this->Filter->addFilters('filtro');

    // Define conditions
    // Apenas RDMS dos cliente do Usuário.
    $conditions = $this->Filter->getConditions();

    if($conditions == null)
      $conditions = $conditions + array(998 => array('Status.fim IS NULL'));

    $conditions = $conditions + array(999 => array("Servico.cliente_id" . $_SESSION['User']['clientes']));

    $this->Filter->setPaginate('order', 'Demanda.data_homologacao, Demanda.modified DESC, Demanda.created DESC');
    $this->Filter->setPaginate('conditions', $conditions);
    $this->Filter->setPaginate('limit', 150);

    $statuses = $this->Demanda->Status->find('list', array(
      'conditions' => array('Status.tipo' => 1), 'fields' => array('Status.id', 'Status.nome')));

    //$this->Demanda->recursive = 0;
    $this->set('demandas', $this->paginate());
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function view($id = null) {
    if (!$this->Demanda->exists($id)) {
      throw new NotFoundException(__('Invalid demanda'));
    }
    //$this->Demanda->recursive = 2;
    $this->Demanda->Behaviors->load('Containable');

    $options = array(
      'conditions' => array('Demanda.' . $this->Demanda->primaryKey => $id),
      'contain' => array(
        'DemandaPai' => array(),
        'DemandaFilha' => array('Servico', 'DemandaTipo', 'Status'),
        'Rdm' => array(),
        'Status' => array(),
        'Chamado' => array(),
        'DemandaTipo' => array(),
        'Servico' => array(),
        'User' => array(),
        'Historico' => array(),
        'Subtarefa' => array()
      )
    );
    $this->set('demanda', $this->Demanda->find('first', $options));
  }

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if ($this->request->is('post')) {
      $this->Demanda->create();
      if ($this->Demanda->save($this->request->data)) {
        $this->Session->setFlash('Nova Demanda Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        if($this->params['url']['controller'] == null){
          $this->redirect(array('action' => 'view', $this->Demanda->id));
        }
        else{
          return $this->redirect(array('controller' => $this->params['url']['controller'], 'action' => 'view', $this->params['url']['id']));
        }
      } else {
        $this->Session->setFlash('Não foi possível criar a nova demanda.', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    }

    /* Relacionamentos */
      $users = $this->Demanda->User->find('list', array('fields' => array('User.id', 'User.nome')));
      $this->set(compact('users'));

      $servicos = $this->Demanda->Servico->find('list', array(
        'fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'),
        'conditions' => ("Servico.cliente_id" . $_SESSION['User']['clientes'])));
      $this->set(compact('servicos'));

      $demandaTipos = $this->Demanda->DemandaTipo->find('list', array('fields' => array('DemandaTipo.id', 'DemandaTipo.nome')));
      $this->set(compact('demandaTipos'));

      $statuses = $this->Demanda->Status->find('list', array('conditions' => array('Status.tipo' => 1), 'fields' => array('Status.id', 'Status.nome')));
      $this->set(compact('statuses'));
  }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function edit($id = null) {
    if (!$this->Demanda->exists($id)) {
      throw new NotFoundException(__('Demanda Inválida!'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Demanda->save($this->request->data)) {
        $this->Session->setFlash('Demanda atualizada com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('action' => 'view', $id));
      } else {
        $this->Session->setFlash('A demanda não pode ser atualizada!', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Demanda.' . $this->Demanda->primaryKey => $id));
      $this->request->data = $this->Demanda->find('first', $options);
    }

    /* Relacionamentos */
      $this->set('demandas',
                $this->Demanda->find('list', array(
                  'fields' => array('Demanda.id', 'Demanda.clarity_dm_id'),
                  'conditions' => array('Demanda.servico_id' => $this->data['Demanda']['servico_id']))));

      $users = $this->Demanda->User->find('list', array('fields' => array('User.id', 'User.nome')));
      $this->set(compact('users'));

      $servicos = $this->Demanda->Servico->find('list', array('fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia')));
      $this->set(compact('servicos'));

      $demandaTipos = $this->Demanda->DemandaTipo->find('list', array('fields' => array('DemandaTipo.id', 'DemandaTipo.nome')));
      $this->set(compact('demandaTipos'));

      $statuses = $this->Demanda->Status->find('list', array('conditions' => array('Status.tipo' => 1), 'fields' => array('Status.id', 'Status.nome')));
      $this->set(compact('statuses'));
  }

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param int id
 * @return void
 */
  public function delete($id = null) {
    $this->Demanda->id = $id;
    if (!$this->Demanda->exists()) {
      throw new NotFoundException(__('Demanda Inválida'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Demanda->delete()) {
      $this->Session->setFlash('A demanda foi removida com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
    } else {
      $this->Session->setFlash('A demanda não pode ser removida!', 'alert-box', array ('class' => 'alert alert-danger'));
    }
    return $this->redirect(array('action' => 'index'));
  }

  /**
  * Form inline
  */
  public function ajax_edit_prioridade(){
    $this->autoRender = false;

    if ($this->request->data) {
        $this->Demanda->id = $this->request->data('id');;
        $this->Demanda->saveField('prioridade', $this->request->data('prioridade'));

        return $this->request->data('prioridade');
    }
  }

  /**
  * Form inline
  */
  public function ajax_edit_status(){
    $this->autoRender = false;

    if ($this->request->data) {

        $demanda = explode('-', $this->request->data('id'));
        $demanda = $demanda[1];
        $this->Demanda->id = $demanda;
        $this->Demanda->saveField('status_id', $this->request->data('status_id'));

        $this->loadModel('Status');
        $status =  $this->Status->find('first', array('conditions' => array(
               'Status.id' => $this->request->data('status_id')), 'fields' => array('Status.nome')));

        return "<span style='border-bottom: 3px solid #" . substr(md5($status['Status']['nome']), 0, 6) . ";'>" . $status['Status']['nome'] . "</span>";
    }
  }

  /**
  * returns a list of demandas filtered by $servico
  */
  public function optionList(){
    $this->layout = null;
    //$this->autoRender = false;

    //$this->Demanda->recursive = -1;
    $this->set('demandas',
                $this->Demanda->find('list', array(
                  'fields' => array('Demanda.id', 'Demanda.clarity_dm_id'),
                  'conditions' => array('Demanda.servico_id' => $this->params['url']['servico']))));
  }
}

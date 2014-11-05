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
        'responsavel' => array(
          'Demanda.criador' => array('operator' => 'LIKE')
        ),
        'servico' => array(
          'Demanda.servico_id' => array(
            'select' => $this->Filter->select('Serviço', $this->Demanda->Servico->find('list', array('fields' => array('Servico.id', 'Servico.sigla'))))
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
        'clarity_dm' => array(
          'Demanda.clarity_dm_id' => array('operator' => '='),
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
    $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
    $this->Filter->setPaginate('limit', 3000);

    $statuses = $this->Demanda->Status->find('list', array('conditions' => array('Status.tipo' => 1), 'fields' => array('Status.id', 'Status.nome')));

    $this->Demanda->recursive = 0;
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
    $options = array('conditions' => array('Demanda.' . $this->Demanda->primaryKey => $id));
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
        return $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('Não foi possível criar a nova demanda.', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    }
    /* Relacionamentos */
      $servicos = $this->Demanda->Servico->find('list', array('fields' => array('Servico.id', 'Servico.nome')));
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
        return $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('A demanda não pode ser atualizada!', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Demanda.' . $this->Demanda->primaryKey => $id));
      $this->request->data = $this->Demanda->find('first', $options);
    }

    /* Relacionamentos */
      $servicos = $this->Demanda->Servico->find('list', array('fields' => array('Servico.id', 'Servico.nome')));
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

        return $status['Status']['nome'];
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

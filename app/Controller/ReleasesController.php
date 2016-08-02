<?php class ReleasesController extends AppController {

  public function index(){
    // Add filter
    $this->Filter->addFilters(
      array(
        'servico' => array(
          'Servico.id' => array(
            'select' => $this->Filter->select('Serviço', $this->Release->Servico->find('list', array(
                        'contain' => array('_IndisponibilidadesServico', '_Servico'), //'Hack' para HABTM
                        //'conditions'=> array("Servico.cliente_id" . $_SESSION['User']['clientes']),
                        'fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'))))
          )
        ),
        'dt_executada' => array(
          'Rdm.dt_executada' => array(
            'operator' => 'BETWEEN',
            'between' => array(
              'text' => ' a ',
            )
          )
        ),        
        'dt_fim' => array(
          'Release.dt_fim' => array(
            'operator' => 'BETWEEN',
            'between' => array(
              'text' => ' a ',
            )
          )
        )
      )
    );
    //$this->Filter->addFilters('filtro');
    $conditions = $this->Filter->getConditions();

    if($conditions == null)
      $conditions = $conditions + array(998 => array('Release.dt_fim IS NULL'));

    $conditions = $conditions + array(999 => array("Servico.cliente_id" . $_SESSION['User']['clientes']));

    // Define conditions
    //$this->Filter->setPaginate('order', 'Release.dt_prevista DESC, Rdm.dt_executada, Rdm.modified DESC, Rdm.created DESC');
    $this->Filter->setPaginate('conditions', $conditions);
    $this->Filter->setPaginate('limit', 15);

    $this->Release->Behaviors->load('Containable');
    $this->Filter->setPaginate('contain',
      array('Servico', 'Rdm' => array('Demanda'=> array('Status'))));

    //$this->Release->recursive = 3;
    $this->set('releases', $this->paginate());
  }

  public function view($id = null){
  if (!$this->Release->exists($id)) {
      throw new NotFoundException(__('Release Inválida'));
    }
    $options = array('conditions' => array('Release.' . $this->Release->primaryKey => $id));
    $this->Release->recursive = 2;
    $this->set('release', $this->Release->find('first', $options));
  }

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if ($this->request->is('post')) {
      $this->Release->create();
      if ($this->Release->save($this->request->data)) {
        $this->Session->setFlash('Release Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        $this->redirect(array('action' => 'view', $this->Release->id));
      } else {
        $this->Session->setFlash('Não foi possível criar o novo release.', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    }
    /* Relacionamentos */
      $servicos = $this->Release->Servico->find('list', array('fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia')));
      $this->set(compact('servicos'));
  }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function edit($id = null) {
    if (!$id) { throw new NotFoundException(__('Release  Inválido'));}

    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Release->save($this->request->data)) {
        $this->Session->setFlash('Release  atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        $this->redirect(array('action' => 'view', $this->Release->id));
      } else {
        $this->Session->setFlash('Não foi possível atualizar o contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Release.' . $this->Release->primaryKey => $id));
      $this->request->data = $this->Release->find('first', $options);
    }

    /* Relacionamentos */
      $servicos = $this->Release->Servico->find('list', array('fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia')));
      $this->set(compact('servicos'));

      $this->set('rdms',
                  $this->Release->Rdm->find('list', array(
                    'fields' => array('Rdm.id', 'Rdm.numero'),
                    'conditions' => array('Rdm.servico_id' => $this->data['Release']['servico_id']))));
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
    $this->Release->id = $id;

    if (!$this->Release->exists()) {
      throw new NotFoundException(__('Release inválido'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Release->delete()) {
      $this->Session->setFlash('O Release  com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
    } else {
      $this->Session->setFlash('O Release  com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
    }
    return $this->redirect(array('controller' =>  "releases", 'action' => "index"));
  }
}

<?php class GrupotarefasController extends AppController {

/**
 * index method
 *
 * @return void
 */
  public function index() {
    $this->Grupotarefa->recursive = 0;
    $this->set('grupotarefas', $this->paginate());
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function view($id = null) {
    if (!$this->Grupotarefa->exists($id)) {
      throw new NotFoundException(__('Grupo de tarefa Inválido.'));
    }
    $options = array(
      'conditions' => array('Grupotarefa.' . $this->Grupotarefa->primaryKey => $id)
    );
    $this->set('grupotarefa', $this->Grupotarefa->find('first', $options));
  }

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if ($this->request->is('post')) {
      $this->Grupotarefa->create();
      if ($this->Grupotarefa->save($this->request->data)) {
        $this->Session->setFlash('Grupotarefa  Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('controller' =>  'grupotarefas', 'action' => 'index' ));
      } else {
        $this->Session->setFlash('Não foi possível criar o novo grupotarefa contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    }
  }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function edit($id = null) {
    if (!$id) { throw new NotFoundException(__('Grupo de tarefas  Inválido'));}

    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Grupotarefa->save($this->request->data)) {
        $this->Session->setFlash('Grupo de tarefas  atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('controller' =>  'grupotarefas', 'action' => 'index' ));
      } else {
        $this->Session->setFlash('Não foi possível atualizar o contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Grupotarefa.' . $this->Grupotarefa->primaryKey => $id));
      $this->request->data = $this->Grupotarefa->find('first', $options);
    }
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
    $contrato_id = $this->Grupotarefa->contrato_id;
    $this->Grupotarefa->id = $id;

    if (!$this->Grupotarefa->exists()) {
      throw new NotFoundException(__('Grupotarefa inválido'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Grupotarefa->delete()) {
      $this->Session->setFlash('O Grupotarefa  com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
    } else {
      $this->Session->setFlash('O Grupotarefa  com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
    }
    return $this->redirect(array('controller' =>  'grupotarefas', 'action' => 'index' ));
  }

  /**
   * edit method
   *
   * @throws NotFoundException
   * @param int id
   * @return void
   */
    public function assign() {
      $this->Grupotarefa->recursive = 0;
      $this->Grupotarefa->Behaviors->load('Containable');

      $grps = $this->Grupotarefa->find('list', array(
        'fields' => array('Grupotarefa.id', 'Grupotarefa.nome'),
        'conditions' => array("Grupotarefa.tipo = " . $this->params['url']['tipo']),
        'contain' => array()
      ));
      $this->set("grps",   $grps);


      if ($this->request->is('post') || $this->request->is('put')) {

        $grp = $this->Grupotarefa->find('first', array(
          'fields' => array('Grupotarefa.id', 'Grupotarefa.nome', 'Grupotarefa.marcador'),
          'conditions' => array("Grupotarefa.id = " . $this->request->data['Grupotarefa']['GRUPO']),
          'contain' => array('GrupotarefaItem')
        ));

        $this->loadModel('Subtarefa');
        $options = array();
        if(sizeof($grp['GrupotarefaItem']) >= 1){
          foreach ($grp['GrupotarefaItem'] as $item) {
            array_push($options, array('Subtarefa' => array(
              $this->params['url']['attribute'] => $this->params['url']['id'],
              'servico_id' => $this->params['url']['servico'],
              'descricao' => $item['descricao'],
              'user_id' => $this->Session->read('User.uid'),
              'dt_prevista' => date('d-m-Y', strtotime('+' . $item['duracao'] . 'day', strtotime('now'))),
              'marcador' => $grp['Grupotarefa']['marcador'],
              'check' => 2
            )));
          }
          $this->Subtarefa->saveAll($options);
          $this->Session->setFlash('Grupo de tarefas atribuído com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
          return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => 'view', $this->params['url']['id'] ));
        }
        else{
          $this->Session->setFlash('Esse Grupo de tarefas  ainda não possui nenhuma tarefa cadastrada!', 'alert-box', array ('class' => 'alert alert-danger'));
          return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => 'view', $this->params['url']['id'] ));
        }
    }
  }
}

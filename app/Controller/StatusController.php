<?php class StatusController extends AppController {

/**
 * index method
 *
 * @return void
 */
  public function index() {
    $this->Status->Behaviors->load('Containable');
    $this->Status->contain();

    $this->set('status', $this->Status->find('all', array('order' => array('Status.tipo'))));
  }

  /**
  * returns a list of statuses in JSON format
  */
  public function json(){
    $this->layout = null;
    $this->autoRender = false;
    return json_encode(
            $this->Status->find('list', array('conditions' => array('Status.tipo' => $this->params['url']['tipo']), 'fields' => array('Status.id', 'Status.nome'))));
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function view($id = null) {
    if (!$this->Status->exists($id)) {
      throw new NotFoundException(__('Status Inválido'));
    }
    $options = array('conditions' => array('Status.' . $this->Status->primaryKey => $id));
    $this->set('status', $this->Status->find('first', $options));
  }

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if ($this->request->is('post')) {
      $this->Status->create();
      if ($this->Status->save($this->request->data)) {
        $this->Session->setFlash('Status criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('O Status não foi criado.', 'alert-box', array ('class' => 'alert alert-danger'));
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
    if (!$this->Status->exists($id)) {
      throw new NotFoundException(__('Invalid Status'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Status->save($this->request->data)) {
        $this->Session->setFlash('Status atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('Não foi possível atualizar o Status.', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Status.' . $this->Status->primaryKey => $id));
      $this->request->data = $this->Status->find('first', $options);
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
    $this->Status->id = $id;
    if (!$this->Status->exists()) {
      throw new NotFoundException(__('Status inválido'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Status->delete()) {
      $this->Session->setFlash('O Status com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
    } else {
      $this->Session->setFlash('Não foi possível remover o Status.', 'alert-box', array ('class' => 'alert alert-danger'));
    }
    return $this->redirect(array('action' => 'index'));
  }
}

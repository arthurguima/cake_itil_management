<?php class NotesController extends AppController {

/**
 * index method
 *
 * @return void
 */
  public function index() {
    $this->Note->recursive = 0;
    $this->set('notes', $this->paginate());
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function view($id = null) {
    if (!$this->Note->exists($id)) {
      throw new NotFoundException(__('Note Inválido.'));
    }
    $this->set('note', $this->Note->find('first', $options));
  }

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if ($this->request->is('post')) {
      $this->Note->create();
      if ($this->Note->save($this->request->data)) {
        $this->Session->setFlash('Note Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
          return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
      } else {
        $this->Session->setFlash('Não foi possível criar o novo note .', 'alert-box', array ('class' => 'alert alert-danger'));
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
    if($this->params['url']['popup'] == 'true'){  $this->layout = false; }
    if (!$id) { throw new NotFoundException(__('Note de Contrato Inválido'));}

    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Note->save($this->request->data)) {
        $this->Session->setFlash('Note de Contrato atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
          return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
      } else {
        $this->Session->setFlash('Não foi possível atualizar o .', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Note.' . $this->Note->primaryKey => $id));
      $this->request->data = $this->Note->find('first', $options);
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
    $_id = $this->Note->_id;
    $this->Note->id = $id;

    if (!$this->Note->exists()) {
      throw new NotFoundException(__('Note inválido'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Note->delete()) {
      $this->Session->setFlash('O Note de  com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
    } else {
      $this->Session->setFlash('O Note de  com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
    }
    return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
  }

}

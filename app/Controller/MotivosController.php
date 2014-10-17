<?php class MotivosController extends AppController {

/**
 * index method
 *
 * @return void
 */
  public function index() {
    $this->Motivo->recursive = 0;
    $this->set('motivos', $this->paginate());
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function view($id = null) {
    if (!$this->Motivo->exists($id)) {
      throw new NotFoundException(__('Motivo Inválido.'));
    }
    $this->set('motivo', $this->Motivo->find('first', $options));
  }

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if ($this->request->is('post')) {
      $this->Motivo->create();
      if ($this->Motivo->save($this->request->data)) {
        $this->Session->setFlash('Motivo  Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('controller' =>  'motivos', 'action' => 'index' ));
      } else {
        $this->Session->setFlash('Não foi possível criar o novo motivo contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
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
    if (!$id) { throw new NotFoundException(__('Motivo  Inválido'));}

    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Motivo->save($this->request->data)) {
        $this->Session->setFlash('Motivo  atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('controller' =>  'motivos', 'action' => 'index' ));
      } else {
        $this->Session->setFlash('Não foi possível atualizar o contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Motivo.' . $this->Motivo->primaryKey => $id));
      $this->request->data = $this->Motivo->find('first', $options);
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
    $contrato_id = $this->Motivo->contrato_id;
    $this->Motivo->id = $id;

    if (!$this->Motivo->exists()) {
      throw new NotFoundException(__('Motivo inválido'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Motivo->delete()) {
      $this->Session->setFlash('O Motivo  com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
    } else {
      $this->Session->setFlash('O Motivo  com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
    }
    return $this->redirect(array('controller' =>  'motivos', 'action' => 'index' ));
  }
}

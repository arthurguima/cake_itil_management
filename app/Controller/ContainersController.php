<?php class ContainersController extends AppController {

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if ($this->request->is('post')) {
      $this->Container->create();
      if ($this->Container->save($this->request->data)) {
        $this->Session->setFlash('Container Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
      } else {
        $this->Session->setFlash('Não foi possível criar o novo container.', 'alert-box', array ('class' => 'alert alert-danger'));
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
    if (!$id) { throw new NotFoundException(__('Container  Inválido'));}

    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Container->save($this->request->data)) {
        $this->Session->setFlash('Container  atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
      } else {
        $this->Session->setFlash('Não foi possível atualizar o contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Container.' . $this->Container->primaryKey => $id));
      $this->request->data = $this->Container->find('first', $options);
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
    $this->Container->id = $id;

    if (!$this->Container->exists()) {
      throw new NotFoundException(__('Container inválido'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Container->delete()) {
      $this->Session->setFlash('O Container  com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
    } else {
      $this->Session->setFlash('O Container  com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
    }
    return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
  }
}

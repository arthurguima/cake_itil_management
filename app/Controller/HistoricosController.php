<?php class HistoricosController extends AppController {

/**
 * index method
 *
 * @return void
 */
  public function index() {
    $this->Historico->recursive = 0;
    $this->set('historicos', $this->paginate());
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function view($id = null) {
    if (!$this->Historico->exists($id)) {
      throw new NotFoundException(__('Historico Inválido.'));
    }
    $this->set('historico', $this->Historico->find('first', $options));
  }

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if ($this->request->is('post')) {
      $this->Historico->create();
      if ($this->Historico->save($this->request->data)) {
        $this->Session->setFlash('Historico Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
      } else {
        $this->Session->setFlash('Não foi possível criar o novo historico .', 'alert-box', array ('class' => 'alert alert-danger'));
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
    if (!$id) { throw new NotFoundException(__('Historico de Contrato Inválido'));}

    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Historico->save($this->request->data)) {
        $this->Session->setFlash('Historico de Contrato atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
      } else {
        $this->Session->setFlash('Não foi possível atualizar o .', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Historico.' . $this->Historico->primaryKey => $id));
      $this->request->data = $this->Historico->find('first', $options);
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
    $_id = $this->Historico->_id;
    $this->Historico->id = $id;

    if (!$this->Historico->exists()) {
      throw new NotFoundException(__('Historico inválido'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Historico->delete()) {
      $this->Session->setFlash('O Historico de  com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
    } else {
      $this->Session->setFlash('O Historico de  com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
    }
    return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
  }
}

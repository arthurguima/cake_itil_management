<?php class AditivosController extends AppController {

/**
 * index method
 *
 * @return void
 */
  public function index() {
    $this->Aditivo->recursive = 0;
    $this->set('aditivos', $this->paginate());
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function view($id = null) {
    if (!$id) { throw new NotFoundException(__('Aditivo Inválido')); }
    $aditivo = $this->Aditivo->findById($id);

    if (!$aditivo) { throw new NotFoundException(__('Aditivo Inválido'));}
    $this->set('aditivo', $aditivo);
  }

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if ($this->request->is('post')) {
      $this->Aditivo->create();
      if ($this->Aditivo->save($this->request->data)) {
        $this->Session->setFlash('Aditivo Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('controller' => 'contratos', 'action' => $this->params['url']['action'], $this->params['url']['contrato'] ));
      } else {
        $this->Session->setFlash('Não foi possível criar o novo aditivo.', 'alert-box', array ('class' => 'alert alert-danger'));
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
    if (!$id) { throw new NotFoundException(__('Aditivo de Contrato Inválido'));}

    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Aditivo->save($this->request->data)) {
        $this->Session->setFlash('Aditivo de Contrato atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('controller' => 'aditivos', 'action' => 'view', $id ));
      } else {
        $this->Session->setFlash('Não foi possível atualizar o aditivo.', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Aditivo.' . $this->Aditivo->primaryKey => $id));
      $this->request->data = $this->Aditivo->find('first', $options);
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
    $contrato_id = $this->Aditivo->contrato_id;
    $this->Aditivo->id = $id;

    if (!$this->Aditivo->exists()) {
      throw new NotFoundException(__('Aditivo inválido'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Aditivo->delete()) {
      $this->Session->setFlash('O Aditivo  com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
    } else {
      $this->Session->setFlash('O Aditivo  com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
    }
    return $this->redirect(array('controller' => 'contratos', 'action' => 'view', $this->request->data['Aditivo']['contrato_id'] ));
  }
}

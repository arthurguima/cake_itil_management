<?php class GrupotarefaItemsController extends AppController {

/**
 * index method
 *
 * @return void
 */
  public function index() {
    $this->GrupotarefaItem->recursive = 0;
    $this->set('grupotarefasItems', $this->paginate());
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function view($id = null) {
    if (!$this->GrupotarefaItem->exists($id)) {
      throw new NotFoundException(__('GrupotarefaItem Inválido.'));
    }
    $this->set('grupotarefasItem', $this->GrupotarefaItem->find('first', $options));
  }

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if ($this->request->is('post')) {
      $this->GrupotarefaItem->create();
      if ($this->GrupotarefaItem->save($this->request->data)) {
        $this->Session->setFlash('GrupotarefaItem Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
          return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
      } else {
        $this->Session->setFlash('Não foi possível criar o novo grupotarefasItem .', 'alert-box', array ('class' => 'alert alert-danger'));
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
    if (!$id) { throw new NotFoundException(__('Item de Grupo de tarefa Inválido'));}

    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->GrupotarefaItem->save($this->request->data)) {
        $this->Session->setFlash('Item de Grupo de tarefa atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
          return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
      } else {
        $this->Session->setFlash('Não foi possível atualizar o .', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('GrupotarefaItem.' . $this->GrupotarefaItem->primaryKey => $id));
      $this->request->data = $this->GrupotarefaItem->find('first', $options);
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
    $_id = $this->GrupotarefaItem->_id;
    $this->GrupotarefaItem->id = $id;

    if (!$this->GrupotarefaItem->exists()) {
      throw new NotFoundException(__('GrupotarefaItem inválido'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->GrupotarefaItem->delete()) {
      $this->Session->setFlash('O GrupotarefaItem de  com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
    } else {
      $this->Session->setFlash('O GrupotarefaItem de  com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
    }
    return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
  }

}

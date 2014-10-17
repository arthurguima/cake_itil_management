<?php class ClientesController extends AppController {

/**
 * index method
 *
 * @return void
 */
  public function index() {
    $this->Cliente->recursive = 0;
    $this->set('clientes', $this->paginate());
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function view($id = null) {
    if (!$this->Cliente->exists($id)) {
      throw new NotFoundException(__('Invalid cliente'));
    }
    $options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
    $this->set('cliente', $this->Cliente->find('first', $options));
  }

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if ($this->request->is('post')) {
      $this->Cliente->create();
      if ($this->Cliente->save($this->request->data)) {
        $this->Session->setFlash('Cliente Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('Não foi possível criar o novo cliente.', 'alert-box', array ('class' => 'alert alert-danger'));
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
    if (!$this->Cliente->exists($id)) {
      throw new NotFoundException(__('Invalid cliente'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Cliente->save($this->request->data)) {
        $this->Session->setFlash('Cliente atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('Não foi possível atualizar o cliente.', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
      $this->request->data = $this->Cliente->find('first', $options);
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
    $this->Cliente->id = $id;
    if (!$this->Cliente->exists()) {
      throw new NotFoundException(__('Invalid cliente'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Cliente->delete()) {
      $this->Session->setFlash('O cliente foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
    } else {
      $this->Session->setFlash('O cliente não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
    }
    return $this->redirect(array('action' => 'index'));
  }
}

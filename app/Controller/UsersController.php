<?php class UsersController extends AppController {

  public function index(){
    $this->set('users', $this->User->find('all'));
    $this->User->recursive = 1;
  }

  public function view($id = null){
  if (!$this->User->exists($id)) {
      throw new NotFoundException(__('User Inválido'));
    }
    $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
    $this->set('user', $this->User->find('first', $options));
  }

  public function edit($id = null){
    if (!$id) { throw new NotFoundException(__('Usuário Inválido'));}

    $sistema = $this->User->findById($id);
    if (!$sistema){ throw new NotFoundException(__('Usuário Inválido'));}

    if ($this->request->is(array('User', 'put'))) {
        $this->User->id = $id;
        if ($this->User->save($this->request->data)) {
            $this->Session->setFlash('User atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível atualizar o usuário.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    if (!$this->request->data) {
        $this->request->data = $sistema;
    }

    /* Relacionamentos */
      $clientes = $this->User->Cliente->find('list', array('fields' => array('Cliente.id', 'Cliente.sigla')));
      $this->set(compact('clientes'));
  }

  public function add() {

    if ($this->request->is('post')) {

      $this->User->create();
      if ($this->User->save($this->request->data)) {
        $this->Session->setFlash('User criado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
          return $this->redirect(array('action' => 'index'));
      }
      $this->Session->setFlash('Não foi possível criar o novo usuário.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    /* Relacionamentos */
      $clientes = $this->User->Cliente->find('list', array('fields' => array('Cliente.id', 'Cliente.sigla')));
      $this->set(compact('clientes'));
  }

  public function delete($id) {
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->User->delete($id)) {
        $this->Session->setFlash('O usuário com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
        return $this->redirect(array('action' => 'index'));
    }
  }


  public function json(){
    $this->layout = null;
    //$this->set('users', $this->User->find('all'));
    $this->User->recursive = 0;
    $this->User->Behaviors->load('Containable');

    $users = $this->User->find('all', array(
      'fields' => array('User.id', 'User.nome'),
      'conditions' => array("User.nome LIKE '%" . $this->params['url']['q'] . "%'"),
      'contain' => array()
    ));
    //debug($users);
   $users = str_replace("{\"User\":", "", json_encode($users));
    $users = str_replace("}}", "}", $users);
    $users = str_replace("nome", "text", $users);

    $this->set("users",   $users);
  }
}?>

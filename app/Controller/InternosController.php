<?php class InternosController extends AppController {
  public $helpers = array('Html', 'Form');

  public function index(){
    $this->set('internos', $this->Interno->find('all'));
    $this->Interno->recursive = 1;
  }

  public function view($id = null){
  if (!$this->Interno->exists($id)) {
      throw new NotFoundException(__('Sistema Interno Inválido'));
    }
    $options = array('conditions' => array('Interno.' . $this->Interno->primaryKey => $id));
    $this->set('interno', $this->Interno->find('first', $options));
  }

  public function edit($id = null){
    if (!$id) { throw new NotFoundException(__('Sistema Interno Inválido'));}

    $sistema = $this->Interno->findById($id);
    if (!$sistema){ throw new NotFoundException(__('Sistema Interno Inválido'));}

    if ($this->request->is(array('Interno', 'put'))) {
        $this->Interno->id = $id;
        if ($this->Interno->save($this->request->data)) {
            $this->Session->setFlash('Sistema Interno atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível atualizar o sistema interno.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    if (!$this->request->data) {
        $this->request->data = $sistema;
    }
  }

  public function add() {

    if ($this->request->is('post')) {

      $this->Interno->create();
      if ($this->Interno->save($this->request->data)) {
        $this->Session->setFlash('sistema interno criado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
          return $this->redirect(array('action' => 'index'));
      }
      $this->Session->setFlash('Não foi possível criar o novo sistema interno.', 'alert-box', array ('class' => 'alert alert-danger'));
    }
  }

  public function delete($id) {
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->Interno->delete($id)) {
        $this->Session->setFlash('O sistema interno com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
        return $this->redirect(array('action' => 'index'));
    }
  }
}?>

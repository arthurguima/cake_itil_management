<?php class ProcedimentosController extends AppController {
  public $helpers = array('Html', 'Form');

  public function index(){
    $this->set('procedimentos', $this->Procedimento->find('all'));
    $this->Procedimento->recursive = 1;
  }

  public function view($id = null){
  if (!$this->Procedimento->exists($id)) {
      throw new NotFoundException(__('Procedimento Inválido'));
    }
    $options = array('conditions' => array('Procedimento.' . $this->Procedimento->primaryKey => $id));
    $this->set('procedimento', $this->Procedimento->find('first', $options));
  }

  public function edit($id = null){
    if (!$id) { throw new NotFoundException(__('Procedimento Inválido'));}

    $sistema = $this->Procedimento->findById($id);
    if (!$sistema){ throw new NotFoundException(__('Procedimento Inválido'));}

    if ($this->request->is(array('Procedimento', 'put'))) {
        $this->Procedimento->id = $id;
        if ($this->Procedimento->save($this->request->data)) {
            $this->Session->setFlash('Procedimento atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível atualizar o procedimento.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    if (!$this->request->data) {
        $this->request->data = $sistema;
    }
  }

  public function add() {

    if ($this->request->is('post')) {

      $this->Procedimento->create();
      if ($this->Procedimento->save($this->request->data)) {
        $this->Session->setFlash('Procedimento criado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
          return $this->redirect(array('action' => 'index'));
      }
      $this->Session->setFlash('Não foi possível criar o novo sistema procedimento.', 'alert-box', array ('class' => 'alert alert-danger'));
    }
  }

  public function delete($id) {
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->Procedimento->delete($id)) {
        $this->Session->setFlash('O procedimento com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
        return $this->redirect(array('action' => 'index'));
    }
  }
}?>

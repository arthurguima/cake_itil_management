<?php class ResponsabilidadesController extends AppController {
  public $helpers = array('Html', 'Form');

  public function index(){
    $this->set('responsabilidades', $this->Responsabilidade->find('all'));
    $this->Responsabilidade->recursive = 1;
  }

  public function view($id = null){
  if (!$this->Responsabilidade->exists($id)) {
      throw new NotFoundException(__('Responsabilidade Inválida'));
    }
    $options = array('conditions' => array('Responsabilidade.' . $this->Responsabilidade->primaryKey => $id));
    $this->set('responsabilidade', $this->Responsabilidade->find('first', $options));
  }

  public function edit($id = null){
    if (!$id) { throw new NotFoundException(__('Responsabilidade Inválida'));}

    $sistema = $this->Responsabilidade->findById($id);
    if (!$sistema){ throw new NotFoundException(__('Responsabilidade Inválida'));}

    if ($this->request->is(array('Responsabilidade', 'put'))) {
        $this->Responsabilidade->id = $id;
        if ($this->Responsabilidade->save($this->request->data)) {
            $this->Session->setFlash('Responsabilidade atualizada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível atualizar a responsabilidade.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    if (!$this->request->data) {
        $this->request->data = $sistema;
    }
  }

  public function add() {

    if ($this->request->is('post')) {

      $this->Responsabilidade->create();
      if ($this->Responsabilidade->save($this->request->data)) {
        $this->Session->setFlash('Responsabilidade criada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
          return $this->redirect(array('action' => 'index'));
      }
      $this->Session->setFlash('Não foi possível criar a nova responsabilidade.', 'alert-box', array ('class' => 'alert alert-danger'));
    }
  }

  public function delete($id) {
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->Responsabilidade->delete($id)) {
        $this->Session->setFlash('A responsabilidade com id: %s foi removida.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
        return $this->redirect(array('action' => 'index'));
    }
  }
}?>

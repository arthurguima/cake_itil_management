<?php class DependenciasController extends AppController {
  public $helpers = array('Html', 'Form');

  public function index(){
    $this->set('dependencias', $this->Dependencia->find('all'));
  }

  public function view($id = null){
    if (!$id) { throw new NotFoundException(__('Dependência  Inválida')); }
    $dependencia = $this->Dependencia->findById($id);

    if (!$dependencia) { throw new NotFoundException(__('Dependência  Inválida'));}
    $this->set('dependencia', $dependencia);
  }

  public function edit($id = null){
    if (!$id) { throw new NotFoundException(__('Dependência  Inválida'));}

    $dependencia = $this->Dependencia->findById($id);
    if (!$dependencia){ throw new NotFoundException(__('Dependência  Inválida'));}

    if ($this->request->is(array('Dependencia ', 'put'))) {
        $this->Dependencia->id = $id;
        if ($this->Dependencia->save($this->request->data)) {
            $this->Session->setFlash('Dependência  atualizada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
            if ($this->params['url']['controller'] == NULL):
              return $this->redirect(array('controller' => 'dependencias', 'action' => 'index'));
            else:
              return $this->redirect(array('controller' => $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
            endif;
        }
        $this->Session->setFlash('Não foi possível atualizar a dependência.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    if (!$this->request->data) {
        $this->request->data = $dependencia;
    }
  }

  public function add() {
    if ($this->request->is('post')) {
      $this->Dependencia->create();
      if ($this->Dependencia->save($this->request->data)) {
        $this->Session->setFlash('Dependência  criada com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
          return $this->redirect(array('action' => 'index'));
      }
      $this->Session->setFlash('Não foi possível criar a nova Dependência.', 'alert-box', array ('class' => 'alert alert-danger'));
    }
  }

  public function delete($id) {
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->Dependencia->delete($id)) {
        $this->Session->setFlash('A dependência com id: %s foi removida.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
        return $this->redirect(array('action' => 'index'));
    }
  }
}?>

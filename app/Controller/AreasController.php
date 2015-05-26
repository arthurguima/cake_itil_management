<?php class AreasController extends AppController {
  public $helpers = array('Html', 'Form');

  public function index(){
    $this->Area->Behaviors->load('Containable');
    $this->Area->contain('Cliente');

    $this->set('areas', $this->Area->find('all'));
  }

  public function view($id = null){
    if (!$id) { throw new NotFoundException(__('Área  Inválida')); }
    $area = $this->Area->findById($id);

    if (!$area) { throw new NotFoundException(__('Área  Inválida'));}
    $this->set('area', $area);
  }

  public function edit($id = null){
    if (!$id) { throw new NotFoundException(__('Área  Inválida'));}

    $area = $this->Area->findById($id);
    if (!$area){ throw new NotFoundException(__('Área  Inválida'));}

    if ($this->request->is(array('Area ', 'put'))) {
        $this->Area->id = $id;
        if ($this->Area->save($this->request->data)) {
            $this->Session->setFlash('Área  atualizada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
            if ($this->params['url']['controller'] == NULL):
              return $this->redirect(array('controller' => 'areas', 'action' => 'index'));
            else:
              return $this->redirect(array('controller' => $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
            endif;
        }
        $this->Session->setFlash('Não foi possível atualizar a área.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    if (!$this->request->data) {
        $this->request->data = $area;
    }

    /* Relacionamentos */
      $clientes = $this->Area->Cliente->find('list', array('fields' => array('Cliente.id', 'Cliente.sigla')));
      $this->set(compact('clientes'));
  }

  public function add() {
    if ($this->request->is('post')) {
      $this->Area->create();
      if ($this->Area->save($this->request->data)) {
        $this->Session->setFlash('Área  criada com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        $this->redirect(array('action' => 'view', $this->Area->id));
      }
      $this->Session->setFlash('Não foi possível criar a nova Área.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    /* Relacionamentos */
      $clientes = $this->Area->Cliente->find('list', array('fields' => array('Cliente.id', 'Cliente.sigla')));
      $this->set(compact('clientes'));
  }

  public function delete($id) {
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->Area->delete($id)) {
        $this->Session->setFlash('A área com id: %s foi removida.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
        return $this->redirect(array('action' => 'index'));
    }
  }
}?>

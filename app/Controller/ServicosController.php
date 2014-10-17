<?php class ServicosController extends AppController {
  public $helpers = array('Html', 'Form');

  public function ajax(){
    $this->layout = "ajax";
    /* Lista de Servicos */
    $this->loadModel('Servico');
    $this->set('servicos', $this->Servico->find('all'));
    $this->Servico->recursive = 1;
  }


  public function index(){
    $this->set('servicos', $this->Servico->find('all'));
    $this->Servico->recursive = 1;
  }

  public function view($id = null){
    if (!$id) { throw new NotFoundException(__('Serviço Inválido')); }
    $sistema = $this->Servico->findById($id);

    if (!$sistema) { throw new NotFoundException(__('Serviço Inválido'));}
    $this->set('Servico', $sistema);
    $this->Servico->recursive = 1;
  }

  public function edit($id = null){
    if (!$id) { throw new NotFoundException(__('Serviço Inválido'));}

    $sistema = $this->Servico->findById($id);
    if (!$sistema){ throw new NotFoundException(__('Serviço Inválido'));}

    if ($this->request->is(array('Servico', 'put'))) {
        $this->Servico->id = $id;
        if ($this->Servico->save($this->request->data)) {
            $this->Session->setFlash('Serviço atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível atualizar o serviço.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    if (!$this->request->data) {
        $this->request->data = $sistema;
    }

    /* -- Relacionamentos --*/
    $this->set('areas',
                $this->Servico->Area->find('list', array('fields' => array('Area.id', 'Area.nome', 'Area.sigla'))));

    $this->set('dependencias',
                $this->Servico->Dependencia->find('list', array('fields' => array('Dependencia.id', 'Dependencia.nome'))));
  }

  public function add() {

    if ($this->request->is('post')) {

      $this->Servico->create();
      if ($this->Servico->save($this->request->data)) {
        $this->Session->setFlash('serviço criado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
          return $this->redirect(array('action' => 'index'));
      }
      $this->Session->setFlash('Não foi possível criar o novo serviço.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    /* -- Relacionamentos --*/
    $this->set('areas',
                $this->Servico->Area->find('list', array('fields' => array('Area.id', 'Area.nome', 'Area.sigla'))));

    $this->set('dependencias',
                $this->Servico->Dependencia->find('list', array('fields' => array('Dependencia.id', 'Dependencia.nome'))));
  }

  public function delete($id) {
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->Servico->delete($id)) {
        $this->Session->setFlash('O serviço com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
        return $this->redirect(array('action' => 'index'));
    }
  }
}?>

<?php class ServicosController extends AppController {
  public $helpers = array('Html', 'Form');

  public function index(){
    // Add filter
    $this->Filter->addFilters(
      array(
        'Cliente' => array(
          'Servico.cliente_id' => array(
            'select' => $this->Filter->select('Cliente', $this->Servico->Cliente->find('list', array('fields' => array('Cliente.id', 'Cliente.sigla'),
            'conditions'=> array("Cliente.id" . $_SESSION['User']['clientes']))))
          )
        )
    ));
    $conditions = $this->Filter->getConditions();
    $conditions = $conditions + array(999 => array("Servico.cliente_id" . $_SESSION['User']['clientes']));

    $this->Servico->Behaviors->load('Containable');//Carrega apenas o Relacionamento com a área (otimização)
    //$this->Servico->contain('Area');//Carrega apenas o Relacionamento com a área (otimização)
    $this->Filter->setPaginate('conditions', $conditions);
    $this->Filter->setPaginate('limit', 1200);
    $this->Servico->contain('Cliente','Area','Container');

    $this->set('servicos', $this->paginate());
  }

  public function view($id = null){
    if (!$id) { throw new NotFoundException(__('Serviço Inválido')); }
    $sistema = $this->Servico->findById($id);

    if (!$sistema) { throw new NotFoundException(__('Serviço Inválido'));}
    $this->set('Servico', $sistema);
    $this->Servico->recursive = 1;
  }

  public function edit($id = null){
        debug($_SESSION['User']['uid']);
    $this->Servico->Behaviors->load('Containable');//Carrega apenas o Relacionamento com a área (otimização)
    $this->Servico->contain('Area', 'Dependencia');

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

    $this->set('clientes',
                $this->Servico->Cliente->find('list', array('fields' => array('Cliente.id', 'Cliente.nome'))));

    $this->set('users', $this->Servico->User->find('list', array('fields' => array('User.id', 'User.nome'))));
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

    $this->set('clientes',
                $this->Servico->Cliente->find('list', array('fields' => array('Cliente.id', 'Cliente.nome'))));

    $this->set('users', $this->Servico->User->find('list', array('fields' => array('User.id', 'User.nome'))));
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

  public function containersonline($id = null){
    $this->layout = "ajax";
    /* Lista de Servicos */
    $this->Servico->Behaviors->load('Containable');//Carrega apenas o Relacionamento com a área (otimização)
    $this->Servico->contain('Container');

    if (!$id) { throw new NotFoundException(__('Serviço Inválido')); }
    $sistema = $this->Servico->findById($id);

    if (!$sistema) { throw new NotFoundException(__('Serviço Inválido'));}
    $this->set('servico', $sistema);
  }

  public function ajax(){
    $this->layout = "ajax";
    /* Lista de Servicos */
    $this->loadModel('Servico');
    $this->Servico->Behaviors->load('Containable');

    $this->set('clientes', $this->ServicoPorCliente(
      $this->Servico->find('all',array(
        'contain' => array('Cliente'=> array()),
        'conditions'=> array("Servico.cliente_id " . $_SESSION['User']['clientes'])
      )
    )));
  }

  /* Funções de Apoio */
  private function ServicoPorCliente($servicos){
    $clientes = array();
    foreach ($servicos as $ser){
      $clientes[$ser['Cliente']['sigla']][] = $ser;
    }

    return $clientes;
  }
}?>

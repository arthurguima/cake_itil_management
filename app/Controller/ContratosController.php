<?php class ContratosController extends AppController {
  public $helpers = array('Html', 'Form', 'Times');

  public function index(){
    $this->Contrato->Behaviors->load('Containable');// (otimização)
    $this->Contrato->contain('Cliente');// (otimização)

    $this->set('contratos', $this->Contrato->find('all'));
  }

  public function view($id = null){
    if (!$id) { throw new NotFoundException(__('Contrato Inválido')); }
    $this->Contrato->Behaviors->attach('Containable');

    $this->set('contrato', $this->Contrato->find('first', array(
      'conditions' => array('id' => $id),
      'contain' => array(
        'Aditivo' => array(),
        'Item' => array(),
        'Regra' => array(
          'Servico' => array()
        ),
        'Indicadore' => array(
          'Regra' => array(
            'Servico' => array()
          ),
        ),
      )
    )));

    //if (!$contrato) { throw new NotFoundException(__('Contrato Inválido'));}
  }

  public function edit($id = null){
    if (!$id) { throw new NotFoundException(__('Contrato Inválido'));}

    $contrato = $this->Contrato->findById($id);
    if (!$contrato){ throw new NotFoundException(__('Contrato Inválido'));}

    if ($this->request->is(array('contrato', 'put'))) {
        $this->Contrato->id = $id;
        if ($this->Contrato->save($this->request->data)) {
            $this->Session->setFlash('Contrato atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
            if (!isset($this->params['url']['controller'])):
              return $this->redirect(array('controller' => 'contratos','action' => 'index'));
            else:
              return $this->redirect(array('controller' => $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
            endif;
        }
        $this->Session->setFlash('Não foi possível atualizar o contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    if (!$this->request->data) {
        $this->request->data = $contrato;
    }

    /* Relacionamentos */
      $clientes = $this->Contrato->Cliente->find('list', array('fields' => array('Cliente.id', 'Cliente.sigla')));
      $this->set(compact('clientes'));
  }

  public function add() {
    if ($this->request->is('post')) {
      $this->Contrato->create();
      if ($this->Contrato->save($this->request->data)) {
        $this->Session->setFlash('Contrato Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
          return $this->redirect(array('controller' => 'contratos', 'action' => 'index'));
      }
      $this->Session->setFlash('Não foi possível criar o novo contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    /* Relacionamentos */
      $clientes = $this->Contrato->Cliente->find('list', array('fields' => array('Cliente.id', 'Cliente.sigla')));
      $this->set(compact('clientes'));
  }

  public function delete($id) {
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->Contrato->delete($id)) {
        $this->Session->setFlash('O Contrato com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
        return $this->redirect(array('action' => 'index'));
    }
  }

  /**
  * returns a list of itens filtered by cliente
  */
  public function optionlist(){
    $this->layout = null;
    //$this->autoRender = false;

    $this->loadModel('Cliente');
    $this->Cliente->Behaviors->attach('Containable');
    $cliente = $this->Cliente->find('first', array(
      'conditions' => array('Cliente.id' => $this->params['url']['cliente']),
      'contain'=> array(
        'Contrato' => array('fields' => array('Contrato.id', 'Contrato.numero'))
      )
    ));
    //$this->Demanda->recursive = -1;
    $this->set('contratos', $cliente['Contrato']);
  }
}?>

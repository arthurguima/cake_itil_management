<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'Encryption', array('file' => 'Encryption.php'));

class SubtarefasController extends AppController {
/**
 * index method
 *
 * @return void
 */
  public function index() {
    $this->Subtarefa->recursive = 0;
    $this->set('subtarefas', $this->paginate());
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function view($id = null) {
    if (!$this->Subtarefa->exists($id)) {
      throw new NotFoundException(__('Subtarefa Inválida.'));
    }
    $this->set('subtarefa', $this->Subtarefa->find('first', $options));
  }

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if($this->params['url']['popup'] == 'true'){  $this->layout = false; }
    $converter = new Encryption;

    if ($this->request->is('post')) {
      $this->Subtarefa->create();
      if ($this->Subtarefa->save($this->request->data)) {
        $this->Session->setFlash('Subtarefa Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));

        $this->mail(array(
          'auth_pass' => $converter->decode($_SESSION['User']['auth_pass']),
          'from' => explode('@', $_SESSION['email']),
          'to' => $this->request->data['Subtarefa']['user_id'],
          'servico_id' => $this->request->data['Subtarefa']['servico_id'],
          'subject' => "[SGS] Uma nova tarefa foi atribuída para o dia '" . $this->request->data['Subtarefa']['dt_prevista']. "'!",
          'tipo' => "Concluir Tarefa",
          'data' => $this->request->data['Subtarefa']['dt_prevista'],
          'mensagem' => $this->request->data['Subtarefa']['descricao'],
        ));

        if(isset($this->params['url']['popup']) && $this->params['url']['popup'] == 'true'){
          return $this->redirect(array('controller' =>  "subtarefas", 'action' => 'popup',
           '?' => array('controller' => $this->params['url']['controller'], 'id' => $this->params['url']['id']) ));
        }
        else{
          if(isset($this->params['url']['controller']))
            return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
          else {
            return $this->redirect(Router::url('/', true) . "index.php");
          }
        }
      } else {
        $this->Session->setFlash('Não foi possível criar a nova subtarefa .', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    }

    /* Relacionamentos */
      $users = $this->Subtarefa->User->find('list', array(
        'fields' => array('User.id', 'User.nome'),
        'conditions' => array("User.id = " . $_SESSION['User']['uid'])
      ));
      $this->set(compact('users'));

      $servicos = $this->Subtarefa->Servico->find('list', array(
        'fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'),
        'conditions' => ("Servico.cliente_id" . $_SESSION['User']['clientes'])));
      $this->set(compact('servicos'));
  }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function edit($id = null) {
    if($this->params['url']['popup'] == 'true'){  $this->layout = false; }
    if (!$id) { throw new NotFoundException(__('Subtarefa de Contrato Inválida'));}

    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Subtarefa->save($this->request->data)) {
        $this->Session->setFlash('Subtarefa atualizada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        if(isset($this->params['url']['popup']) && $this->params['url']['popup'] == 'true'){
          return $this->redirect(array('controller' =>  "subtarefas", 'action' => 'popup',
           '?' => array('controller' => $this->params['url']['controller'], 'id' => $this->params['url']['id']) ));
        }
        else{
          if(isset($this->params['url']['controller']))
            return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
          else {
            return $this->redirect(Router::url('/', true) . "index.php");
          }
        }
      } else {
        $this->Session->setFlash('Não foi possível atualizar a Subtarefa .', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Subtarefa.' . $this->Subtarefa->primaryKey => $id));
      $this->request->data = $this->Subtarefa->find('first', $options);
    }

    /* Relacionamentos */
    $users = $this->Subtarefa->User->find('list', array(
      'fields' => array('User.id', 'User.nome'),
      'conditions' => array("User.id = " . $this->request->data['User']['id'])
    ));
    $this->set(compact('users'));

      $servicos = $this->Subtarefa->Servico->find('list', array(
        'fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'),
        'conditions' => ("Servico.cliente_id" . $_SESSION['User']['clientes'])));
      $this->set(compact('servicos'));
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
    $_id = $this->Subtarefa->_id;
    $this->Subtarefa->id = $id;

    if (!$this->Subtarefa->exists()) {
      throw new NotFoundException(__('Subtarefa inválida'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Subtarefa->delete()) {
      $this->Session->setFlash('O Subtarefa com id: %s foi removida.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
    } else {
      $this->Session->setFlash('O Subtarefa com id: %s  não foi removida.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
    }
    if(isset($this->params['url']['controller']))
      return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
    else {
      return $this->redirect(Router::url('/', true) . "index.php");
    }
  }

  /**
  * Form inline
  */
  public function ajax_edit_status(){
    $this->autoRender = false;
    $this->layout = 'ajax';

    if ($this->request->data) {
        $subtarefa = explode('-', $this->request->data('id'));
        $subtarefa = $subtarefa[1];
        $this->Subtarefa->id = $subtarefa;
        $this->Subtarefa->saveField('check', $this->request->data('check'));

        if($this->request->data('check') == 0)
          return "<span class='label label-success'>Em andamento</span>";
        elseif($this->request->data('check') == 1)
          return "<span class='label label-default'>Finalizada</span>";
        else
          return "<span class='label label-info'>Aguardando Início</span>";
    }
  }

  /**
   * popup method
   *
   * @throws NotFoundException
   * @param int id
   * @return void
   */
    public function popup($id = null) {
      $this->Subtarefa->recursive = -1;
      $this->layout = false;

      switch($this->params['url']['controller']){
        case 'demandas':
          $this->set('subtarefas', $this->Subtarefa->findAllByDemandaId( $this->params['url']['id']));
          break;
      }
    }
}

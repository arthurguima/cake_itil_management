<?php class RdmsController extends AppController {
  public $helpers = array('Html', 'Form');

  public function index(){
    // Add filter
    $this->Filter->addFilters(
      array(
        'solicitante_' => array(
          'Rdm.solicitante' => array('operator' => 'LIKE')
        ),
        'responsavel_' => array(
          'Rdm.user_id' => array(
						'select' => $this->Filter->select('Responsável', $this->Rdm->User->find('list',
									array('conditions' => array(), 'fields' => array('User.id', 'User.nome'))))
					)
        ),
        'nome_' => array(
          'Rdm.nome' => array('operator' => 'LIKE')
        ),
        'versao_' => array(
          'Rdm.versao' => array('operator' => 'LIKE')
        ),
        'servico' => array(
          'Rdm.servico_id' => array(
            'select' => $this->Filter->select('Serviço', $this->Rdm->Servico->find('list',
                  array('fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'))))
          )
        ),
        'ambiente_' => array(
          'Rdm.ambiente' => array(
            'select' => $this->Filter->select('Ambiente', array(1 => 'Homologação', 2 => 'Produção', 3 => 'Treinamento', 4 => 'Sustentação') )
          )
        ),
        'concluida_' => array(
          'Rdm.sucesso' => array(
            'select' => $this->Filter->select('Concluida', array(0 => 'Não', 1 => 'Sim', 2 => 'Cancelada', -1 => "Não preenchido") )
          )
        ),
        'tipo' => array(
          'Rdm.rdm_tipo_id' => array(
            'select' => $this->Filter->select('Tipo de RDM', $this->Rdm->RdmTipo->find('list', array('fields' => array('RdmTipo.id', 'RdmTipo.nome'))))
          )
        ),
        'numero_' => array(
          'Rdm.numero' => array('operator' => '='),
        ),
        'dtprevista' => array(
          'Rdm.dt_prevista' => array(
            'operator' => 'BETWEEN',
            'between' => array(
              'text' => ' a ',
            )
          )
        ),
        'dtexecutada' => array(
          'Rdm.dt_executada' => array(
            'operator' => 'BETWEEN',
            'between' => array(
              'text' => ' a ',
            )
          )
        )
      )
    );
    //$this->Filter->addFilters('filtro');

    // Define conditions
    $this->Filter->setPaginate('order', 'Rdm.dt_prevista DESC, Rdm.dt_executada, Rdm.modified DESC, Rdm.created DESC');
    $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
    $this->Filter->setPaginate('limit', 250);

    $this->Rdm->recursive = 0;
    $this->set('rdms', $this->paginate());
  }

  /**
   * view method
   *
   * @throws NotFoundException
   * @param int id
   * @return void
   */
    public function view($id = null) {
      if (!$this->Rdm->exists($id)) {
        throw new NotFoundException(__('Rdm Invalida'));
      }
      $this->Rdm->Behaviors->load('Containable');

      $options = array(
        'conditions' => array('Rdm.' . $this->Rdm->primaryKey => $id),
        'contain' => array(
          'Demanda' => array('Status' => array()),
          'Chamado' => array('ChamadoTipo' => array(),'Status' => array(),'User' => array()),
          'RdmTipo' => array(),
          'Servico' => array(),
          'User' => array(),
          'Historico' => array(),
          'Release' => array()
        )
      );
      $this->set('rdm', $this->Rdm->find('first', $options));
    }

  public function edit($id = null){
    if (!$id) { throw new NotFoundException(__('Rdm Inválida'));}

    $sistema = $this->Rdm->findById($id);
    if (!$sistema){ throw new NotFoundException(__('Rdm Inválida'));}

    if ($this->request->is(array('Rdm', 'put'))) {
        $this->Rdm->id = $id;
        if ($this->Rdm->save($this->request->data)) {
            $this->Session->setFlash('Rdm atualizada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
            $this->redirect(array('action' => 'view', $this->Rdm->id));
        }
        $this->Session->setFlash('Não foi possível atualizar a rdm.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    if (!$this->request->data) {
        $this->request->data = $sistema;
    }

    /* Relacionamentos */
    $users = $this->Rdm->User->find('list', array('fields' => array('User.id', 'User.nome')));
    $this->set(compact('users'));

    $this->set('demandas',
                $this->Rdm->Demanda->find('list', array(
                  'fields' => array('Demanda.id', 'Demanda.clarity_dm_id'),
                  'conditions' => array('Demanda.servico_id' => $this->data['Rdm']['servico_id']))));
    $this->set('chamados',
                $this->Rdm->Chamado->find('list', array(
                  'fields' => array('Chamado.id', 'Chamado.numero'),
                  'conditions' => array('Chamado.servico_id' => $this->data['Rdm']['servico_id']))));


    $rdmTipos = $this->Rdm->RdmTipo->find('list', array('fields' => array('RdmTipo.id', 'RdmTipo.nome')));
    $this->set(compact('rdmTipos'));
  }

  public function add() {

    if ($this->request->is('post')) {

      $this->Rdm->create();
      if ($this->Rdm->save($this->request->data)) {
        $this->Session->setFlash('Rdm criada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        $this->redirect(array('action' => 'view', $this->Rdm->id));
      }
      $this->Session->setFlash('Não foi possível criar a nova rdm.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    /* Relacionamentos */
    $servicos = $this->Rdm->Servico->find('list', array('fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia')));
    $this->set(compact('servicos'));

    $users = $this->Rdm->User->find('list', array('fields' => array('User.id', 'User.nome')));
    $this->set(compact('users'));

    $rdmTipos = $this->Rdm->RdmTipo->find('list', array('fields' => array('RdmTipo.id', 'RdmTipo.nome')));
    $this->set(compact('rdmTipos'));
  }

  public function delete($id) {
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->Rdm->delete($id)) {
        $this->Session->setFlash('A rdm com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
        return $this->redirect(array('action' => 'index'));
    }
  }

  /**
  * Form inline
  */
  public function ajax_edit_item(){
    $this->autoRender = false;
    $this->layout = 'ajax';

    if ($this->request->data) {
        $values = explode('-', $this->request->data('id'));
        $rdm = $values[2];
        $item = $values[1];

        $this->request->data['Historico']['rdm_id'] = $rdm;
        $this->request->data['Historico']['descricao'] = $item . " no SDM.";
        $this->request->data['Historico']['data'] = date("Y-m-d");
        $this->request->data['Historico']['analista'] = $this->Session->read('User.nome');

        $this->Rdm->id = $rdm;
        $this->Rdm->saveField($item, $this->request->data('check'));
        $this->Rdm->Historico->save($this->request->data);

        if($this->request->data('check') == 0):
          return "<i class='fa fa-square-o fa-undone checklist'><span>(  )</span></i>";
        else:
          return "<i class='fa fa-check-square-o fa-done checklist'><span>(OK)</span></i>";
        endif;
    }
  }

  /**
  * returns a list of rdms filtered by $servico
  */
  public function optionList(){
    $this->layout = null;
    //$this->autoRender = false;

    $this->set('rdms',
                $this->Rdm->find('list', array(
                  'fields' => array('Rdm.id', 'Rdm.numero'),
                  'conditions' => array(
                      'Rdm.servico_id' => $this->params['url']['servico'],
                      'Rdm.sucesso' => -1
                  ))));
  }

}?>

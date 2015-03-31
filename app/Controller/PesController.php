<?php class PesController extends AppController {


  public function index() {
    $this->Filter->addFilters(
      array(
        'responsavel_' => array(
          'Pe.responsavel' => array('operator' => 'LIKE')
        ),
        'status' => array(
          'Pe.status_id' => array(
            'select' => $this->Filter->select('Status', $this->Pe->Status->find('list',
                  array('conditions' => array('Status.tipo' => 4), 'fields' => array('Status.id', 'Status.nome'))))
          )
        ),
        'servico' => array(
          'Pe.servico_id' => array(
            'select' => $this->Filter->select('Serviço', $this->Pe->Servico->find('list',
                  array('fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'))))
          )
        ),
        'status_diferente' => array(
          'Pe.status_id' => array(
            'select' => $this->Filter->select('Status Diferente de', $this->Pe->Status->find('list',
                  array('conditions' => array('Status.tipo' => 4), 'fields' => array('Status.id', 'Status.nome')))),
            'operator'    => '!='
          )
        ),
        'dtinicio' => array(
          'Pe.dt_inicio' => array(
            'operator' => 'BETWEEN',
            'between' => array(
              'text' => ' a ',
            )
          )
        ),
        'dtemissao' => array(
          'Pe.dt_emissao' => array(
            'operator' => 'BETWEEN',
            'between' => array(
              'text' => ' a ',
            )
          )
        ),
        'num_ce_' => array(
          'Pe.num_ce' => array('operator' => 'LIKE')
        ),
        'numero_' => array(
          'Pe.numero' => array('operator' => 'LIKE')
        ),
        'nome_' => array(
          'Pe.nome' => array('operator' => 'LIKE')
        )
      )
    );

    // Define conditions
    $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
    $this->Filter->setPaginate('limit', 3000);

    $this->Pe->Behaviors->load('Containable');//Carrega apenas o Relacionamento com a Status e SS (otimização)
    $this->Pe->contain('Status', 'Ss', 'Servico');//Carrega apenas o Relacionamento com a Status e SS (otimização)

    //  $statuses = $this->Pe->Status->find('list', array('conditions' => array('Status.tipo' => 1), 'fields' => array('Status.id', 'Status.nome')));

    $this->Pe->recursive = 0;
    $this->set('pes', $this->paginate());
  }

  public function view($id = null) {
    if (!$this->Pe->exists($id)) {
      throw new NotFoundException(__('PA Inválida'));
    }
    $this->Pe->Behaviors->load('Containable');
    $options = array(
			'conditions' => array('Pe.' . $this->Pe->primaryKey => $id),
			'contain' => array(
				'Status' => array(),
				'Ss' => array(),
				'Servico' => array(),
				'Historico' => array(),
        'Item' => array(),
				'ItemPe' => array(
					'Item' => array(),
					'Aditivo' => array(),
					'Contrato' => array()
				)
			)
		);

    $this->set('pe', $this->Pe->find('first', $options));
  }

  public function add() {
    if ($this->request->is('post')) {

      $this->Pe->create();
      if ($this->Pe->save($this->request->data)) {
        $this->Session->setFlash('PA criada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
      }
      $this->Session->setFlash('Não foi possível criar a nova PA.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    /* Relacionamentos */
      /* Para encontrar o item de contrato ao qual está realacionado */
      $this->loadModel('Contrato');
      $this->set('contratos', $this->Contrato->find('list', array('fields' => array('Contrato.id', 'Contrato.numero'))));

      $this->set('statuses',
                  $this->Pe->Status->find('list', array('conditions' => array('Status.tipo' => 4), 'fields' => array('Status.id', 'Status.nome'))));
  }

  public function edit($id = null) {
    $this->Pe->recursive = 2;
    if (!$id) { throw new NotFoundException(__('PA  Inválida'));}

    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Pe->save($this->request->data)) {
        $this->Session->setFlash('PA  atualizada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        if ($this->params['url']['controller'] != null){
          return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
        }
        else{
          return $this->redirect(array('action' => 'index'));
        }
      } else {
        $this->Session->setFlash('Não foi possível atualizar a PA.', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Pe.' . $this->Pe->primaryKey => $id));
      $this->request->data = $this->Pe->find('first', $options);
    }

    /* Relacionamentos */
      /* Para encontrar o item de contrato ao qual está realacionado */
      $this->loadModel('Contrato');
      $this->set('contratos', $this->Contrato->find('list', array('fields' => array('Contrato.id', 'Contrato.numero'))));

      $this->set('statuses',
                  $this->Pe->Status->find('list', array('conditions' => array('Status.tipo' => 4), 'fields' => array('Status.id', 'Status.nome'))));
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
      $this->Pe->id = $id;
      if (!$this->Pe->exists()) {
        throw new NotFoundException(__('SS Inválida'));
      }
      $this->request->onlyAllow('post', 'delete');
      if ($this->Pe->delete()) {
        $this->Session->setFlash('A PA foi removida com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
      } else {
        $this->Session->setFlash('A PA não pode ser removida!', 'alert-box', array ('class' => 'alert alert-danger'));
      }
      return $this->redirect(array('action' => 'index'));
    }

    /**
    * Form inline
    */
    public function ajax_edit_status(){
      $this->autoRender = false;

      if ($this->request->data) {

          $pe = explode('-', $this->request->data('id'));
          $pe = $pe[1];
          $this->Pe->id = $pe;
          $this->Pe->saveField('status_id', $this->request->data('status_id'));

          $this->loadModel('Status');
          $status =  $this->Status->find('first', array('conditions' => array(
                'Status.id' => $this->request->data('status_id')), 'fields' => array('Status.nome')));

          return $status['Status']['nome'];
      }
    }
}

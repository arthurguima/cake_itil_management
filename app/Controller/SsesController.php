<?php class SsesController extends AppController {


	public function index() {
		$this->Filter->addFilters(
			array(
				'responsavel_' => array(
					'Ss.user_id' => array(
						'select' => $this->Filter->select('Responsável', $this->Ss->User->find('list',
									array('conditions' => array(), 'fields' => array('User.id', 'User.nome'))))
					)
				),
				'servico' => array(
					'Ss.servico_id' => array(
						'select' => $this->Filter->select('Serviço', $this->Ss->Servico->find('list',
						 		array('conditions'=> array("Servico.cliente_id" . $_SESSION['User']['clientes']),
											'fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'))))
					)
				),
				'status' => array(
					'Ss.status_id' => array(
						'select' => $this->Filter->select('Status', $this->Ss->Status->find('list',
									array('conditions' => array('Status.tipo' => 2), 'fields' => array('Status.id', 'Status.nome'))))
					)
				),
				'status_diferente' => array(
					'Ss.status_id' => array(
						'select' => $this->Filter->select('Status Diferente de', $this->Ss->Status->find('list',
									array('conditions' => array('Status.tipo' => 2), 'fields' => array('Status.id', 'Status.nome')))),
						'operator'    => '!='
					)
				),
				'status_diferente2' => array(
					'Ss.status_id' => array(
						'select' => $this->Filter->select('Status Diferente de', $this->Ss->Status->find('list',
									array('conditions' => array('Status.tipo' => 2), 'fields' => array('Status.id', 'Status.nome')))),
						'operator'    => '!='
					)
				),
				'clarity_dm' => array(
					'Ss.clarity_dm_id' => array('operator' => 'LIKE'),
				),
				'dtprevisao' => array(
					'Ss.dt_prevista' => array(
						'operator' => 'BETWEEN',
						'between' => array(
							'text' => ' a ',
						)
					)
				),
				'dtrecebimento' => array(
					'Ss.dt_recebimento' => array(
						'operator' => 'BETWEEN',
						'between' => array(
							'text' => ' a ',
						)
					)
				),
				'dtprazo' => array(
					'Ss.dt_prazo' => array(
						'operator' => 'BETWEEN',
						'between' => array(
							'text' => ' a ',
						)
					)
				),
				'prioridade_' => array(
					'Ss.prioridade' => array('operator' => '>=')
				),
				'nome_' => array(
					'Ss.nome' => array('operator' => 'LIKE')
				)
			)
		);

		// Define conditions
    // Apenas SSes dos cliente do Usuário.
    $conditions = $this->Filter->getConditions();

		if($conditions == null)
      $conditions = $conditions + array(998 => array('Status.fim IS NULL'));

		$conditions = $conditions + array(999 => array("Servico.cliente_id" . $_SESSION['User']['clientes']));

		$this->Filter->setPaginate('conditions', $conditions);
		$this->Filter->setPaginate('limit', 200);

		$statuses = $this->Ss->Status->find('list', array('conditions' => array('Status.tipo' => 1), 'fields' => array('Status.id', 'Status.nome')));

		$this->Ss->recursive = 0;
		$this->set('sses', $this->paginate());
	}

	public function view($id = null) {
		if (!$this->Ss->exists($id)) {
			throw new NotFoundException(__('SS Inválida'));
		}
		$this->Ss->Behaviors->attach('Containable');
		$options = array(
			'conditions' => array('Ss.' . $this->Ss->primaryKey => $id),
			'contain' => array(
				'Pe' => array('User' => array(), 'ItemPe'=> array('Item'=> array()), 'Status' => array()),
				'Demanda' => array('Status' => array(), 'DemandaTipo' => array()),
				'Ord' => array('User' => array(), 'ItemPe'=> array('ItemPePai' => array('Item'=> array())), 'Status' => array(), 'Pe' => array()),
				'Historico' => array(),
				'Servico' => array(),
				'Status' => array(),
				'User' => array(),
			)
		);
		//$this->Ss->recursive = 3;
		$this->set('ss', $this->Ss->find('first', $options));
	}

	public function timeline($id = null) {
		$this->layout = false;

		if (!$this->Ss->exists($id)) {
			throw new NotFoundException(__('SS Inválida'));
		}
		$this->Ss->Behaviors->attach('Containable');
		$options = array(
			'conditions' => array('Ss.' . $this->Ss->primaryKey => $id),
			'contain' => array(
				'Pe' => array('Historico' => array()),
				'Demanda' => array('Historico' => array()),
				'Ord' => array('Historico' => array()),
				'Historico' => array(),
				'Servico' => array(),
				'Status' => array(),
			)
		);
		//$this->Ss->recursive = 3;
		$this->set('ss', $this->Ss->find('first', $options));
	}

	public function add() {
		if ($this->request->is('post')) {

			$this->Ss->create();
			if ($this->Ss->save($this->request->data)) {
				$this->Session->setFlash('SS criada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'view', $this->Ss->id));
			}
			$this->Session->setFlash('Não foi possível criar a nova SS. Verifique se ela já existe no sistema.', 'alert-box', array ('class' => 'alert alert-danger'));
		}

		/* Relacionamentos */
		$users = $this->Ss->User->find('list', array('fields' => array('User.id', 'User.nome')));
		$this->set(compact('users'));

		$this->set('servicos',
								$this->Ss->Servico->find('list', array('fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'))));

		$this->set('statuses',
								$this->Ss->Status->find('list', array('conditions' => array('Status.tipo' => 2), 'fields' => array('Status.id', 'Status.nome'))));
	}

	public function edit($id = null) {
		if (!$id) { throw new NotFoundException(__('SS  Inválida'));}

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ss->save($this->request->data)) {
				$this->Session->setFlash('SS  atualizada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				$this->redirect(array('action' => 'view', $this->Ss->id));
			} else {
				$this->Session->setFlash('Não foi possível atualizar a SS.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Ss.' . $this->Ss->primaryKey => $id));
			$this->request->data = $this->Ss->find('first', $options);
		}

		/* Relacionamentos */
		$users = $this->Ss->User->find('list', array('fields' => array('User.id', 'User.nome')));
		$this->set(compact('users'));

		$this->set('demandas',
								$this->Ss->Demanda->find('list', array(
									'fields' => array('Demanda.id', 'Demanda.clarity_dm_id'),
									'conditions' => array('Demanda.servico_id' => $this->data['Ss']['servico_id']))));

		$this->set('statuses',
								$this->Ss->Status->find('list', array('conditions' => array('Status.tipo' => 2), 'fields' => array('Status.id', 'Status.nome'))));
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
			$this->Ss->id = $id;
			if (!$this->Ss->exists()) {
				throw new NotFoundException(__('SS Inválida'));
			}
			$this->request->onlyAllow('post', 'delete');
			if ($this->Ss->delete()) {
				$this->Session->setFlash('A SS foi removida com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
			} else {
				$this->Session->setFlash('A SS não pode ser removida!', 'alert-box', array ('class' => 'alert alert-danger'));
			}
			return $this->redirect(array('action' => 'index'));
		}


	/**
	* Form inline
	*/
	public function ajax_edit_status(){
		$this->autoRender = false;

		if ($this->request->data) {

				$ss = explode('-', $this->request->data('id'));
				$ss = $ss[1];
				$this->Ss->id = $ss;
				$this->Ss->saveField('status_id', $this->request->data('status_id'));

				$this->loadModel('Status');
				$status =  $this->Status->find('first', array('conditions' => array(
							'Status.id' => $this->request->data('status_id')), 'fields' => array('Status.nome')));

				return $status['Status']['nome'];
		}
	}

	/**
	* Form inline
	*/
	public function ajax_edit_prioridade(){
		$this->autoRender = false;

		if ($this->request->data) {
				$this->Ss->id = $this->request->data('id');;
				$this->Ss->saveField('prioridade', $this->request->data('prioridade'));

				return $this->request->data('prioridade');
		}
	}
}

<?php class ChamadosController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Filter->addFilters(
			array(
				'semDemanda' => array(
            'Chamado.demanda_id'   => array('value' => null )
        ),
				'numero_' => array(
					'OR' => array(
						'Chamado.numero' => array(
							'operator' => 'LIKE',
							'explode' => array(
								'character'   => '/',
								'concatenate' => 'OR')
						),
						'Chamado.ano' => array(
							'operator' => 'LIKE',
							'explode' => array(
								'character'   => '/',
								'concatenate' => 'OR')
						)
					)
				),
				'nome_' => array(
					'Chamado.nome' => array('operator' => 'LIKE')
				),
				'pai_' => array(
					'Chamado.pai' => array(
						'select' => $this->Filter->select('Pai?', array(1 => 'Sim', 0 => 'Não'))
					)
				),
				'aberto_' => array(
					'Chamado.aberto' => array(
						'select' => $this->Filter->select('Aberto?', array(1 => 'Sim', 0 => 'Não'))
					)
				),
				'servico' => array(
					'Chamado.servico_id' => array(
						'select' => $this->Filter->select('Serviço', $this->Chamado->Servico->find('list', array('fields' => array('Servico.id', 'Servico.sigla'))))
					)
				),
				'status' => array(
					'Chamado.status_id' => array(
						'select' => $this->Filter->select('Status', $this->Chamado->Status->find('list',
									array('conditions' => array('Status.tipo' => 5), 'fields' => array('Status.id', 'Status.nome'))))
					)
				),
				'status_diferente' => array(
					'Chamado.status_id' => array(
						'select' => $this->Filter->select('Status Diferente de', $this->Chamado->Status->find('list',
									array('conditions' => array('Status.tipo' => 5), 'fields' => array('Status.id', 'Status.nome')))),
						'operator'    => '!='
					)
				)
			)
		);

		// Define conditions
		$conditions = $this->Filter->getConditions() + array(999 => array('Chamado.demanda_id =' => null)); // Apenas Chamados que não são filhos de uma Demanda
		$this->Filter->setPaginate('conditions', $conditions);
		$this->Filter->setPaginate('limit', 3000);

		$this->Chamado->recursive = 2;
		$this->set('chamados', $this->paginate());
	}

/**
* index method
*
* @return void
*/
	public function demandas() {
		$this->Filter->addFilters(
			array(
			/*	'status' => array(
					'Chamado.status_id' => array(
						'select' => $this->Filter->select('Status da Demanda', $this->Ord->Status->find('list',
									array('conditions' => array('Status.tipo' => 3), 'fields' => array('Status.id', 'Status.nome'))))
					)
				),*/
				'numero_' => array(
					'OR' => array(
						'Chamado.numero' => array(
							'operator' => 'LIKE',
							'explode' => array(
								'character'   => '/',
								'concatenate' => 'OR')
						),
						'Chamado.ano' => array(
							'operator' => 'LIKE',
							'explode' => array(
								'character'   => '/',
								'concatenate' => 'OR')
						)
					)
				),
				'nome_' => array(
					'Chamado.nome' => array('operator' => 'LIKE')
				),
				'pai_' => array(
					'Chamado.pai' => array(
						'select' => $this->Filter->select('Pai?', array(1 => 'Sim', 0 => 'Não'))
					)
				),
				'aberto_' => array(
					'Chamado.aberto' => array(
						'select' => $this->Filter->select('Aberto?', array(1 => 'Sim', 0 => 'Não'))
					)
				),
				'servico' => array(
					'Chamado.servico_id' => array(
						'select' => $this->Filter->select('Serviço', $this->Chamado->Servico->find('list', array('fields' => array('Servico.id', 'Servico.sigla'))))
					)
				),
				'status' => array(
					'Chamado.status_id' => array(
						'select' => $this->Filter->select('Status', $this->Chamado->Status->find('list',
									array('conditions' => array('Status.tipo' => 5), 'fields' => array('Status.id', 'Status.nome'))))
					)
				),
				'status_diferente' => array(
					'Chamado.status_id' => array(
						'select' => $this->Filter->select('Status Diferente de', $this->Chamado->Status->find('list',
									array('conditions' => array('Status.tipo' => 5), 'fields' => array('Status.id', 'Status.nome')))),
						'operator'    => '!='
					)
				),
				'tipo' => array(
					'Chamado.chamado_tipo_id' => array(
						'select' => $this->Filter->select('Tipo de Chamado', $this->Chamado->ChamadoTipo->find('list',
									array('conditions' => array(), 'fields' => array('ChamadoTipo.id', 'ChamadoTipo.nome', 'ChamadoTipo.servico_id'))))
					)
				),
			)
		);

		// Define conditions
		$conditions = $this->Filter->getConditions() + array(999 => array('Chamado.demanda_id !=' => null)); // Apenas Chamados que são filhos de uma Demanda
		$this->Filter->setPaginate('conditions', $conditions);
		$this->Filter->setPaginate('limit', 3000);

		$this->Chamado->recursive = 2;
		$this->set('chamados', $this->paginate());
	}


/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Chamado->exists($id)) {
			throw new NotFoundException(__('Chamado Inválido'));
		}
		$options = array('conditions' => array('Chamado.' . $this->Chamado->primaryKey => $id));
		$this->set('chamado', $this->Chamado->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Chamado->create();
			if ($this->Chamado->save($this->request->data)) {
				$this->Session->setFlash('Chamado Adicionado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				if($this->params['url']['id'] != null ){
					return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
				}
				else{
					return $this->redirect(array('controller' =>  'chamados', 'action' => 'index'));
				}
			} else {
				$this->Session->setFlash('Não foi possível adicionar o novo chamado.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		}

		/* Relacionamentos */
			$servicos = $this->Chamado->Servico->find('list', array('fields' => array('Servico.id', 'Servico.nome')));
			$this->set(compact('servicos'));

			//$chamadoTipos = $this->Demanda->DemandaTipo->find('list', array('fields' => array('DemandaTipo.id', 'DemandaTipo.nome')));
			//$this->set(compact('demandaTipos'));

			$statuses = $this->Chamado->Status->find('list', array('conditions' => array('Status.tipo' => 5), 'fields' => array('Status.id', 'Status.nome')));
			$this->set(compact('statuses'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Chamado->exists($id)) {
			throw new NotFoundException(__('Invalid chamado'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Chamado->save($this->request->data)) {
				$this->Session->setFlash('Chamado Atualizado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				//Redirect
				if($this->params['url']['id'] != null ){
					return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
				}
				else{
					return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action']));
				}
			} else {
				$this->Session->setFlash('Não foi possível atualizar o chamado.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Chamado.' . $this->Chamado->primaryKey => $id));
			$this->request->data = $this->Chamado->find('first', $options);
		}

		/* Relacionamentos */
			$servicos = $this->Chamado->Servico->find('list', array('fields' => array('Servico.id', 'Servico.nome')));
			$this->set(compact('servicos'));

			$statuses = $this->Chamado->Status->find('list', array('conditions' => array('Status.tipo' => 5), 'fields' => array('Status.id', 'Status.nome')));
			$this->set(compact('statuses'));
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
		$this->Chamado->id = $id;
		if (!$this->Chamado->exists()) {
			throw new NotFoundException(__('Invalid chamado'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Chamado->delete()) {
			$this->Session->setFlash('O chamado  com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
		} else {
			$this->Session->setFlash('O Chamado  com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
		}
		return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
	}

	/**
	* Form inline
	*/
	public function ajax_edit_status(){
		$this->autoRender = false;

		if ($this->request->data) {

				$chamado = explode('-', $this->request->data('id'));
				$chamado = $chamado[1];
				$this->Chamado->id = $chamado;
				$this->Chamado->saveField('status_id', $this->request->data('status_id'));

				$this->loadModel('Status');
				$status =  $this->Status->find('first', array('conditions' => array(
							'Status.id' => $this->request->data('status_id')), 'fields' => array('Status.nome')));

				return $status['Status']['nome'];
		}
	}
}

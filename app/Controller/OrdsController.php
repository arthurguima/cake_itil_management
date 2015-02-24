<?php class OrdsController extends AppController {

	public function index() {
		$this->Filter->addFilters(
			array(
				'responsavel_' => array(
					'Pe.responsavel' => array('operator' => 'LIKE')
				),
				'status' => array(
					'Ord.status_id' => array(
						'select' => $this->Filter->select('Status', $this->Ord->Status->find('list',
									array('conditions' => array('Status.tipo' => 3), 'fields' => array('Status.id', 'Status.nome'))))
					)
				),
				'servico' => array(
					'Ord.servico_id' => array(
						'select' => $this->Filter->select('Serviço', $this->Ord->Servico->find('list', array('fields' => array('Servico.id', 'Servico.sigla'))))
					)
				),
				'status_diferente' => array(
					'Ord.status_id' => array(
						'select' => $this->Filter->select('Status Diferente de', $this->Ord->Status->find('list',
									array('conditions' => array('Status.tipo' => 3), 'fields' => array('Status.id', 'Status.nome')))),
						'operator'    => '!='
					)
				),
				'status_diferente2' => array(
					'Ord.status_id' => array(
						'select' => $this->Filter->select('Status Diferente de', $this->Ord->Status->find('list',
									array('conditions' => array('Status.tipo' => 3), 'fields' => array('Status.id', 'Status.nome')))),
						'operator'    => '!='
					)
				),
				'dtemissao' => array(
					'Ord.dt_emissao' => array(
						'operator' => 'BETWEEN',
						'between' => array(
							'text' => ' a ',
						)
					)
				),
				'dtrecebimento' => array(
					'Ord.dt_recebimento' => array(
						'operator' => 'BETWEEN',
						'between' => array(
							'text' => ' a ',
						)
					)
				),
				'dtdhomologacao' => array(
					'Ord.dt_homologacao' => array(
						'operator' => 'BETWEEN',
						'between' => array(
							'text' => ' a ',
						)
					)
				),
				'dtdproducao' => array(
					'Ord.dt_producao' => array(
						'operator' => 'BETWEEN',
						'between' => array(
							'text' => ' a ',
						)
					)
				),
				'dthomologacao' => array(
					'Ord.dt_homologacao' => array(
						'operator' => 'BETWEEN',
						'between' => array(
							'text' => ' a ',
						)
					)
				),
				'dtexecucao' => array(
					'Ord.dt_execucao' => array(
						'operator' => 'BETWEEN',
						'between' => array(
							'text' => ' a ',
						)
					)
				),
				'numero_' => array(
					'OR' => array(
						'Ord.numero' => array(
							'operator' => 'LIKE',
							'explode' => array(
		            'character'   => '/',
		            'concatenate' => 'OR')
						),
						'Ord.ano' => array(
							'operator' => 'LIKE',
							'explode' => array(
								'character'   => '/',
								'concatenate' => 'OR')
						)
					)
				),
				'nome_' => array(
					'Ord.nome' => array('operator' => 'LIKE')
				)
			)
		);

		// Define conditions
		$this->Filter->setPaginate('conditions', $this->Filter->getConditions());
		$this->Filter->setPaginate('limit', 3000);

		$this->Ord->Behaviors->load('Containable');//Carrega apenas o Relacionamento com a Status e SS (otimização)
		$this->Ord->contain('Status', 'Ss', 'Pe', 'Servico');//Carrega apenas o Relacionamento com a Status e SS (otimização)

		$this->set('ords', $this->paginate());
	}

	public function view($id = null) {
		if (!$this->Ord->exists($id)) {
			throw new NotFoundException(__('OS Inválida!'));
		}
		$options = array('conditions' => array('Ord.' . $this->Ord->primaryKey => $id));
		$this->Ord->recursive = 1;
		$this->set('ord', $this->Ord->find('first', $options));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Ord->create();
			if ($this->Ord->save($this->request->data)) {
				$this->Session->setFlash('OS criada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
			} else {
				  $this->Session->setFlash('Não foi possível criar a nova OS.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		}

		/* Relacionamentos */
		$this->set('pes',
								$this->Ord->Pe->find('list', array('conditions' => array('Pe.ss_id' => $this->params['url']['id']), 'fields' => array('Pe.id', 'Pe.numero'))));

		/* Relacionamentos */
		$this->set('statuses',
								$this->Ord->Status->find('list', array('conditions' => array('Status.tipo' => 3), 'fields' => array('Status.id', 'Status.nome'))));
	}

	public function edit($id = null) {
		if (!$this->Ord->exists($id)) {
			throw new NotFoundException(__('OS Inválida!'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ord->save($this->request->data)) {
				$this->Session->setFlash('OS  atualizada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				if ($this->params['url']['controller'] != null){
					return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
				}
				else{
					return $this->redirect(array('action' => 'index'));
				}
			} else {
			$this->Session->setFlash('Não foi possível atualizar a OS.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Ord.' . $this->Ord->primaryKey => $id));
			$this->request->data = $this->Ord->find('first', $options);
		}

		/* Relacionamentos */
		$this->set('pes',
								$this->Ord->Pe->find('list', array('conditions' => array('Pe.ss_id' => $this->data['Ord']['ss_id']), 'fields' => array('Pe.id', 'Pe.numero'))));

		/* Relacionamentos */
		$this->set('statuses',
								$this->Ord->Status->find('list', array('conditions' => array('Status.tipo' => 3), 'fields' => array('Status.id', 'Status.nome'))));
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
		$this->Ord->id = $id;
		if (!$this->Ord->exists()) {
			throw new NotFoundException(__('Invalid Ord'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Ord->delete()) {
			$this->Session->setFlash('A OS foi removida com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
		} else {
			$$this->Session->setFlash('A OS não pode ser removida!', 'alert-box', array ('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	* Form inline
	*/
	public function ajax_edit_status(){
		$this->autoRender = false;

		if ($this->request->data) {

				$ord = explode('-', $this->request->data('id'));
				$ord = $ord[1];
				$this->Ord->id = $ord;
				$this->Ord->saveField('status_id', $this->request->data('status_id'));

				$this->loadModel('Status');
				$status =  $this->Status->find('first', array('conditions' => array(
							'Status.id' => $this->request->data('status_id')), 'fields' => array('Status.nome')));

				return $status['Status']['nome'];
		}
	}
}

<?php class ChamadosController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->loadModel('Cliente');
    $this->Cliente->Behaviors->attach('Containable');

		$this->Filter->addFilters(
			array(
				'semDemanda' => array(
            'Chamado.demanda_id'   => array('value' => null )
        ),
				'numerof' => array(
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
				'nomef' => array(
					'Chamado.nome' => array('operator' => 'LIKE')
				),
				'paif' => array(
					'Chamado.pai' => array(
						'select' => $this->Filter->select('Pai?', array(1 => 'Sim', 0 => 'Não'))
					)
				),
				'abertof' => array(
					'Chamado.aberto' => array(
						'select' => $this->Filter->select('Aberto?', array(1 => 'Sim', 0 => 'Não'))
					)
				),
				'servico' => array(
					'Chamado.servico_id' => array(
						'select' => $this->Filter->select('Serviço', $this->Chamado->Servico->find('list',
									array('conditions'=> array("Servico.cliente_id" . $_SESSION['User']['clientes']),
										'fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'))))
					)
				),
				'cliente' => array(
          'Servico.cliente_id' => array(
            'select' => $this->Filter->select('Cliente', $this->Cliente->find('list', array(
                        'conditions'=> array("Cliente.id" . $_SESSION['User']['clientes']),
                        'fields' => array('Cliente.id', 'Cliente.sigla'))))
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
				'responsavelf' => array(
					'Chamado.user_id' => array(
						'select' => $this->Filter->select('Responsável', $this->Chamado->User->find('list',
									array('conditions' => array(), 'fields' => array('User.id', 'User.nome'))))
					)
				),
			)
		);
		//Filtro favorito do usuário
    $this->loadModel('Filtro');
    $this->Filtro->Behaviors->attach('Containable');
    $filtro = $this->Filtro->find('first', array('contain' => array(), 'conditions' => array('user_id' => $this->Session->read('User.uid'), 'pagina' => "chamados_index")));
    $this->set('filtro', $filtro);

		// Define conditions
    // Apenas RDMS dos cliente do Usuário.
    $conditions = $this->Filter->getConditions();

		if($conditions == null){
      $this->set('conditions', false);
    }
    else{
      $this->set('conditions', true);

			$conditions = $conditions + array(998 => array("Servico.cliente_id" . $_SESSION['User']['clientes']));

			$conditions = $conditions + array(999 => array('Chamado.demanda_id =' => null)); // Apenas Chamados que não são filhos de uma Demanda
			$this->Filter->setPaginate('conditions', $conditions);
			$this->Filter->setPaginate('limit', 600);

			//$this->Chamado->recursive = 2;
			$this->Chamado->Behaviors->load('Containable');//Carrega apenas o Relacionamento com a Status e SS (otimização)
	    $this->Chamado->contain("Status", "Servico", "ChamadoTipo", "User");
			$this->set('chamados', $this->paginate());
		}
	}

/**
* index method
*
* @return void
*/
	public function demandas() {
		$this->loadModel('Cliente');
		$this->Cliente->Behaviors->attach('Containable');
		
		$this->Filter->addFilters(
			array(
			'numerof' => array(
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
				'nomef' => array(
					'Chamado.nome' => array('operator' => 'LIKE')
				),
				'paif' => array(
					'Chamado.pai' => array(
						'select' => $this->Filter->select('Pai?', array(1 => 'Sim', 0 => 'Não'))
					)
				),
				'abertof' => array(
					'Chamado.aberto' => array(
						'select' => $this->Filter->select('Aberto?', array(1 => 'Sim', 0 => 'Não'))
					)
				),
				'servico' => array(
					'Chamado.servico_id' => array(
						'select' => $this->Filter->select('Serviço', $this->Chamado->Servico->find('list',
						 array('conditions'=> array("Servico.cliente_id" . $_SESSION['User']['clientes']),
							'fields' => array('Servico.id', 'Servico.sigla'))))
					)
				),
				'cliente' => array(
          'Servico.cliente_id' => array(
            'select' => $this->Filter->select('Cliente', $this->Cliente->find('list', array(
                        'conditions'=> array("Cliente.id" . $_SESSION['User']['clientes']),
                        'fields' => array('Cliente.id', 'Cliente.sigla'))))
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
				'responsavelf' => array(
					'Chamado.user_id' => array(
						'select' => $this->Filter->select('Responsável', $this->Chamado->User->find('list',
									array('conditions' => array(), 'fields' => array('User.id', 'User.nome'))))
					)
				),
			)
		);
		//Filtro favorito do usuário
    $this->loadModel('Filtro');
    $this->Filtro->Behaviors->attach('Containable');
    $filtro = $this->Filtro->find('first', array('contain' => array(), 'conditions' => array('user_id' => $this->Session->read('User.uid'), 'pagina' => "chamado_dem_index")));
    $this->set('filtro', $filtro);

		// Define conditions
		$conditions = $this->Filter->getConditions();

		if($conditions == null){
      $this->set('conditions', false);
    }
    else{
      $this->set('conditions', true);
			$conditions = $conditions + array(999 => array('Chamado.demanda_id !=' => null)); // Apenas Chamados que são filhos de uma Demanda

			$conditions = $conditions + array(998 => array("Servico.cliente_id" . $_SESSION['User']['clientes']));


			$this->Filter->setPaginate('conditions', $conditions);
			$this->Filter->setPaginate('limit', 450);
			$this->Chamado->Behaviors->load('Containable');//Carrega apenas o Relacionamento com a Status e SS (otimização)
			$this->Chamado->contain(array( 'Status', 'Servico', 'User', 'Demanda' => array('Status'), 'ChamadoTipo'));


		//$this->Chamado->recursive = 1;
			$this->set('chamados', $this->paginate());
		}
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
		$this->Chamado->Behaviors->load('Containable');
		$options = array(
			'conditions' => array('Chamado.' . $this->Chamado->primaryKey => $id),
			'contain'	=> array(
					'Rdm' => array(),
					'Historico' => array(),
					'Servico' => array(),
					'ChamadoTipo' => array(),
					'Subtarefa' => array('User', 'Chamado'),
					'Status' => array(),
					'User' => array(),
					'Demanda' => array()
			)
		);
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
					$this->redirect(array('action' => 'view', $this->Chamado->id));
				}
			} else {
				$this->Session->setFlash('Não foi possível adicionar o novo chamado.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		}

		/* Relacionamentos */
			$servicos = $this->Chamado->Servico->find('list', array(
				'fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'),
				'conditions' => array("Servico.cliente_id" . $_SESSION['User']['clientes']) ));
			$this->set(compact('servicos'));

			$users = $this->Chamado->User->find('list', array(
        'fields' => array('User.id', 'User.nome'),
        'conditions' => array("User.id = " . $_SESSION['User']['uid'])
      ));
      $this->set(compact('users'));

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
		$this->Chamado->Behaviors->load('Containable');
		$this->Chamado->contain('ChamadoTipo', 'Status', 'Servico');

		if (!$this->Chamado->exists($id)) {
			throw new NotFoundException(__('Invalid chamado'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Chamado->save($this->request->data)) {
				$this->Session->setFlash('Chamado Atualizado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				//Redirect
				if($this->params['url']['id'] != null && $this->params['url']['controller'] != ''){
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

			/* Relacionamentos */
				$users = $this->Chamado->User->find('list', array(
					'fields' => array('User.id', 'User.nome'),
					'conditions' => array("User.id = " . $this->request->data['Chamado']['user_id'])
				));
				$this->set(compact('users'));


				$servicos = $this->Chamado->Servico->find('list', array(
					'fields' => array('Servico.id', 'Servico.sigla', 'Servico.tecnologia'),
					'conditions' => array("Servico.cliente_id" . $_SESSION['User']['clientes']) ));
				$this->set(compact('servicos'));

				$statuses = $this->Chamado->Status->find('list', array('conditions' => array('Status.tipo' => 5), 'fields' => array('Status.id', 'Status.nome')));
				$this->set(compact('statuses'));

				$demandas = $this->Chamado->Demanda->find('list', array(
											'fields' => array('Demanda.id', 'Demanda.clarity_dm_id'),
											'conditions' => array('Demanda.id' => $this->data['Chamado']['demanda_id'])));
				$this->set(compact('demandas'));

		}
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
			throw new NotFoundException(__('Chamado Inválido'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Chamado->delete()) {
			$this->Session->setFlash('O chamado  com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
		} else {
			$this->Session->setFlash('O Chamado  com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
		}
		if(isset($this->params['url']['id']))
			return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
		else
		return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action']));
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

	/**
  * returns a list of demandas filtered by $servico
  */
  public function optionList(){
    $this->layout = null;

	  $this->set('chamados',
                $this->Chamado->find('list', array(
                  'fields' => array('Chamado.id', 'Chamado.numero'),
                  'conditions' => array('Chamado.servico_id' => $this->params['url']['servico']))));
  }

	public function json(){
    $this->layout = null;
    $this->Chamado->recursive = 0;
    $this->Chamado->Behaviors->load('Containable');

    $ch = $this->Chamado->find('all', array(
      'fields' => array('Chamado.id', 'Chamado.numero'),
      'conditions' => array("Chamado.numero LIKE '%" . $this->params['url']['q'] . "%'"),
      'contain' => array()
    ));
    //debug($users);
    $ch = str_replace("{\"Chamado\":", "", json_encode($ch));
    $ch = str_replace("}}", "}", $ch);
    $ch = str_replace("numero", "text", $ch);

    $this->set("ch",   $ch);
  }
}

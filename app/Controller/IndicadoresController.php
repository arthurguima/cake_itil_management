<?php class IndicadoresController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		if(isset($this->request->data['contrato_id'])){
      if(($this->request->data['Aditivo']['Aditivo']['0'] != 'Aditivo' )){
        $conditions = '(Indicadore.aditivo_id = "'. $this->request->data['Aditivo']['Aditivo']['0'] .'")';
      }
      else{
        $conditions = '(Indicadore.contrato_id = "'. $this->request->data['contrato_id'] .'")';
      }
    }
		else{
			$conditions = "";
		}

		$this->Indicadore->Behaviors->attach('Containable');
		$options = array(
			'conditions' => array($conditions),
			'contain' => array(
				'Regra' => array(
					'Servico' => array(),
					'Contrato' => array(),
					'Aditivo' => array(
						'Contrato' => array(),
					)
				)
			)
		);
		$this->set('indicadores', $this->Indicadore->find('all', $options));


		/*Para o filtro*/
		/* Filtros */
    $this->loadModel('Contrato');
    $this->set('contratos', $this->Contrato->find('list', array('fields' => array('Contrato.id', 'Contrato.numero'))));
    $this->set(compact('contratos'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Indicadore->exists($id)) {
			throw new NotFoundException(__('Indicadore Inválido.'));
		}
		$this->Indicadore->Behaviors->attach('Containable');
		$options = array(
			'conditions' => array('Indicadore.' . $this->Indicadore->primaryKey => $id),
			'contain' => array(
				'Regra' => array(
					'Servico' => array()
				)
			)
		);
		$this->set('indicadore', $this->Indicadore->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Indicadore->create();
			if ($this->Indicadore->save($this->request->data)) {
				$this->Session->setFlash('Indicador de contrato Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
			} else {
				$this->Session->setFlash('Não foi possível criar o novo indicadore contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		}

		if(!strcmp($this->params['url']['controller'],'aditivos')){
			$this->set('regras', $this->Indicadore->Regra->find('list', array(
				'conditions' => array('aditivo_id' => $this->params['url']['id']),
				'fields' => array('Regra.id', 'Regra.nome')
			)));
		}
		else{
			$this->set('regras', $this->Indicadore->Regra->find('list', array(
				'conditions' => array('contrato_id' => $this->params['url']['id']),
				'fields' => array('Regra.id', 'Regra.nome')
			)));
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
	public function edit($id = null) {
		if (!$id) { throw new NotFoundException(__('Indicador de Contrato Inválido'));}

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Indicadore->save($this->request->data)) {
				$this->Session->setFlash('Indicador de Contrato atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
			} else {
				$this->Session->setFlash('Não foi possível atualizar o contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Indicadore.' . $this->Indicadore->primaryKey => $id));
			$this->request->data = $this->Indicadore->find('first', $options);
		}

		if($this->request->data['Aditivo']['id'] != null){
			$this->set('regras', $this->Indicadore->Regra->find('list', array(
				'conditions' => array('aditivo_id' => $this->request->data['Aditivo']['id']),
				'fields' => array('Regra.id', 'Regra.nome')
			)));
		}
		else{
			$this->set('regras', $this->Indicadore->Regra->find('list', array(
				'conditions' => array('contrato_id' => $this->request->data['Contrato']['id']),
				'fields' => array('Regra.id', 'Regra.nome')
			)));
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
		$contrato_id = $this->Indicadore->contrato_id;
		$this->Indicadore->id = $id;

		if (!$this->Indicadore->exists()) {
			throw new NotFoundException(__('Indicadore inválido'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Indicadore->delete()) {
			$this->Session->setFlash('O Indicador de contrato com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
		} else {
			$this->Session->setFlash('O Indicador de contrato com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
		}
		return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
	}
}

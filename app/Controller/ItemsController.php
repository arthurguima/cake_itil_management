<?php class ItemsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Item->recursive = 0;
		$this->set('items', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Item->exists($id)) {
			throw new NotFoundException(__('Item Inválido.'));
		}
		$this->set('item', $this->Item->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Item->create();
			if ($this->Item->save($this->request->data)) {
				$this->Session->setFlash('Item de contrato Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
			} else {
				$this->Session->setFlash('Não foi possível criar o novo item contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		}
		$contratos = $this->Item->Contrato->find('list');
		$this->set(compact('contratos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
	public function edit($id = null) {
		if (!$id) { throw new NotFoundException(__('Item de Contrato Inválido'));}

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Item->save($this->request->data)) {
				$this->Session->setFlash('Item de Contrato atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
			} else {
				$this->Session->setFlash('Não foi possível atualizar o contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Item.' . $this->Item->primaryKey => $id));
			$this->request->data = $this->Item->find('first', $options);
		}
		/* Relacionamento */
		$contratos = $this->Item->Contrato->find('list');
		$this->set(compact('contratos'));
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
		$contrato_id = $this->Item->contrato_id;
		$this->Item->id = $id;

		if (!$this->Item->exists()) {
			throw new NotFoundException(__('Item inválido'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Item->delete()) {
			$this->Session->setFlash('O Item de contrato com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
		} else {
			$this->Session->setFlash('O Item de contrato com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
		}
		return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
	}

	/**
	* returns a list of itens filtered by contrato/aditivo
	*/
	public function optionList(){
		$this->layout = null;
		//$this->autoRender = false;

		//$this->Demanda->recursive = -1;
		if($this->params['url']['tipo'] == 'Contrato'){
			$this->set('items',
									$this->Item->find('list', array(
										'fields' => array('Item.id', 'Item.nome'),
										'conditions' => array('Item.contrato_id' => $this->params['url']['id']))));
		}
		else{
			$this->set('items',
									$this->Item->find('list', array(
										'fields' => array('Item.id', 'Item.nome'),
										'conditions' => array('Item.aditivo_id' => $this->params['url']['id']))));
		}
	}
}

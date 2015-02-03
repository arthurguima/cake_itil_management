<?php class RdmTiposController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->RdmTipo->Behaviors->load('Containable');
		$this->set('rdmTipos', $this->RdmTipo->find('all'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
	public function view($id = null) {
		if (!$this->RdmTipo->exists($id)) {
			throw new NotFoundException(__('Tipo de Rdm Inválido'));
		}
		$options = array('conditions' => array('RdmTipo.' . $this->RdmTipo->primaryKey => $id));
		$this->set('rdmTipo', $this->RdmTipo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->RdmTipo->create();
			if ($this->RdmTipo->save($this->request->data)) {
				$this->Session->setFlash('Tipo de rdm criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('O tipo de rdm não foi criado.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		}
		$rdmtipos = $this->RdmTipo->Rdm->find('list');
		$this->set(compact('rdmtipos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->RdmTipo->exists($id)) {
			throw new NotFoundException(__('Invalid rdm tipo'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->RdmTipo->save($this->request->data)) {
				$this->Session->setFlash('Tipo de rdm atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Não foi possível atualizar o tipo de rdm.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('RdmTipo.' . $this->RdmTipo->primaryKey => $id));
			$this->request->data = $this->RdmTipo->find('first', $options);
		}
		$rdmtipos = $this->RdmTipo->Rdm->find('list');
		$this->set(compact('rdmtipos'));
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
		$this->RdmTipo->id = $id;
		if (!$this->RdmTipo->exists()) {
			throw new NotFoundException(__('Tipo de rdm inválido'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->RdmTipo->delete()) {
			$this->Session->setFlash('O tipo de rdm com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
		} else {
			$this->Session->setFlash('Não foi remover o tipo de rdm.', 'alert-box', array ('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	* returns a list of itens filtered by servico
	*/
	public function optionList(){
		if ($this->request->is('ajax')) {
    	$this->disableCache();
		}
		$this->layout = null;
		//$this->autoRender = false;

		//$this->Demanda->recursive = -1;
		$this->set('rdmtipos',
								$this->RdmTipo->find('list', array(
									'fields' => array('RdmTipo.id', 'RdmTipo.nome'),
									'conditions' => array('RdmTipo.servico_id' => $this->params['url']['servico']))));
	}
}

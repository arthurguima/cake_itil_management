<?php class ChamadoTiposController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ChamadoTipo->Behaviors->load('Containable');
		$this->ChamadoTipo->contain('Servico');

		$this->set('chamadoTipos', $this->ChamadoTipo->find('all'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ChamadoTipo->exists($id)) {
			throw new NotFoundException(__('Tipo de Chamado Inválido'));
		}
		$options = array('conditions' => array('ChamadoTipo.' . $this->ChamadoTipo->primaryKey => $id));
		$this->set('chamadoTipo', $this->ChamadoTipo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ChamadoTipo->create();
			if ($this->ChamadoTipo->save($this->request->data)) {
				$this->Session->setFlash('Tipo de chamado criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('O tipo de chamado não foi criado.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		}
		$chamadotipos = $this->ChamadoTipo->Chamado->find('list');
		$this->set(compact('chamadotipos'));

		/* Relacionamentos */
			$servicos = $this->ChamadoTipo->Servico->find('list', array('fields' => array('Servico.id', 'Servico.nome')));
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
		if (!$this->ChamadoTipo->exists($id)) {
			throw new NotFoundException(__('Invalid chamado tipo'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ChamadoTipo->save($this->request->data)) {
				$this->Session->setFlash('Tipo de chamado atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Não foi possível atualizar o tipo de chamado.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('ChamadoTipo.' . $this->ChamadoTipo->primaryKey => $id));
			$this->request->data = $this->ChamadoTipo->find('first', $options);
		}
		$chamadotipos = $this->ChamadoTipo->Chamado->find('list');
		$this->set(compact('chamadotipos'));

		/* Relacionamentos */
			$servicos = $this->ChamadoTipo->Servico->find('list', array('fields' => array('Servico.id', 'Servico.nome', 'Servico.tecnologia')));
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
		$this->ChamadoTipo->id = $id;
		if (!$this->ChamadoTipo->exists()) {
			throw new NotFoundException(__('Tipo de chamado inválido'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ChamadoTipo->delete()) {
			$this->Session->setFlash('O tipo de chamado com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
		} else {
			$this->Session->setFlash('Não foi remover o tipo de chamado.', 'alert-box', array ('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	* returns a list of itens filtered by servico
	*/
	public function optionList(){
		/*if ($this->request->is('ajax')) {
    	$this->disableCache();
		}*/
		$this->layout = null;
		//$this->autoRender = false;

		$this->set('chamadotipos',
								$this->ChamadoTipo->find('list', array(
									'fields' => array('ChamadoTipo.id', 'ChamadoTipo.nome'),
									'conditions' => array('ChamadoTipo.servico_id' => $this->params['url']['servico']))));
	}
}

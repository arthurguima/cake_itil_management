<?php class DemandaTiposController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->set('demandaTipos', $this->DemandaTipo->find('all'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DemandaTipo->exists($id)) {
			throw new NotFoundException(__('Tipo de Demanda Inválido'));
		}
		$options = array('conditions' => array('DemandaTipo.' . $this->DemandaTipo->primaryKey => $id));
		$this->set('demandaTipo', $this->DemandaTipo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DemandaTipo->create();
			if ($this->DemandaTipo->save($this->request->data)) {
				$this->Session->setFlash('Tipo de demanda criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('O tipo de demanda não foi criado.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		}
		$demandas = $this->DemandaTipo->Demanda->find('list');
		$this->set(compact('demandas'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->DemandaTipo->exists($id)) {
			throw new NotFoundException(__('Invalid demanda tipo'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->DemandaTipo->save($this->request->data)) {
				$this->Session->setFlash('Tipo de demanda atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Não foi possível atualizar o tipo de demanda.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('DemandaTipo.' . $this->DemandaTipo->primaryKey => $id));
			$this->request->data = $this->DemandaTipo->find('first', $options);
		}
		$demandas = $this->DemandaTipo->Demanda->find('list');
		$this->set(compact('demandas'));
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
		$this->DemandaTipo->id = $id;
		if (!$this->DemandaTipo->exists()) {
			throw new NotFoundException(__('Tipo de demanda inválido'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DemandaTipo->delete()) {
			$this->Session->setFlash('O tipo de demanda com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
		} else {
			$this->Session->setFlash('Não foi remover o tipo de demanda.', 'alert-box', array ('class' => 'alert alert-danger'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}

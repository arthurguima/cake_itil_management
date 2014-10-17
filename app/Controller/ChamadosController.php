<?php class ChamadosController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Chamado->recursive = 0;
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
				return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
			} else {
				$this->Session->setFlash('Não foi possível adicionar o novo chamado.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
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
		if (!$this->Chamado->exists($id)) {
			throw new NotFoundException(__('Invalid chamado'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Chamado->save($this->request->data)) {
				$this->Session->setFlash('Chamado Atualizado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
			} else {
				$this->Session->setFlash('Não foi possível atualizar o chamado.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Chamado.' . $this->Chamado->primaryKey => $id));
			$this->request->data = $this->Chamado->find('first', $options);
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
}

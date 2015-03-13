<?php class RegrasController extends AppController {
	var $helpers = array( 'TinyMCE' );

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Regra->recursive = 0;
		$this->set('regras', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Regra->exists($id)) {
			throw new NotFoundException(__('Ans Inválido.'));
		}
		$options = array('conditions' => array('Regra.' . $this->Regra->primaryKey => $id));
		$this->set('regra', $this->Regra->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Regra->create();
			if ($this->Regra->save($this->request->data)) {
				$this->Session->setFlash('Regra de ANS criada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
			} else {
				$this->Session->setFlash('Não foi possível criar a nova regra de ANS.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		}

		/* Relacionamentos */
      $servicos = $this->Regra->Servico->find('list', array('fields' => array('Servico.id', 'Servico.nome')));
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
		if (!$id) { throw new NotFoundException(__('Regra de ANS Inválida'));}

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Regra->save($this->request->data)) {
				$this->Session->setFlash('Regra de ANS atualizada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
			} else {
				$this->Session->setFlash('Não foi possível atualizar a regra de ANS.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('Regra.' . $this->Regra->primaryKey => $id));
			$this->request->data = $this->Regra->find('first', $options);
		}

		/* Relacionamentos */
			$servicos = $this->Regra->Servico->find('list', array('fields' => array('Servico.id', 'Servico.nome')));
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
		$contrato_id = $this->Regra->contrato_id;
		$this->Regra->id = $id;

		if (!$this->Regra->exists()) {
			throw new NotFoundException(__('Ans inválido'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Regra->delete()) {
			$this->Session->setFlash('A regra de Ans foi removida.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
		} else {
			$this->Session->setFlash('A regra de Ans não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
		}
		return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
	}
}

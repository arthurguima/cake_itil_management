<?php class ItemPesController extends AppController {


/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ItemPe->create();

			if ($this->request->data) {
				$this->request->data['ItemPe']['contrato_id'] = $this->request->data['ItemPe']['contrato'];

				if($this->request->data['Aditivo']['Aditivo']['0'] != 'Aditivo' ){
					$this->request->data['ItemPe']['aditivo_id'] = $this->request->data['Aditivo']['Aditivo']['0'];
				}
			}

			if ($this->ItemPe->save($this->request->data)) {
				$this->Session->setFlash('Item de contrato da PA Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
			} else {
				$this->Session->setFlash('Não foi possível criar o novo item contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		}

		/* Relacionamento */
		$this->set('contratos', $this->ItemPe->Contrato->find('list', array('fields' => array('Contrato.id', 'Contrato.numero'))));
		if($this->params['url']['pe'] != null){
			$this->ItemPe->Behaviors->attach('Containable');
			$items = $this->ItemPe->find('all', array(
				'conditions' => array('ItemPe.pe_id =' . $this->params['url']['pe']),
				'contain' => array('Item' => array()),
				'fields' => array('ItemPe.id', 'ItemPe.volume', 'Item.nome')));

			$this->set('items', $this->ItemdaPa($items));
		}
	}

	private function ItemdaPa($items){
		$itemsaux = array();
		foreach($items as $i){
			$itemsaux[$i['ItemPe']['id']] = $i['Item']['nome'] . " | Valor: " . $i['ItemPe']['volume'];
		}
		return $itemsaux;
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
	public function edit($id = null) {
		if (!$id) { throw new NotFoundException(__('ItemPe de Contrato Inválido'));}

		if ($this->request->is('post') || $this->request->is('put')) {

			if ($this->request->data && ($this->params['url']['controller'] != 'ords')) {
				$this->request->data['ItemPe']['contrato_id'] = $this->request->data['ItemPe']['contrato'];

				if($this->request->data['Aditivo']['Aditivo']['0'] != 'Aditivo' ){
					$this->request->data['ItemPe']['aditivo_id'] = $this->request->data['Aditivo']['Aditivo']['0'];
				}
			}

			if ($this->ItemPe->save($this->request->data)) {
				$this->Session->setFlash('ItemPe de Contrato atualizado com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
				return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
			} else {
				$this->Session->setFlash('Não foi possível atualizar o contrato.', 'alert-box', array ('class' => 'alert alert-danger'));
			}
		} else {
			$options = array('conditions' => array('ItemPe.' . $this->ItemPe->primaryKey => $id));
			$this->request->data = $this->ItemPe->find('first', $options);
		}
		/* Relacionamento */
		$this->set('contratos', $this->ItemPe->Contrato->find('list', array('fields' => array('Contrato.id', 'Contrato.numero'))));
		if($this->params['url']['controller'] == 'ords'){
			$this->ItemPe->Behaviors->attach('Containable');
			//debug($this->data['ItemPe']);
			$items = $this->ItemPe->find('all', array(
				'conditions' => array('ItemPe.pe_id = ' . $this->params['url']['pe_id']),
				'contain' => array('Item' => array()),
				'fields' => array('ItemPe.id', 'ItemPe.volume', 'Item.nome')));

			$this->set('items', $this->ItemdaPa($items));
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
		$contrato_id = $this->ItemPe->contrato_id;
		$this->ItemPe->id = $id;

		if (!$this->ItemPe->exists()) {
			throw new NotFoundException(__('ItemPe inválido'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->ItemPe->delete()) {
			$this->Session->setFlash('O Item de contrato da PA com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
		} else {
			$this->Session->setFlash('O Item de contrato da PA com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
		}
		return $this->redirect(array('controller' =>  $this->params['url']['controller'], 'action' => $this->params['url']['action'], $this->params['url']['id'] ));
	}
}

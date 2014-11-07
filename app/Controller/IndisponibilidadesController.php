<?php class IndisponibilidadesController extends AppController {

/**
 * index method
 *
 * @return void
 */
  public function index() {
    // Add filter
    $this->Filter->addFilters(
      array(
        'servico' => array(
          '_Servico.id' => array(
            'select' => $this->Filter->select('Serviço', $this->Indisponibilidade->Servico->find('list', array(
                        'contain' => array('_IndisponibilidadesServico', '_Servico'), //'Hack' para HABTM
                        'fields' => array('Servico.id', 'Servico.sigla'))))
          )
        ),
        'motivo' => array(
          'Indisponibilidade.motivo_id' => array(
            'select' => $this->Filter->select('Motivo', $this->Indisponibilidade->Motivo->find('list', array('fields' => array('Motivo.id', 'Motivo.nome'))))
          )
        ),
        'dtinicio' => array(
          'Indisponibilidade.dt_inicio' => array(
            'operator' => 'BETWEEN',
            'between' => array(
              'text' => ' a ',
            )
          )
        ),
        'dtfim' => array(
          'Indisponibilidade.dt_fim' => array(
            'operator' => 'BETWEEN',
            'between' => array(
              'text' => ' a ',
            )
          )
        )
      )
    );

    // Define conditions
    $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
    if(sizeof($this->Filter->getConditions()) > 0):
      /**
      * 'Hack' para HABTM
      */
      $cond = $this->Filter->getConditions();
      if(sizeof($cond[0]) > 0):  //Conditions 0 corresponde ao serviço
        $this->Indisponibilidade->bindModel(array(
               'hasOne' => array(
                  '_IndisponibilidadesServico' => array(
                    'className'  => 'IndisponibilidadesServico',
                    'foreignKey' => 'indisponibilidade_id',
                  ),
                  '_Servico' => array(
                    'className'  => 'Servico',
                    'foreignKey' => false,
                    'conditions' => '_Servico.id = _IndisponibilidadesServico.servico_id',
                    'fields' => 'id'
                  )
                )
        ));
      endif;
    endif;


    $this->Indisponibilidade->recursive = 1;
    $this->set('Indisponibilidades', $this->paginate());
    //$this->set('Indisponibilidades', $this->Indisponibilidade->find('all'));
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function view($id = null) {
    if (!$this->Indisponibilidade->exists($id)) {
      throw new NotFoundException(__('Indisponibilidade Inválida.'));
    }
    $options = array('conditions' => array('Indisponibilidade.' . $this->Indisponibilidade->primaryKey => $id));
    $this->set('Indisponibilidade', $this->Indisponibilidade->find('first', $options));
  }

/**
 * add method
 *
 * @return void
 */
  public function add() {
    if ($this->request->is('post')) {
      $this->Indisponibilidade->create();
      if ($this->Indisponibilidade->save($this->request->data)) {
        $this->Session->setFlash('Indisponibilidade Criado com Sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('controller' => 'indisponibilidades', 'action' => 'index' ));
      } else {
        $this->Session->setFlash('Não foi possível criar o novo Indisponibilidade.', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    }
    /* Relacionamentos */
    $servicos = $this->Indisponibilidade->Servico->find('list', array('fields' => array('Servico.id', 'Servico.nome', 'Servico.tecnologia')));
    $this->set(compact('servicos'));
    $motivos = $this->Indisponibilidade->Motivo->find('list', array('fields' => array('Motivo.id', 'Motivo.nome')));
    $this->set(compact('motivos'));
  }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param int id
 * @return void
 */
  public function edit($id = null) {
    if (!$this->Indisponibilidade->exists($id)) {
      throw new NotFoundException(__('Indisponibilidade inválida!'));
    }
    if ($this->request->is('post') || $this->request->is('put')) {
      if ($this->Indisponibilidade->save($this->request->data)) {
        $this->Session->setFlash('Indisponibilidade atualizada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
        return $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash('A indisponibilidade não pode ser atualizada!', 'alert-box', array ('class' => 'alert alert-danger'));
      }
    } else {
      $options = array('conditions' => array('Indisponibilidade.' . $this->Indisponibilidade->primaryKey => $id));
      $this->request->data = $this->Indisponibilidade->find('first', $options);
    }

    /* Relacionamentos */
    $servicos = $this->Indisponibilidade->Servico->find('list', array('fields' => array('Servico.id', 'Servico.nome', 'Servico.tecnologia')));
    $this->set(compact('servicos'));
    $motivos = $this->Indisponibilidade->Motivo->find('list', array('fields' => array('Motivo.id', 'Motivo.nome')));
    $this->set(compact('motivos'));
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
    $this->Indisponibilidade->id = $id;

    if (!$this->Indisponibilidade->exists()) {
      throw new NotFoundException(__('Indisponibilidade inválido'));
    }
    $this->request->onlyAllow('post', 'delete');
    if ($this->Indisponibilidade->delete()) {
      $this->Session->setFlash('Indisponibilidade  com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
    } else {
      $this->Session->setFlash('Indisponibilidade  com id: %s  não foi removido.', 'alert-box', array ('class' => 'alert alert-danger'), h($id));
    }
    return $this->redirect(array('controller' => 'indisponibilidades', 'action' => 'index'));
  }

  /**
  * Form inline
  */
  public function ajax_edit_status(){
    $this->autoRender = false;
    $this->layout = 'ajax';

    if ($this->request->data) {
        $this->Indisponibilidade->id = $this->request->data('id');;
        $this->Indisponibilidade->saveField('dt_fim', date('Y-m-d g:i:s'));

        if($this->request->data('dt_fim') != null):
          return "<span class='label label-success'>Aberto</span>";
        else:
          return "<span class='label label-default'>Fechado</span>";
        endif;

    }
  }
}

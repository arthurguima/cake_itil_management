<?php class RdmsController extends AppController {
  public $helpers = array('Html', 'Form');

  public function index(){
    // Add filter
    $this->Filter->addFilters(
      array(
        'nome_' => array(
          'Rdm.nome' => array('operator' => 'LIKE')
        ),
        'versao_' => array(
          'Rdm.versao' => array('operator' => 'LIKE')
        ),
        'servico' => array(
          'Rdm.servico_id' => array(
            'select' => $this->Filter->select('Serviço', $this->Rdm->Servico->find('list', array('fields' => array('Servico.id', 'Servico.sigla'))))
          )
        ),
        'ambiente_' => array(
          'Rdm.ambiente' => array(
            'select' => $this->Filter->select('Ambiente', array(1 => 'Homologação', 2 => 'Produção') )
          )
        ),
        'tipo' => array(
          'Rdm.rdm_tipo_id' => array(
            'select' => $this->Filter->select('Tipo de RDM', $this->Rdm->RdmTipo->find('list', array('fields' => array('RdmTipo.id', 'RdmTipo.nome'))))
          )
        ),
        'numero_' => array(
          'Rdm.numero' => array('operator' => '='),
        ),
        'dtprevista' => array(
          'Rdm.dt_prevista' => array(
            'operator' => 'BETWEEN',
            'between' => array(
              'text' => ' a ',
            )
          )
        ),
        'dtexecutada' => array(
          'Rdm.dt_executada' => array(
            'operator' => 'BETWEEN',
            'between' => array(
              'text' => ' a ',
            )
          )
        )
      )
    );
    //$this->Filter->addFilters('filtro');

    // Define conditions
    $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
    $this->Filter->setPaginate('limit', 3000);

    $this->Rdm->recursive = 0;
    $this->set('rdms', $this->paginate());
  }

  public function view($id = null){
  if (!$this->Rdm->exists($id)) {
      throw new NotFoundException(__('Rdm Inválida'));
    }
    $options = array('conditions' => array('Rdm.' . $this->Rdm->primaryKey => $id));
    $this->Rdm->recursive = 2;
    $this->set('rdm', $this->Rdm->find('first', $options));
  }

  public function edit($id = null){
    if (!$id) { throw new NotFoundException(__('Rdm Inválida'));}

    $sistema = $this->Rdm->findById($id);
    if (!$sistema){ throw new NotFoundException(__('Rdm Inválida'));}

    if ($this->request->is(array('Rdm', 'put'))) {
        $this->Rdm->id = $id;
        if ($this->Rdm->save($this->request->data)) {
            $this->Session->setFlash('Rdm atualizada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível atualizar a rdm.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    if (!$this->request->data) {
        $this->request->data = $sistema;
    }

    /* Relacionamentos */
    $this->set('demandas',
                $this->Rdm->Demanda->find('list', array(
                  'fields' => array('Demanda.id', 'Demanda.clarity_dm_id'),
                  'conditions' => array('Demanda.servico_id' => $this->data['Rdm']['servico_id']))));

    $rdmTipos = $this->Rdm->RdmTipo->find('list', array('fields' => array('RdmTipo.id', 'RdmTipo.nome')));
    $this->set(compact('rdmTipos'));
  }

  public function add() {

    if ($this->request->is('post')) {

      $this->Rdm->create();
      if ($this->Rdm->save($this->request->data)) {
        $this->Session->setFlash('Rdm criada com sucesso!', 'alert-box', array ('class' => 'alert alert-success'));
          return $this->redirect(array('action' => 'index'));
      }
      $this->Session->setFlash('Não foi possível criar a nova rdm.', 'alert-box', array ('class' => 'alert alert-danger'));
    }

    /* Relacionamentos */
    $servicos = $this->Rdm->Servico->find('list', array('fields' => array('Servico.id', 'Servico.nome', 'Servico.tecnologia')));
    $this->set(compact('servicos'));

    $rdmTipos = $this->Rdm->RdmTipo->find('list', array('fields' => array('RdmTipo.id', 'RdmTipo.nome')));
    $this->set(compact('rdmTipos'));
  }

  public function delete($id) {
    if ($this->request->is('get')) {
        throw new MethodNotAllowedException();
    }

    if ($this->Rdm->delete($id)) {
        $this->Session->setFlash('A rdm com id: %s foi removido.', 'alert-box', array ('class' => 'alert alert-success'), h($id));
        return $this->redirect(array('action' => 'index'));
    }
  }
}?>

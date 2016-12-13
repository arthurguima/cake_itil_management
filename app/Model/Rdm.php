<?php class Rdm extends AppModel {

  public $hasAndBelongsToMany = array(
    'Demanda' => array(
      'className' => 'Demanda',
      'joinTable' => 'demandas_rdms',
      'foreignKey' => 'rdm_id',
      'associationForeignKey' => 'demanda_id',
    ),
    'Chamado' => array('className' => 'Chamado')
  );

  public $belongsTo = array(
    'Servico' => array(
      'className' => 'Servico',
      'foreignKey' => 'servico_id'
    ),
    'RdmTipo' => array(
      'className' => 'RdmTipo',
      'foreignKey' => 'rdm_tipo_id'
    ),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		),
  );

  public $hasMany = array(
    'Historico' => array(
      'className' => 'Historico',
      'order' => array("Historico.data" => "ASC", "Historico.created" => "ASC")
    ),
    'Subtarefa' => array(
			'className' => 'Subtarefa',
			'order' => array("Subtarefa.dt_prevista" => "ASC", "Subtarefa.created" => "ASC")
		)
  );
  public $hasOne = array(
    'Release' => array(
      'className' => 'Release',
      //'order' => array("Historico.data" => "ASC", "Historico.created" => "ASC")
    )
  );

  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!'),
      'between' => array(
                'rule'    => array('between', 3, 300),
                'message' => 'O campo deve conter de 3 a 110 caracteres!'
    )),
    'solicitante' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!'),
      'between' => array(
                'rule'    => array('between', 3, 150),
                'message' => 'O campo deve conter de 3 a 150 caracteres!'
    )),
    'user_id' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!'),
    ),
    'servico_id' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!')
    ),
    'dt_prevista' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!')
    ),
    'ano' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!')
    ),
    'numero' => array(
			'unique' => array(
				'rule' => array('checkUnique', array('numero', 'ano', 'servico_id'), false),
        'required' => 'true',
				'on' => 'create',
				'message' => 'Já existe outra RDM com esse número para esse ano casdastrada!'
			),
      'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Apenas Letra e Números.'
      ),
		),
  );

  public function beforeValidate($options = array()){
    if(!empty($this->data['Rdm']['dt_prevista'])) {
        $this->data['Rdm']['dt_prevista'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Rdm']['dt_prevista'])));
    }
    if(!empty($this->data['Rdm']['dt_executada'])) {
        $this->data['Rdm']['dt_executada'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Rdm']['dt_executada'])));
    }
    return true;
  }

  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $val) {
        if (isset($val['Rdm']['dt_prevista'])) {
            $results[$key]['Rdm']['dt_prevista'] = $this->dateFormatAfterFind(
                $val['Rdm']['dt_prevista']
            );
        }
        if (isset($val['Rdm']['dt_executada'])) {
            $results[$key]['Rdm']['dt_executada'] = $this->dateFormatAfterFind(
                $val['Rdm']['dt_executada']
            );
        }
    }
    return $results;
  }

  public function dateFormatAfterFind($dateString) {
      return date('d/m/Y', strtotime($dateString));
  }
}?>

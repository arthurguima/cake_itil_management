<?php class Chamado extends AppModel {

	public $belongsTo = array(
		'Demanda' => array(
			'className' => 'Demanda',
			'foreignKey' => 'demanda_id'
		),
		'ChamadoTipo' => array(
			'className' => 'ChamadoTipo'
		),
		'Servico' => array(
			'className' => 'Servico',
			'foreignKey' => 'servico_id'
		),
		'Status' => array(
			'className' => 'Status',
			'foreignKey' => 'status_id'
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		),
	);

	public $hasAndBelongsToMany = array(
		'Rdm' => array('className' => 'Rdm')
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

	public $validate = array(
		'servico_id' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!')
		),
		'user_id' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!')
		),
		'numero' => array(
			'unique' => array(
				'rule' => array('checkUnique', array('numero', 'ano', 'servico_id'), false),
        'required' => 'true',
				'on' => 'create',
				'message' => 'Já existe outro Chamado com esse número para esse ano casdastrado!'
			),
			'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Apenas Letra e Números.'
      ),
		)
	);

	public function afterFind($results, $primary = false) {
    foreach ($results as $key => $val) {
				if (isset($val['Chamado']['dt_resolv'])) {
						$results[$key]['Chamado']['dt_resolv'] = $this->dateFormatAfterFind(
								$val['Chamado']['dt_resolv']
						);
				}
        if (isset($val['Chamado']['dt_prev_resolv'])) {
            $results[$key]['Chamado']['dt_prev_resolv'] = $this->dateFormatAfterFind(
                $val['Chamado']['dt_prev_resolv']
            );
        }
				if (isset($val['Chamado']['created'])) {
						$results[$key]['Chamado']['created'] = $this->dateFormatAfterFind(
								$val['Chamado']['created']
						);
				}
    }
    return $results;
	}

	public function dateFormatAfterFind($dateString) {
	    return date('d/m/Y', strtotime($dateString));
	}

	public function beforeValidate($options = array()){
		if(!empty($this->data['Chamado']['dt_resolv'])) {
				$this->data['Chamado']['dt_resolv'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Chamado']['dt_resolv'])));
		}
		if(!empty($this->data['Chamado']['dt_prev_resolv'])) {
				$this->data['Chamado']['dt_prev_resolv'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Chamado']['dt_prev_resolv'])));
		}
		return true;
	}
}

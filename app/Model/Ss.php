<?php class Ss extends AppModel {


	public $hasMany = array(
		'Historico' => array(
			'className' => 'Historico',
			'foreignKey' => 'ss_id',
			'dependent' => false,
			'conditions' => '',
			'order' => array("Historico.data" => "ASC", "Historico.created" => "ASC")
		),
		'Pe' => array(
			'className' => 'Pe',
			'foreignKey' => 'ss_id',
			'dependent' => false,
			'conditions' => '',
		),
		'Ord' => array(
			'className' => 'Ord',
			'foreignKey' => 'ss_id',
			'dependent' => false,
			'conditions' => '',
		)
	);

	public $hasAndBelongsToMany = array(
		'Demanda' => array(
			'className' => 'Demanda',
			'joinTable' => 'demandas_sses',
			'foreignKey' => 'ss_id',
			'associationForeignKey' => 'demanda_id',
		)
	);

	public $belongsTo = array(
		'Servico' => array(
			'className' => 'Servico'
		),
		'Status' => array(
			'className' => 'Status'
		)
	);

	public $validate = array(
		'nome' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!'),
			'between' => array(
								'rule'    => array('between', 3, 110),
								'message' => 'O campo deve conter de 3 a 110 caracteres!'
		)),
		'observacao' => array(
			'between' => array(
								'rule'    => array('between', 3, 1000),
								'message' => 'O campo deve conter de 3 a 1000 caracteres!'
		)),
		'numero' => array(
			'unique' => array(
				'rule' => array('checkUnique', array('numero', 'ano', 'servico_id'), false),
				'required' => 'create',
				'message' => 'Já existe outra SS com esse número, nesse ano, para esse serviço.'
			)
		),
		'responsavel' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!')
		),
		'clarity_dm_id' => array(
			'allowEmpty' => true,
			'unique' => array(
				'rule' => 'isUnique',
				'required' => 'create',
				'message' => 'Já existe outra SS com esse DM Clarity'
			)
		),
		'servico_id' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!')
		),
		'dt_recebimento' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!')
		)
	);

	public function beforeValidate($options = array()){
		if(!empty($this->data['Ss']['dt_recebimento'])) {
				$this->data['Ss']['dt_recebimento'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ss']['dt_recebimento'])));
		}
		if(!empty($this->data['Ss']['dt_prevista'])) {
				$this->data['Ss']['dt_prevista'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ss']['dt_prevista'])));
		}
		if(!empty($this->data['Ss']['dt_prazo'])) {
				$this->data['Ss']['dt_prazo'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ss']['dt_prazo'])));
		}
		if(!empty($this->data['Ss']['dt_finalizada'])) {
				$this->data['Ss']['dt_finalizada'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ss']['dt_finalizada'])));
		}
		return true;
	}

	public function afterFind($results, $primary = false) {
		foreach ($results as $key => $val) {
				if (isset($val['Ss']['dt_recebimento'])) {
						$results[$key]['Ss']['dt_recebimento'] = $this->dateFormatAfterFind(
								$val['Ss']['dt_recebimento']
						);
				}
				if (isset($val['Ss']['dt_prevista'])) {
						$results[$key]['Ss']['dt_prevista'] = $this->dateFormatAfterFind(
								$val['Ss']['dt_prevista']
						);
				}
				if (isset($val['Ss']['dt_prazo'])) {
						$results[$key]['Ss']['dt_prazo'] = $this->dateFormatAfterFind(
								$val['Ss']['dt_prazo']
						);
				}
				if (isset($val['Ss']['dt_finalizada'])) {
						$results[$key]['Ss']['dt_finalizada'] = $this->dateFormatAfterFind(
								$val['Ss']['dt_finalizada']
						);
				}
		}
		return $results;
	}

	public function dateFormatAfterFind($dateString) {
			return date('d/m/Y', strtotime($dateString));
	}
}

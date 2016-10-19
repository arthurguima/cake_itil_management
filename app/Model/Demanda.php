<?php class Demanda extends AppModel {

	public $belongsTo = array(
		'Servico' => array(
			'className' => 'Servico'
			//'foreignKey' => 'servico_id'
		),
		'DemandaTipo' => array(
			'className' => 'DemandaTipo'
		),
		'Status' => array(
			'className' => 'Status',
			'foreignKey' => 'status_id'
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		),
		'DemandaPai' => array(
			'className' => 'Demanda',
			'foreignKey' => 'demanda_id'
		),
	);

	public $hasAndBelongsToMany = array(
		'Rdm' => array(
			'className' => 'Rdm',
			'joinTable' => 'demandas_rdms',
			'foreignKey' => 'demanda_id',
			'associationForeignKey' => 'rdm_id',
		),
		'Ss' => array(
			'className' => 'Ss',
			'joinTable' => 'demandas_sses',
			'foreignKey' => 'demanda_id',
			'associationForeignKey' => 'ss_id',
		)
	);

	public $hasMany = array(
		'Chamado' => array(
			'className' => 'Chamado',
		),
		'DemandaFilha' => array(
			'className' => 'Demanda',
			'foreignKey' => 'demanda_id'
		),
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
		'nome' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'maxLength' => 110,
				'message' => 'Campo deve ser preenchido!')
		),
		'data_homologacao' => array(
			'MaiorQueDataInicial' => array(
					"allowEmpty"=> true,
					'rule' => array('compareFields', '>', 'data_cadastro'),
					'message' => 'Data de homologação deve ser posterior a data de Cadastro!'
			)
		),
		'data_cadastro' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!')
		),
		'prioridade' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!')
		),
		'user_id' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!')
		),
		'descricao' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'maxLength' => 250,
				'message' => 'Campo deve ser preenchido!')
		),
		'clarity_dm_id' => array(
			'unique' => array(
				'rule' => 'isUnique',
				'required' => 'true',
				'on' => 'create',
				'message' => 'Já existe outra demanda com esse DM ID casdastrada!'
			)
		),
		'clarity_id' => array(
			'unique' => array(
				'rule' => 'isUnique',
				'required' => 'true',
				'on' => 'create',
				'message' => 'Já existe outra demanda com esse ID casdastrada!'
			)
		),
		'servico_id' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!')
		)
	);

	public function afterFind($results, $primary = false) {
    foreach ($results as $key => $val) {
        if (isset($val['Demanda']['data_homologacao'])) {
            $results[$key]['Demanda']['data_homologacao'] = $this->dateFormatAfterFind(
                $val['Demanda']['data_homologacao']
            );
        }
				if (isset($val['Demanda']['data_cadastro'])) {
						$results[$key]['Demanda']['data_cadastro'] = $this->dateFormatAfterFind(
								$val['Demanda']['data_cadastro']
						);
				}
				if (isset($val['Demanda']['dt_prevista'])) {
						$results[$key]['Demanda']['dt_prevista'] = $this->dateFormatAfterFind(
								$val['Demanda']['dt_prevista']
						);
				}
    }
    return $results;
	}

	public function dateFormatAfterFind($dateString) {
	    return date('d/m/Y', strtotime($dateString));
	}

	public function beforeValidate($options = array()){
		if(!empty($this->data['Demanda']['data_homologacao'])) {
				$this->data['Demanda']['data_homologacao'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Demanda']['data_homologacao'])));
		}
		if(!empty($this->data['Demanda']['data_cadastro'])) {
				$this->data['Demanda']['data_cadastro'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Demanda']['data_cadastro'])));
		}
		if(!empty($this->data['Demanda']['dt_prevista'])) {
				$this->data['Demanda']['dt_prevista'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Demanda']['dt_prevista'])));
		}
		return true;
	}

	public function beforeSave($options = array()){
    $this->data['Demanda']['last_edit_by'] = $_SESSION['User']['uid'];
    return true;
  }
}?>

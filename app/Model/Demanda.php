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
		)
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
		'Historico' => array(
			'className' => 'Historico',
		)
	);

	public $validate = array(
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
		'descricao' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'maxLength' => 250,
				'message' => 'Campo deve ser preenchido!')
		),
		'criador' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!')
		),
		'clarity_dm_id' => array(
			'unique' => array(
				'rule' => 'isUnique',
				'required' => 'create',
				'message' => 'Já existe outra demanda com esse DM ID casdastrada!'
			)
		)
	);

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
}?>

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
}?>

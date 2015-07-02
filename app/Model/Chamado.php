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
	);
}

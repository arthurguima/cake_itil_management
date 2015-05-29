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
		)
	);

	public $hasMany = array(
		'Historico' => array(
			'className' => 'Historico',
			'order' => array("Historico.data" => "ASC", "Historico.created" => "ASC")
		)
	);
}

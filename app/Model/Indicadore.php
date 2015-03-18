<?php class Indicadore extends AppModel {

	public $belongsTo = array(
		'Contrato' => array(
			'className' => 'Contrato',
			'foreignKey' => 'contrato_id'
		),
		'Aditivo' => array(
			'className' => 'Aditivo',
			'foreignKey' => 'aditivo_id'
		),
		'Regra' => array(
			'className' => 'Regra',
			'foreignKey' => 'regra_id'
		),
		'Servico' => array(
			'className' => 'Servico',
			'foreignKey' => 'servico_id'
		)
	);

	public $hasMany = array(
	);

	public $validate = array(
		
	);
}?>

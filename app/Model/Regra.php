<?php class Regra extends AppModel {

	public $belongsTo = array(
		'Contrato' => array(
			'className' => 'Contrato',
			'foreignKey' => 'contrato_id'
		),
		'Aditivo' => array(
			'className' => 'Aditivo',
			'foreignKey' => 'aditivo_id'
		),
		'Servico' => array(
			'className' => 'Servico',
			'foreignKey' => 'servico_id'
		)
	);

	public $hasMany = array(

	);

	public $validate = array(
		'nome' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'maxLength' => 200,
				'message' => 'Campo deve ser preenchido!')
		),
		'servico_id' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!')
		)
	);
}?>

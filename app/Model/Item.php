<?php class Item extends AppModel {

	public $belongsTo = array(
		'Contrato' => array(
			'className' => 'Contrato',
			'foreignKey' => 'contrato_id'
		),
		'Aditivo' => array(
			'className' => 'Aditivo',
			'foreignKey' => 'aditivo_id'
		)
	);

	public $hasMany = array(
		'Pe' => array(
			'className' => 'Pe',
			'foreignKey' => 'item_id',
			'dependent' => false,
		),
		'ItemPe' => array(
			'className' => 'ItemPe',
			'foreignKey' => 'item_id',
		)
	);

	public $validate = array(
		'nome' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'maxLength' => 50,
				'message' => 'Campo deve ser preenchido!')
		),
		'metrica' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'maxLength' => 50,
				'message' => 'Campo deve ser preenchido!')
		),
		'contrato_id' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'maxLength' => 50,
				'message' => 'Campo deve ser preenchido!')
		)
	);
}?>

<?php class ItemPe extends AppModel {

	public $belongsTo = array(
		'Contrato' => array(
			'className' => 'Contrato',
			'foreignKey' => 'contrato_id'
		),
		'Aditivo' => array(
			'className' => 'Aditivo',
			'foreignKey' => 'aditivo_id'
		),
		'Item' => array(
			'className' => 'Item',
			'foreignKey' => 'item_id'
		),
		'Pe' => array(
			'className' => 'Pe',
			'foreignKey' => 'item_id',
		),
		'Ord' => array(
			'className' => 'Ord',
			'foreignKey' => 'item_id',
		),
	);

	public $hasMany = array();

	public $validate = array();
}?>

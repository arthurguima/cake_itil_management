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
			'foreignKey' => 'pe_id',
		),
		'Ord' => array(
			'className' => 'Ord',
			'foreignKey' => 'ord_id',
		),
	);

	public $hasMany = array();

	public $validate = array();
}?>

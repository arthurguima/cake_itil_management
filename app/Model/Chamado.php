<?php class Chamado extends AppModel {

	public $belongsTo = array(
		'Demanda' => array(
			'className' => 'Demanda',
			'foreignKey' => 'demanda_id'
		)
	);
}

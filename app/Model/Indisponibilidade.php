<?php class Indisponibilidade extends AppModel {


	var $actsAs = array('Containable');

	public $belongsTo = array(
		'Motivo' => array(
			'className' => 'Motivo',
			'foreignKey' => 'motivo_id'
		)
	);

	public $hasAndBelongsToMany = array(
		'Servico' => array('className' => 'Servico')
	);
	
  public $validate = array(
    'dt_inicio' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 45,
        'message' => 'Campo deve ser preenchido'
      ),
    ),
	'motivo_id' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 45,
        'message' => 'Campo deve ser preenchido'
      ),
    )
  );
}?>

<?php class Release extends AppModel {

  public $belongsTo = array(
    'Servico' => array(
      'className' => 'Servico',
      'foreignKey' => 'servico_id'
    ),
    'Rdm' => array(
      'className' => 'Rdm',
      'foreignKey' => 'rdm_id'
    )
  );

  public $hasMany = array(
    'Note' => array(
      'className' => 'Note',
      'foreignKey' => 'release_id'
    )
  );

  public $validate = array(
    'versao' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!'),
			'between' => array(
                'rule'    => array('between', 3, 40),
                'message' => 'O campo deve conter de 3 a 40 caracteres!')
		),
    'observacao' => array(
			'between' => array(
                'rule'    => array('between', 0, 450),
                'message' => 'O campo deve conter de 0 a 450 caracteres!')
		),
    'servico_id' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!'),
		),
    'rdm_id' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!'),
		)
  );
}?>

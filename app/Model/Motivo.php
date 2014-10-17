<?php class Motivo extends AppModel {

    public $hasMany = array(
    'Indisponibilidade' => array(
      'className' => 'Indisponibilidade',
      'foreignKey' => 'motivo_id'
    )
  );

  public $validate = array(
    'nome' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!'),
			'between' => array(
                'rule'    => array('between', 3, 50),
                'message' => 'O campo deve conter de 3 a 50 caracteres!'
		))
  );
}?>
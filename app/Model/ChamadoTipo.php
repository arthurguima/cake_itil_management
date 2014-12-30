<?php class ChamadoTipo extends AppModel {

  public $hasMany = array(
    'Chamado' => array(
      'className' => 'Chamado'
    )
  );

  public $belongsTo = array(
    'Servico' => array(
      'className' => 'Servico'
    )
  );

  public $validate = array(
		'nome' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!'),
			'between' => array(
                'rule'    => array('between', 3, 60),
                'message' => 'O campo deve conter de 3 a 60 caracteres!'
		))
	);


}?>

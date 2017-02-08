<?php class DemandaTipo extends AppModel {

  public $order = array("DemandaTipo.nome" => "ASC");

  public $hasMany = array(
    'Demanda' => array(
      'className' => 'Demanda'
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

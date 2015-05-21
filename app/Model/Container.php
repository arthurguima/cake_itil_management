<?php class Container extends AppModel {

    public $belongsTo = array(
    'Servico' => array(
      'className' => 'Servico',
      'foreignKey' => 'servico_id'
    )
  );

  public $validate = array(
    'nome' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!'),
			'between' => array(
                'rule'    => array('between', 3, 30),
                'message' => 'O campo deve conter de 3 a 15 caracteres!'
		))
  );
}?>

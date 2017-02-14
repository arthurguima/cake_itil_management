<?php class Grupotarefa extends AppModel {

    public $order = array("Grupotarefa.nome" => "ASC");

    public $hasMany = array(
    'GrupotarefaItem' => array(
      'className' => 'GrupotarefaItem',
      'foreignKey' => 'grupotarefa_id'
    )
  );

  public $validate = array(
    'nome' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!'),
			'between' => array(
                'rule'    => array('between', 3, 40),
                'message' => 'O campo deve conter de 3 a 50 caracteres!'
		)),
    'nome' => array(
      'unique' => array(
				'rule' => 'isUnique',
				'required' => 'false',
				'message' => 'Já existe outro grupo com esse marcador!'
			)
    )
  );
}?>

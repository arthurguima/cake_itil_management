<?php class Area extends AppModel {

  public $hasAndBelongsToMany = array(
    'Servico' =>
        array('className' => 'Servico')
  );

  public $belongsTo = array(
    'Cliente' => array(
      'className' => 'Cliente',
      'foreignKey' => 'cliente_id'
    )
  );

  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 100,
        'message' => 'Campo deve ser preenchido!'
      )
    ),
    'sigla' => array(
      'rule' => 'notempty',
      'maxLength' => 50,
      'message' => 'Campo deve ser preenchido!'
    ),
    'cliente' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 45,
        'message' => 'Campo deve ser preenchido!'
      )
    )
  );
}?>

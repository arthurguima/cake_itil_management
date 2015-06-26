<?php class User extends AppModel {

  public $hasAndBelongsToMany = array(
    'Cliente' => array()
  );

  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 150,
        'message' => 'Campo deve ser preenchido!'
      )
    ),
    'matricula' => array(
      'rule' => 'notempty',
      'message' => 'Campo deve ser preenchido!'
    ),
    'Cliente' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!'
      )
    )
  );
}?>

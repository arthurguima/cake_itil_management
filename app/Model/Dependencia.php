<?php class Dependencia extends AppModel {

  public $hasAndBelongsToMany = array(
    'Servico' =>
        array('className' => 'Servico')
  );

  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 100,
        'message' => 'Campo deve ser preenchido!'
      )
    )
  );
}?>

<?php class Historico extends AppModel {

  public $belongsTo = array(
    'Demanda' => array(
      'className' => 'Demanda',
      'foreignKey' => 'demanda_id'
    )
  );

  public $validate = array(
    'analista' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 50,
        'message' => 'Campo deve ser preenchido!')
    ),
  );
}?>

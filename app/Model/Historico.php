<?php class Historico extends AppModel {

  public $belongsTo = array(
    'Demanda' => array(
      'className' => 'Demanda',
      'foreignKey' => 'demanda_id'
    ),
    'Rdm' => array(
      'className' => 'Rdm',
      'foreignKey' => 'rdm_id'
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

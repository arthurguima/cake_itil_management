<?php class Cliente extends AppModel {

  public $hasMany = array(
    'Area' => array(
      'className' => 'Area',
      'foreignKey' => 'cliente_id',
      'dependent' => false,
    )
  );

  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 80,
        'message' => 'Campo deve ser preenchido!')
    ),
    'sigla' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 20,
        'message' => 'Campo deve ser preenchido!')
    )
  );
}?>

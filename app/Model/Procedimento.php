<?php class Procedimento extends AppModel {
  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 70,
        'message' => 'Campo deve ser preenchido! (Máximo de 70 caracteres)'
      )
    ),
    'url' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 70,
        'message' => 'Campo deve ser preenchido! (Máximo de 70 caracteres)'
      )
    )
  );
}?>

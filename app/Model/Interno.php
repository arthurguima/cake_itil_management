<?php class Interno extends AppModel {
  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 70,
        'message' => 'Campo deve ser preenchido! (Máximo de 70 caracteres)'
      )
    ),
    'descricao' => array(
      'rule' => 'notempty',
      'maxLength' => 300,
      'message' => 'Campo deve ser preenchido! (Máximo de 300 caracteres)'
    ),
    'instrucoes' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 300,
        'message' => 'Campo deve ser preenchido! (Máximo de 300 caracteres)'
      )
    ),
    'url' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 190,
        'message' => 'Campo deve ser preenchido! (Máximo de 150 caracteres)'
      )
    )
  );
}?>

<?php class Responsabilidade extends AppModel {
  public $validate = array(
    'processo' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 80,
        'message' => 'Campo deve ser preenchido! (Máximo de 80 caracteres)'
      )
    ),
    'responsavel' => array(
      'rule' => 'notempty',
      'maxLength' => 80,
      'message' => 'Campo deve ser preenchido! (Máximo de 80 caracteres)'
    ),
    'area' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 80,
        'message' => 'Campo deve ser preenchido! (Máximo de 80 caracteres)'
      )
    )
  );
}?>

<?php class Status extends AppModel {

  public $hasMany = array(
    'Demanda' => array(
      'className' => 'Demanda'
    ),
    'Ss' => array(
      'className' => 'Ss'
    ),
    'Ord' => array(
      'className' => 'Ord'
    ),
    'Pe' => array(
      'className' => 'Pe'
    ),
    'Chamado' => array(
      'className' => 'Chamado'
    )
  );

  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!'),
      'between' => array(
                'rule'    => array('between', 3, 50),
                'message' => 'O campo deve conter de 3 a 50 caracteres!'
    )),
    'sigla' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!'),
      'between' => array(
                'rule'    => array('between', 3, 50),
                'message' => 'O campo deve conter de 3 a 50 caracteres!'
    )),
    'tipo' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!')
    )
  );

  public function beforeSave($options = array()){
    if ($this->data['Status']['fim'] == 0)
    $this->data['Status']['fim'] = null;
    return true;
  }

}?>

<?php class Pe extends AppModel {

  public $belongsTo = array(
    'Servico' => array(
      'className' => 'Servico'
      //'foreignKey' => 'servico_id'
    ),
    'Item' => array(
      'className' => 'Item'
    ),
    'Status' => array(
      'className' => 'Status',
      'foreignKey' => 'status_id'
    ),
    'Ss' => array(
      'className' => 'Ss',
      'foreignKey' => 'ss_id'
    )
  );

  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!'),
      'between' => array(
                'rule'    => array('between', 3, 110),
                'message' => 'O campo deve conter de 3 a 110 caracteres!'
    )),
  );

  public function beforeValidate($options = array()){
    if(!empty($this->data['Pe']['dt_emissao'])) {
        $this->data['Pe']['dt_emissao'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Pe']['dt_emissao'])));
    }
    if(!empty($this->data['Pe']['dt_inicio'])) {
        $this->data['Pe']['dt_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Pe']['dt_inicio'])));
    }
    return true;
  }
}

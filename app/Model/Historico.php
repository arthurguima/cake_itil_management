<?php class Historico extends AppModel {

  public $belongsTo = array(
    'Demanda' => array(
      'className' => 'Demanda',
      'foreignKey' => 'demanda_id'
    ),
    'Rdm' => array(
      'className' => 'Rdm',
      'foreignKey' => 'rdm_id'
    ),
    'Pe' => array(
      'className' => 'Pe',
      'foreignKey' => 'pe_id'
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

  public function beforeValidate($options = array()){
    if(!empty($this->data['Historico']['data'])) {
        $this->data['Historico']['data'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Historico']['data'])));
    }
    return true;
  }
}?>

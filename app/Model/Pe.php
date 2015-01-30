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

  public $hasMany = array(
    'Historico' => array(
      'className' => 'Historico'
    )
  );

  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido!'),
      'between' => array(
                'rule'    => array('between', 3, 120),
                'message' => 'O campo deve conter de 3 a 120 caracteres!'
    )),
  );

  public function beforeValidate($options = array()){
    if(!empty($this->data['Pe']['dt_emissao'])) {
        $this->data['Pe']['dt_emissao'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Pe']['dt_emissao'])));
    }
    if(!empty($this->data['Pe']['dt_inicio'])) {
        $this->data['Pe']['dt_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Pe']['dt_inicio'])));
    }
    if(!empty($this->data['Pe']['validade_pdd'])) {
        $this->data['Pe']['validade_pdd'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Pe']['validade_pdd'])));
    }
    return true;
  }

  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $val) {
        if (isset($val['Pe']['dt_emissao'])) {
            $results[$key]['Pe']['dt_emissao'] = $this->dateFormatAfterFind(
                $val['Pe']['dt_emissao']
            );
        }
        if (isset($val['Pe']['dt_inicio'])) {
            $results[$key]['Pe']['dt_inicio'] = $this->dateFormatAfterFind(
                $val['Pe']['dt_inicio']
            );
        }
        if (isset($val['Pe']['validade_pdd'])) {
            $results[$key]['Pe']['validade_pdd'] = $this->dateFormatAfterFind(
                $val['Pe']['validade_pdd']
            );
        }
    }
    return $results;
  }

  public function dateFormatAfterFind($dateString) {
      return date('d/m/Y', strtotime($dateString));
  }
}

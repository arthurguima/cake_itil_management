<?php class Contrato extends AppModel {

  public $hasMany = array(
    'Item' => array(
      'className' => 'Item',
      'foreignKey' => 'contrato_id',
      'dependent' => true
    ),
    'Aditivo' => array(
      'className' => 'Aditivo',
      'foreignKey' => 'contrato_id',
      'dependent' => true
    ),
    'ItemPe' => array(
      'className' => 'ItemPe'
    )
  );

  public $belongsTo = array(
    'Cliente' => array(
      'className' => 'Cliente',
      'foreignKey' => 'cliente_id'
    )
  );

  public $validate = array(
    'numero' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido'
      ),
      'Numeric' => array(
        'rule' => 'numeric',
        'message' => 'Apenas Números!'
      )
    ),

    'data_ini' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido'
      )
    ),

    'data_fim' => array(
      'MaiorQueDataInicial' => array(
          'rule' => array('compareFields', '>', 'data_ini'),
          'message' => 'Data de término deve ser posterior a data de Início!'
      )
    )
  );

  public function beforeValidate($options = array()){
    if(!empty($this->data['Contrato']['data_ini'])) {
        $this->data['Contrato']['data_ini'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Contrato']['data_ini'])));
    }
    if(!empty($this->data['Contrato']['data_fim'])) {
        $this->data['Contrato']['data_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Contrato']['data_fim'])));
    }
    return true;
  }

  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $val) {
        if (isset($val['Contrato']['data_ini'])) {
            $results[$key]['Contrato']['data_ini'] = $this->dateFormatAfterFind(
                $val['Contrato']['data_ini']
            );
        }
        if (isset($val['Contrato']['data_fim'])) {
            $results[$key]['Contrato']['data_fim'] = $this->dateFormatAfterFind(
                $val['Contrato']['data_fim']
            );
        }
    }
    return $results;
  }

  public function dateFormatAfterFind($dateString) {
      return date('d/m/Y', strtotime($dateString));
  }
}?>

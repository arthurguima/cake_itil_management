<?php class Aditivo extends AppModel {

  public $belongsTo = array(
    'Contrato' => array(
      'className' => 'Contrato',
      'foreignKey' => 'contrato_id'
    )
  );
  public $hasMany = array(
    'Item' => array(
      'className' => 'Item',
      'foreignKey' => 'aditivo_id',
      'dependent' => true
    ),
    'ItemPe' => array(
      'className' => 'ItemPe'
    ),
    'Regra' => array(
      'className' => 'Regra'
    )
  );

  public $validate = array(
    'dt_fim' => array(
      'MaiorQueDataInicial' => array(
          'rule' => array('compareFields', '>', 'dt_inicio'),
          'message' => 'Data de término deve ser posterior a data de Início!'
      )
    )
  );

  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $val) {
        if (isset($val['Aditivo']['dt_fim'])) {
            $results[$key]['Aditivo']['dt_fim'] = $this->dateFormatAfterFind(
                $val['Aditivo']['dt_fim']
            );
        }
        if (isset($val['Aditivo']['dt_inicio'])) {
            $results[$key]['Aditivo']['dt_inicio'] = $this->dateFormatAfterFind(
                $val['Aditivo']['dt_inicio']
            );
        }
    }
    return $results;
  }

  public function dateFormatAfterFind($dateString) {
      return date('d/m/Y', strtotime($dateString));
  }

  public function beforeValidate($options = array()){
    if(!empty($this->data['Aditivo']['dt_inicio'])) {
        $this->data['Aditivo']['dt_inicio'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Aditivo']['dt_inicio'])));
    }
    if(!empty($this->data['Aditivo']['dt_fim'])) {
        $this->data['Aditivo']['dt_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Aditivo']['dt_fim'])));
    }
    return true;
  }
}?>

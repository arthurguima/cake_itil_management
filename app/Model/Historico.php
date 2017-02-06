<?php class Historico extends AppModel {

  public $order = array("Historico.data" => "ASC", "Historico.id" => "ASC");

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
    ),
    'Ord' => array(
      'className' => 'Ord',
      'foreignKey' => 'ord_id'
    ),
    'Chamado' => array(
      'className' => 'Chamado',
      'foreignKey' => 'chamado_id'
    ),
    'Indisponibilidade' => array(
      'className' => 'Indisponibilidade',
      'foreignKey' => 'indisponibilidade_id'
    ),
    'Release' => array(
      'className' => 'Release',
      'foreignKey' => 'release_id'
    ),
  );

  public $validate = array(
    'analista' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 50,
        'message' => 'Campo deve ser preenchido!')
    ),
    'data' => array(
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

  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $val) {
        if (isset($val['Historico']['data'])) {
            $results[$key]['Historico']['data'] = $this->dateFormatAfterFind(
                $val['Historico']['data']
            );
        }
    }
    return $results;
  }

  public function beforeSave($options = array()){
    $this->data['Historico']['last_edit_by'] = $_SESSION['User']['uid'];
    return true;
  }

  public function dateFormatAfterFind($dateString) {
      return date('d/m/Y', strtotime($dateString));
  }
}?>

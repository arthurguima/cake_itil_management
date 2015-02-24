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
        'maxLength' => 150,
        'message' => 'Campo deve ser preenchido! (Máximo de 150 caracteres)'
      )
    )
  );

  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $val) {
        if (isset($val['Procedimento']['dt_alteracao'])) {
            $results[$key]['Procedimento']['dt_alteracao'] = $this->dateFormatAfterFind(
                $val['Procedimento']['dt_alteracao']
            );
        }
    }
    return $results;
  }

  public function dateFormatAfterFind($dateString) {
      return date('d/m/Y', strtotime($dateString));
  }

  public function beforeValidate($options = array()){
    if(!empty($this->data['Procedimento']['dt_alteracao'])) {
        $this->data['Procedimento']['dt_alteracao'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Procedimento']['dt_alteracao'])));
    }
    return true;
  }
}?>

<?php class Subtarefa extends AppModel {

  public $order = array("Subtarefa.dt_prevista" => "ASC", "Subtarefa.id" => "ASC");

  public $belongsTo = array(
    'Demanda' => array(
      'className' => 'Demanda',
      'foreignKey' => 'demanda_id'
    )
  );

  public $validate = array(
    'descricao' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 250,
        'message' => 'Campo deve ser preenchido!')
    ),
    'demanda_id' => array(
      'rule'   => 'notempty',
    ),
		/*'dt_prevista' => array(
			'MaiorQueHoje' => array(
					"allowEmpty"=> true,
					'rule' => array('compareFields', '>=', date()),
					'message' => 'Data de prevista deve ser maior ou igual a data de hoje.'
			)*/
  );

  public function beforeValidate($options = array()){
    if(!empty($this->data['Subtarefa']['dt_prevista'])) {
        $this->data['Subtarefa']['dt_prevista'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Subtarefa']['dt_prevista'])));
    }
    return true;
  }

  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $val) {
        if (isset($val['Subtarefa']['dt_prevista'])) {
            $results[$key]['Subtarefa']['dt_prevista'] = $this->dateFormatAfterFind(
                $val['Subtarefa']['dt_prevista']
            );
        }
    }
    return $results;
  }

  public function dateFormatAfterFind($dateString) {
      return date('d/m/Y', strtotime($dateString));
  }
}?>

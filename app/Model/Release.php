<?php class Release extends AppModel {

  public $belongsTo = array(
    'Servico' => array(
      'className' => 'Servico',
      'foreignKey' => 'servico_id'
    ),
    'Rdm' => array(
      'className' => 'Rdm',
      'foreignKey' => 'rdm_id'
    ),
    'User' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    )
  );

  public $hasMany = array(
    'Note' => array(
      'className' => 'Note',
      'foreignKey' => 'release_id'
    ),
    'Subtarefa' => array(
			'className' => 'Subtarefa',
			'order' => array("Subtarefa.dt_prevista" => "ASC", "Subtarefa.created" => "ASC")
		),
    'Historico' => array(
      'className' => 'Historico',
      'order' => array("Historico.data" => "ASC", "Historico.created" => "ASC")
    ),
  );

  public $validate = array(
    'versao' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!'),
			'between' => array(
                'rule'    => array('between', 3, 40),
                'message' => 'O campo deve conter de 3 a 40 caracteres!')
		),
    'observacao' => array(
			'between' => array(
                'rule'    => array('between', 0, 450),
                'message' => 'O campo deve conter de 0 a 450 caracteres!')
		),
    'servico_id' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!'),
		),
    'rdm_id' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!'),
		),
    'user_id' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!'),
		)
  );

  public function afterFind($results, $primary = false) {
    foreach ($results as $key => $val) {
        if (isset($val['Release']['dt_ini_prevista'] )) {
            $results[$key]['Release']['dt_ini_prevista']  = $this->dateFormatAfterFind(
                $val['Release']['dt_ini_prevista']
            );
        }
        if (isset($val['Release']['dt_fim_prevista'])) {
            $results[$key]['Release']['dt_fim_prevista'] = $this->dateFormatAfterFind(
                $val['Release']['dt_fim_prevista']
            );
        }
        if (isset($val['Release']['dt_fim'])) {
            $results[$key]['Release']['dt_fim'] = $this->dateFormatAfterFind(
                $val['Release']['dt_fim']
            );
        }
    }
    return $results;
  }

  public function dateFormatAfterFind($dateString) {
      return date('d/m/Y', strtotime($dateString));
  }

  public function beforeValidate($options = array()){
    if(!empty($this->data['Release']['dt_ini_prevista'] )) {
        $this->data['Release']['dt_ini_prevista']  = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Release']['dt_ini_prevista'] )));
    }
    if(!empty($this->data['Release']['dt_fim_prevista'])) {
        $this->data['Release']['dt_fim_prevista'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Release']['dt_fim_prevista'])));
    }
    if(!empty($this->data['Release']['dt_fim'])) {
        $this->data['Release']['dt_fim'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Release']['dt_fim'])));
    }
    return true;
  }
}?>

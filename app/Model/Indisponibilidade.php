<?php class Indisponibilidade extends AppModel {


	var $actsAs = array('Containable');

	public $belongsTo = array(
		'Motivo' => array(
			'className' => 'Motivo',
			'foreignKey' => 'motivo_id'
		)
	);

	public $hasAndBelongsToMany = array(
		'Servico' => array('className' => 'Servico')
	);

  public $validate = array(
    'dt_inicio' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido'
      ),
    ),
	'motivo_id' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido'
      ),
    )
  );

	public function beforeValidate($options = array()){
		if(!empty($this->data['Indisponibilidade']['dt_inicio'])) {
				$this->data['Indisponibilidade']['dt_inicio'] = date("Y-m-d H:i", strtotime(str_replace('/', '-', $this->data['Indisponibilidade']['dt_inicio'])));
		}
		if(!empty($this->data['Indisponibilidade']['dt_fim'])) {
				$this->data['Indisponibilidade']['dt_fim'] = date("Y-m-d H:i", strtotime(str_replace('/', '-', $this->data['Indisponibilidade']['dt_fim'])));
		}
		return true;
	}

	public function afterFind($results, $primary = false) {
		foreach ($results as $key => $val) {
				if (isset($val['Indisponibilidade']['dt_inicio'])) {
						$results[$key]['Indisponibilidade']['dt_inicio'] = $this->dateFormatAfterFind(
								$val['Indisponibilidade']['dt_inicio']
						);
				}
				if (isset($val['Indisponibilidade']['dt_fim'])) {
						$results[$key]['Indisponibilidade']['dt_fim'] = $this->dateFormatAfterFind(
								$val['Indisponibilidade']['dt_fim']
						);
				}
		}
		return $results;
	}

	public function dateFormatAfterFind($dateString) {
			return date('d/m/Y', strtotime($dateString));
	}
}?>

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
        'maxLength' => 45,
        'message' => 'Campo deve ser preenchido'
      ),
    ),
	'motivo_id' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 45,
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
}?>

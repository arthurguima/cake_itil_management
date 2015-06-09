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
		'dt_fim' => array(
			'MaiorQueDataInicial' => array(
					"allowEmpty"=> true,
					'rule' => array('compareFields', '>', 'dt_inicio'),
					'message' => 'Data de Término deve ser posterior a data de Início!'
			)
		),
		'motivo_id' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido'
      ),
    ),
		'num_incidente' => array(
			'unique' => array(
				'rule' => 'isUnique',
				'allowEmpty' => true,
				'required' => 'create',
				'message' => 'Já existe outra indisponibilidade com esse número de incidente!'
			)
		),
		'num_evento' => array(
			'unique' => array(
				'rule' => 'isUnique',
				'allowEmpty' => true,
				'required' => 'create',
				'message' => 'Já existe outra indisponibilidade com esse número de evento!'
			)
		)
  );

	public function beforeValidate($options = array()){
		if(!empty($this->data['Indisponibilidade']['dt_inicio'])) {
				$this->data['Indisponibilidade']['dt_inicio'] = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $this->data['Indisponibilidade']['dt_inicio'])));
		}
		if(!empty($this->data['Indisponibilidade']['dt_fim'])) {
				$this->data['Indisponibilidade']['dt_fim'] = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $this->data['Indisponibilidade']['dt_fim'])));
		}
		return true;
	}
}?>

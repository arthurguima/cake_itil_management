<?php class Ss extends AppModel {


	public $hasMany = array(
		'Historico' => array(
			'className' => 'Historico',
			'foreignKey' => 'ss_id',
			'dependent' => false,
			'conditions' => '',
		),
		'Pe' => array(
			'className' => 'Pe',
			'foreignKey' => 'ss_id',
			'dependent' => false,
			'conditions' => '',
		)
	);

	public $hasAndBelongsToMany = array(
		'Demanda' => array(
			'className' => 'Demanda',
			'joinTable' => 'demandas_sses',
			'foreignKey' => 'ss_id',
			'associationForeignKey' => 'demanda_id',
		)
	);

	public $belongsTo = array(
		'Servico' => array(
			'className' => 'Servico'
		),
		'Status' => array(
			'className' => 'Status'
		)
	);

	public $validate = array(
		'nome' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!'),
			'between' => array(
								'rule'    => array('between', 3, 110),
								'message' => 'O campo deve conter de 3 a 110 caracteres!'
		)),
		'responsavel' => array(
			'NotEmpty' => array(
				'rule'   => 'notempty',
				'message' => 'Campo deve ser preenchido!')
		)
	);

	public function beforeValidate($options = array()){
		if(!empty($this->data['Ss']['dt_recebimento'])) {
				$this->data['Ss']['dt_recebimento'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ss']['dt_recebimento'])));
		}
		if(!empty($this->data['Ss']['dt_prevista'])) {
				$this->data['Ss']['dt_prevista'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ss']['dt_prevista'])));
		}
		if(!empty($this->data['Ss']['dt_prazo'])) {
				$this->data['Ss']['dt_prazo'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->data['Ss']['dt_prazo'])));
		}
		return true;
	}
}

<?php class Servico extends AppModel {

  public $hasAndBelongsToMany = array(
    'Area' => array('className' => 'Area'),
    'Indisponibilidade' => array('className' => 'Indisponibilidade'),
    'Dependencia' => array('classname' => 'Dependencia')
  );

  public $hasMany = array(
    'Demanda' => array('className' => 'Demanda'),
    'Rdm' => array('className' => 'Rdm'),
    'Ss' => array('className' => 'Ss'),
    'Chamado' => array('className' => 'Chamado'),
    'ChamadoTipo' => array('className' => 'ChamadoTipo'),
    'Regra' => array('className' => 'Regra')
  );

  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 80,
        'message' => 'Campo deve ser preenchido'
      ),
	  'between' => array(
                'rule'    => array('between', 3, 80),
                'message' => 'O campo deve conter de 3 a 80 caracteres!'
		)
    ),
    'sigla' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 20,
        'message' => 'Campo deve ser preenchido'
      ),
	  'between' => array(
                'rule'    => array('between', 2, 20),
                'message' => 'O campo deve conter de 2 a 20 caracteres!'
		)
    ),
    'tecnologia' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 45,
        'message' => 'Campo deve ser preenchido'
      ),
	  'between' => array(
                'rule'    => array('between', 2, 45),
                'message' => 'O campo deve conter de 2 a 45 caracteres!'
		)
    )
  );
}?>

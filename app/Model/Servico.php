<?php class Servico extends AppModel {

  public $hasAndBelongsToMany = array(
    'Area' => array('className' => 'Area'),
    'Indisponibilidade' => array('className' => 'Indisponibilidade'),
    'Dependencia' => array('classname' => 'Dependencia')
  );

  public $belongsTo = array(
    'Cliente' => array(
      'className' => 'Cliente',
      'foreignKey' => 'cliente_id'
    ),
    'User' => array(
      'className' => 'User',
      'foreignKey' => 'responsavel_id'
    ),
  );

  public $hasMany = array(
    'Demanda' => array('className' => 'Demanda'),
    'Rdm' => array('className' => 'Rdm'),
    'Ss' => array('className' => 'Ss'),
    'Chamado' => array('className' => 'Chamado'),
    'ChamadoTipo' => array('className' => 'ChamadoTipo'),
    'Regra' => array('className' => 'Regra'),
    'Container' => array('className' => 'Container'),
    'Release' => array('className' => 'Release')
  );

  public $validate = array(
    'nome' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 120,
        'message' => 'Campo deve ser preenchido'
      ),
	  'between' => array(
                'rule'    => array('between', 3, 120),
                'message' => 'O campo deve conter de 3 a 80 caracteres!'
		)
    ),
    'sigla' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 30,
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

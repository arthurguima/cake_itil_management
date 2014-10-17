<?php class Contrato extends AppModel {

  public $hasMany = array(
    'Item' => array(
      'className' => 'Item',
      'foreignKey' => 'contrato_id',
      'dependent' => true
    ),
    'Aditivo' => array(
      'className' => 'Aditivo',
      'foreignKey' => 'contrato_id',
      'dependent' => true
    )
  );
  
  public $belongsTo = array(
    'Cliente' => array(
      'className' => 'Cliente',
      'foreignKey' => 'cliente_id'
    )
  );

  public $validate = array(
    'numero' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido'
      ),
      'Numeric' => array(
        'rule' => 'numeric',
        'message' => 'Apenas Números!'
      )
    ),

    'data_ini' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'message' => 'Campo deve ser preenchido'
      )
    ),

    'data_fim' => array(
      'MaiorQueDataInicial' => array(
          'rule' => array('compareFields', '>', 'data_ini'),
          'message' => 'Data de término deve ser posterior a data de Início!'
      )
    )
  );
}?>

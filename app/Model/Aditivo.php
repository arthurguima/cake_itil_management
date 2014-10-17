<?php class Aditivo extends AppModel {

  public $belongsTo = array(
    'Contrato' => array(
      'className' => 'Contrato',
      'foreignKey' => 'contrato_id'
    )
  );
  public $hasMany = array(
    'Item' => array(
      'className' => 'Item',
      'foreignKey' => 'aditivo_id',
      'dependent' => true
    ),
  );

  public $validate = array(
    'dt_fim' => array(
      'MaiorQueDataInicial' => array(
          'rule' => array('compareFields', '>', 'dt_inicio'),
          'message' => 'Data de término deve ser posterior a data de Início!'
      )
    )
  );
}?>

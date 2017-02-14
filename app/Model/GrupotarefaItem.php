<?php class GrupotarefaItem extends AppModel {

  public $order = array("GrupotarefaItem.duracao" => "ASC");

  public $belongsTo = array(
    'Grupotarefa' => array(
      'className' => 'Grupotarefa',
      'foreignKey' => 'grupotarefa_id'
    )
  );

  public $validate = array(
    'descricao' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 250,
        'message' => 'Campo deve ser preenchido!')
    ),
  );

}?>

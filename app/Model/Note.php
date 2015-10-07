<?php class Note extends AppModel {

  //public $order = array("Historico.data" => "ASC", "Historico.id" => "ASC");

  public $belongsTo = array(
    'Release' => array(
      'className' => 'Release',
      'foreignKey' => 'release_id'
    )
  );

  public $validate = array(
    'valor' => array(
      'NotEmpty' => array(
        'rule'   => 'notempty',
        'maxLength' => 350,
        'message' => 'Campo deve ser preenchido!')
    ),
  );

}?>

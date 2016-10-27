<?php class IndisponibilidadeServico extends AppModel {

  public $belongsTo = array(
    'Servico',
    'Indisponibilidade',
    'Motivo'
  );

}?>

<?php class RdmHelper extends AppHelper {
  public $helpers = array('Times');

  public function getAmbiente($value){
    switch ($value):
      case 1: return "<span class='label label-warning'>Homologação</span>";
      case 2: return "<span class='label label-info'>Produção</span>";
      case 3: return "<span class='label label-primary'>Treinamento</span>";
    endswitch;
    return "Homologação";
  }

  /*
  * Destaca se a RDM foi concluida ou cancelada
  */
  public function sucesso($bol, $dt_executada, $class="") {
    if($bol == null){
        return " ";
    }

    switch ($bol) {
    case 0:
        return "<span class='label label-default' id='" . $class . "'>Não</span>";
    case 1:
      if($dt_executada != null)
        return "<span class='label label-success' id='" . $class . "'>Sim</span>";
      else
        return "";
    case 2:
      return "<span class='label label-danger' id='" . $class . "'>Cancelada</span>";
    default:
      return " ";
    }
  }

}?>

<?php class StatusHelper extends AppHelper {

  /*
  * Exibe o tipo de status como texto
  */
  public function tipo($string) {
    switch ($string):
      case 1: return "Demanda";
      case 2: return "SS";
      case 3: return "OS";
      case 4: return "PE";
      case 5: return "Chamado";
    endswitch;
    return "Demanda";
  }

}?>

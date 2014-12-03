<?php class RdmHelper extends AppHelper {

  public function getAmbiente($value){
    switch ($value):
      case 1: return "Homologação";
      case 2: return "Produção";
    endswitch;
    return "Homologação";
  }


}?>

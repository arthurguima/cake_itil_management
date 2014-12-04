<?php class RdmHelper extends AppHelper {
  public $helpers = array('Times');

  public function getAmbiente($value){
    switch ($value):
      case 1: return "Homologação";
      case 2: return "Produção";
    endswitch;
    return "Homologação";
  }

  public function sucesso($sucesso, $dt_executada){
    if($dt_executada == null){
      return " ";
    }
    else{
      return $this->Times->yesOrNo($sucesso, " ");
    }
  }


}?>

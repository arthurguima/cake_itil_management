<?php class SubtarefasHelper extends AppHelper {
  public $helpers = array('Times');


  public function status($check){
      if($check == 0)
        return "<span class='label label-success'>Em andamento</span>";
      elseif($check == 2)
        return "<span class='label label-info'>Aguardando Início</span>";
      else
        return "<span class='label label-default'>Finalizada</span>";
  }

  public function timeLeftTo($created, $prevista, $check, $inicio=null, $fim=null){

    if($inicio == null) $createdF = date("d/m/Y", strtotime($created)); else $createdF = $inicio;
    if($fim == null) $fim_ = $prevista; else $fim_ = $fim;


    if($check != 1){
      return $this->Times->timeLeftTo($createdF, $prevista,
        $createdF . " - " . $prevista,$fim);
    }
    else {
      if($fim == null)
        return $this->Times->timeLeftTo($createdF, $prevista,
          $createdF . " - " . $prevista, $prevista);
      else
        return $this->Times->timeLeftTo($createdF, $prevista,
          $createdF . " - " . $prevista, $fim);
    }
  }

}?>

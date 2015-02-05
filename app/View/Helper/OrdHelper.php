<?php class OrdHelper extends AppHelper {

  public function getCheckList($ths, $trp, $trd){

      $value = "<span>";

      if($ths != null){
          $value = $value . "<a target='_blank' href='" . $ths . "' title='TH' ><b>THS</b> <i class='fa fa-check-square-o fa-done checklist'><span>(OK)</span></i></a>  ";
      }else{
          $value = $value . "<a title='Documento de Visão'><b>TH</b> <i class='fa fa-square-o fa-undone checklist'><span>(  )</span></i></a>  ";
      }

      if($trp != null){
         $value = $value . "<a target='_blank' href='" . $trp . "' title='TRP'><b>TRP</b> <i class='fa fa-check-square-o fa-done checklist'><span>(OK)</span></i></a>";
      }else{
        $value = $value . "<a title='Contagem de Pontos de Função'><b>TRP</b> <i class='fa fa-square-o fa-undone checklist'><span>(  )</span></i></a> ";
      }

      if($trd != null){
         $value = $value . "<a target='_blank' href='" . $trd . "' title='TRD'><b>TRD</b> <i class='fa fa-check-square-o fa-done checklist'><span>(OK)</span></i></a>";
      }else{
        $value = $value . "<a title='Contagem de Pontos de Função'><b>TRD</b> <i class='fa fa-square-o fa-undone checklist'><span>(  )</span></i></a>";
      }

      return $value . "</span>";

  }

}?>

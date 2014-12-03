<?php class SsHelper extends AppHelper {

  public function getCheckList($dv, $contagem){

      $value = "<span>";

      if($dv != null){
          $value = $value . "<a href='" . $dv . "' title='Documento de Visão' ><b>DV</b> <i class='fa fa-check-square-o fa-done checklist'><span>(OK)</span></i></a>  ";
      }else{
          $value = $value . "<a title='Documento de Visão'><b>DV</b> <i class='fa fa-square-o fa-undone checklist'><span>(  )</span></i></a>  ";
      }

      if($contagem != null){
         $value = $value . "<a href='" . $contagem . "' title='Contagem de Pontos de Função'><b>PF</b> <i class='fa fa-check-square-o fa-done checklist'><span>(OK)</span></i></a>";
      }else{
        $value = $value . "<a title='Contagem de Pontos de Função'><b>PF</b> <i class='fa fa-square-o fa-undone checklist'><span>(  )</span></i></a>";
      }

      return $value . "</span>";

  }

}?>

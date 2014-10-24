<?php class DemandaHelper extends AppHelper {

  public function demandas($demanda, $Servico){

   $legenda = "";
   $values = "";
   $colors = array();
   $aux = 0;

   foreach($demanda as $key => $value):
     $colors[$key] = substr(md5($key), 0, 6);

     if($key != 'total'){
       $legenda = $legenda . "<p class='legend'><span class='color-legend' style='background-color:#" . $colors[$key] .";'></span>" . $key . " - " . $demanda[$key] . "</p>";
       if($aux == 1){
         $values = $values . "," .$demanda[$key];
       }else{
         $values = $values . $demanda[$key];
         $aux++;
       }
     }
   endforeach;

   return "<div class='col-sm-12 col-lg-4  col-md-4 well indis demanda-indis'>
     <div class='col-lg-6 col-xs-6 col-md-6'>
       <a class='servico col-lg-12'><b>" . $Servico . "</b></a>
       <span class='pie-" . $Servico ."'>" . $values . "</span>
     </div>
     <div class='col-lg-6 col-xs-6 col-md-6 pull-right'>
        ". $legenda ."
     </div>
     <script>
       $(document).ready(function() {
        $('.pie-" . $Servico ."').peity('pie', {
          fill: " . $this->colorAsArray($colors) .",
          radius: 50
        });
       });
     </script>
   </div>";
  }

  private function colorAsArray($color){
    $string = "[";
    foreach($color as $co):
      $string = $string . "'#" . $co ."',";
    endforeach;

    return $string . "]";
  }

}?>

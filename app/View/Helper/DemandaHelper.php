<?php class DemandaHelper extends AppHelper {

  public function demandasStatus($demanda, $Servico){

   $legenda = "";
   $values = "";
   $colors = array();
   $aux = 0;

   foreach($demanda['Status'] as $key => $value):
    if($key != 'total'){
      $colors[$key] = substr(md5($key), 0, 6);
       $legenda = $legenda . "<p class='legend'><span class='color-legend' style='background-color:#" . $colors[$key] .";'></span><b>" . round(($demanda['Status'][$key]/$demanda['Status']['total'])*100,2) . "%</b> - " . $key . " - " . $demanda['Status'][$key] . "</p>";
       if($aux == 1){
         $values = $values . "," .$demanda['Status'][$key];
       }else{
         $values = $values . $demanda['Status'][$key];
         $aux++;
       }
    }
   endforeach;

   return "
   <div class='col-sm-12 col-lg-4  col-md-12 well indis demanda-indis'>
    <div class='indis-tittle col-lg-12'>
      <a class='servico col-lg-12'><b>" . $Servico . "</b></a>
    </div>
    <div class='indis-body'>
      <div class='col-lg-4 col-xs-4 col-md-4'>
        <span class='pie-" . $Servico ."'>" . $values . "</span>
      </div>
      <div class='col-lg-8 col-xs-8 col-md-8'>
        ". $legenda ."
      </div>
    </div>
    <div class='indis-footer col-lg-12'>
      <b style='color:#D9534F;'>". $demanda['Status']['total']  ."</b> demanda(s)
    </div>
      <script>
        $(document).ready(function() {
         $('.pie-" . $Servico ."').peity('pie', {
            fill: " . $this->colorAsArray($colors) .",
            radius: 35
          });
        });
       </script>
   </div>";
  }

  public function demandasTipos($demanda, $Servico){
    $legenda = "";
    $values = "";
    $colors = array();
    $aux = 0;

    foreach($demanda['Tipo'] as $key => $value):
      if($key != 'total'){
        $colors[$key] = substr(md5($key), 0, 6);
        $legenda = $legenda . "<p class='legend'><span class='color-legend' style='background-color:#" . $colors[$key] .";'></span><b>" . round(($demanda['Tipo'][$key]/$demanda['Status']['total'])*100,2) . "%</b> - " . $key . " - " . $demanda['Tipo'][$key] . "</p>";
        if($aux == 1){
          $values = $values . "," .$demanda['Tipo'][$key];
        }else{
          $values = $values . $demanda['Tipo'][$key];
          $aux++;
        }
      }
    endforeach;

    return "
    <div class='col-sm-12 col-lg-4  col-md-12 well indis demanda-indis'>
      <div class='indis-tittle col-lg-12'>
        <a class='servico col-lg-12'><b>" . $Servico . "</b></a>
      </div>
      <div class='indis-body'>
        <div class='col-lg-4 col-xs-4 col-md-4'>
          <span class='pie-Tipo-" . $Servico ."'>" . $values . "</span>
        </div>
        <div class='col-lg-8 col-xs-8 col-md-8'>
          ". $legenda ."
        </div>
      </div>
      <div class='indis-footer col-lg-12'>
        <b style='color:#D9534F;'>". $demanda['Status']['total']  ."</b> demanda(s)
      </div>
      <script>
        $(document).ready(function() {
         $('.pie-Tipo-" . $Servico ."').peity('pie', {
           fill: " . $this->colorAsArray($colors) .",
           radius: 35
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

<?php class ChamadoHelper extends AppHelper {

  public function chamadosStatus($chamado, $Servico){

   $legenda = "";
   $values = "";
   $colors = array();
   $aux = 0;

   foreach($chamado['Status'] as $key => $value):
    if($key != 'total'){
      $colors[$key] = substr(md5($key), 0, 6);
       $legenda = $legenda . "<p class='legend'><span class='color-legend' style='background-color:#" . $colors[$key] .";'></span><b>" . round(($chamado['Status'][$key]['total']/$chamado['Status']['total'])*100,2) . "%</b> - " . $key . " - " . $chamado['Status'][$key]['total'] . "</p>";
       if($aux == 1){
         $values = $values . "," .$chamado['Status'][$key]['total'];
       }else{
         $values = $values . $chamado['Status'][$key]['total'];
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
      <b style='color:#D9534F;'>". $chamado['Status']['total']  ."</b> chamado(s)
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

  public function chamadosTipos($chamado, $Servico){
    $legenda = "";
    $values = "";
    $colors = array();
    $aux = 0;

    foreach($chamado['Tipo'] as $key => $value):
      if($key != 'total'){
        $colors[$key] = substr(md5($key), 0, 6);
        $legenda = $legenda . "<p class='legend'><span class='color-legend' style='background-color:#" . $colors[$key] .";'></span><b>" . round(($chamado['Tipo'][$key]['total']/$chamado['Status']['total'])*100,2) . "%</b> - " . $key . " - " . $chamado['Tipo'][$key]['total'] . "</p>";
        if($aux == 1){
          $values = $values . "," .$chamado['Tipo'][$key]['total'];
        }else{
          $values = $values . $chamado['Tipo'][$key]['total'];
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
        <b style='color:#D9534F;'>". $chamado['Status']['total']  ."</b> chamado(s)
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

  public function chamadosStatusTipos($chamado, $Servico){
      $div = "
      <div class='col-sm-12 col-lg-4  col-md-12 well indis demanda-indis'>
        <div class='indis-tittle col-lg-12'>
          <a class='servico col-lg-12'><b>" . $Servico . "</b></a>
        </div>
        <div class='indis-body'><table><tbody>";

      foreach($chamado['Tipo'] as $key => $value):
        if($key != 'total'){color: #0f4821;
          $div = $div . "<tr><th class='status-tipo' style='color: #" . substr(md5($key), 0, 6) . "; padding-left: 3px; border-left: 5px solid #" . substr(md5($key), 0, 6) . "; '>". $key ."</th><th><ul>";
          foreach($chamado['Tipo'][$key] as $key2 => $value):
            if($key2 != 'total'){
              $div = $div . "<li><b>" . round(($chamado['Tipo'][$key][$key2]/$chamado['Tipo'][$key]['total'])*100,2) . "%</b> - " . $key2 . " - " . $chamado['Tipo'][$key][$key2] . "</li>";
            }
          endforeach;
          $div = $div . "</th></ul></tr>";
        }
      endforeach;

      $div = $div . "</tbody></table></div>
        <div class='indis-footer col-lg-12'>
          <b style='color:#D9534F;'>". $chamado['Status']['total']  ."</b> chamado(s)
        </div>
      </div>";

      return $div;
  }

}?>

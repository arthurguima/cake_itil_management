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
        <span class='pie-chamado-" . $Servico ."'>" . $values . "</span>
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
         $('.pie-chamado-" . $Servico ."').peity('pie', {
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
          <span class='pie-chamado-Tipo-" . $Servico ."'>" . $values . "</span>
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
         $('.pie-chamado-Tipo-" . $Servico ."').peity('pie', {
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
        if($key != 'total'){
          $div = $div . "<tr><th class='status-tipo' style='color: #" . substr(md5($key), 0, 6) . "; padding-left: 3px; font-size: 12px; border-left: 5px solid #" . substr(md5($key), 0, 6) . "; '>". $key ."</th><th><ul id='status_tipos'>";
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

  /*
  * Analisa de forma geral todas as demandas de um Cliente
  */
  public function chamadosGeral($chamados, $cliente){
    $status = array();
    $tipos = array();
    $statustipos = array();
    $servicos = array();

    $status['Status']['total'] = 0;
    foreach($chamados as $serv){
      foreach($serv['Status'] as $key => $value ){
        if($key != 'total'){
          if(isset($status['Status'][$key]['total'])){
            $status['Status'][$key]['total'] += $value['total'];
            $status['Status']['total'] += $value['total'];
          }
          else{
            $status['Status'][$key]['total'] = $value['total'];
            $status['Status']['total'] += $value['total'];
          }
        }
      }
    }
    $status = $this->chamadosStatus($status, "Status",$cliente);

    $legenda = "";
    $values = "";
    $colors = array();
    $aux = 0;
    $servicos['total'] = 0;
    foreach($chamados as $key => $serv){
      $servicos[$key] = $serv['Status']['total'];
      $servicos['total'] += $serv['Status']['total'];
    }
    
    foreach($servicos as $key => $servicototal):
      if($key != 'total'){
        $colors[$key] = substr(md5($key), 0, 6);
        $legenda = $legenda . "<p class='legend'><span class='color-legend' style='background-color:#" . $colors[$key] .";'></span><b>" . round(($servicototal/$servicos['total'])*100,2) . "%</b> - " . $key . " - " . $servicototal . "</p>";
        if($aux == 1){
          $values = $values . "," . $servicototal;
        }else{
          $values = $values . $servicototal;
          $aux++;
        }
      }
    endforeach;

    $servic = "
    <div class='col-sm-12 col-lg-4  col-md-12 well indis demanda-indis'>
      <div class='indis-tittle col-lg-12'>
        <a class='servico col-lg-12'><b>Serviços</b></a>
      </div>
      <div class='indis-body'>
        <div class='col-lg-4 col-xs-4 col-md-4'>
          <span class='pie-chamado-Tipo-Serviços-" . $cliente . "'>" . $values . "</span>
        </div>
        <div class='col-lg-8 col-xs-8 col-md-8'>
          ". $legenda ."
        </div>
      </div>
      <div class='indis-footer col-lg-12'>
        <b style='color:#D9534F;'>". $servicos['total']  ."</b> chamado(s)
      </div>
      <script>
        $(document).ready(function() {
         $('.pie-chamado-Tipo-Serviços-" . $cliente ."').peity('pie', {
           fill: " . $this->colorAsArray($colors) .",
           radius: 35
         });
        });
      </script>
    </div>";

    return $status . $servic;
  }

}?>

<?php class DemandaHelper extends AppHelper {

  public function demandasStatus($demanda, $Servico, $cliente=""){

   $legenda = "";
   $values = "";
   $colors = array();
   $aux = 0;

   foreach($demanda['Status'] as $key => $value):
    if($key != 'total'){
      $colors[$key] = substr(md5($key), 0, 6);
       $legenda = $legenda . "<p class='legend'><span class='color-legend' style='background-color:#" . $colors[$key] .";'></span><b>" . round(($demanda['Status'][$key]['total']/$demanda['Status']['total'])*100,2) . "%</b> - " . $key . " - " . $demanda['Status'][$key]['total'] . "</p>";
       if($aux == 1){
         $values = $values . "," .$demanda['Status'][$key]['total'];
       }else{
         $values = $values . $demanda['Status'][$key]['total'];
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
        <span class='pie-" . $Servico . $cliente ."'>" . $values . "</span>
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
         $('.pie-" . $Servico . $cliente ."').peity('pie', {
            fill: " . $this->colorAsArray($colors) .",
            radius: 35
          });
        });
       </script>
   </div>";
  }

  public function demandasAtrasos($demanda, $Servico, $cliente=""){

   $legenda = "";
   $values = "";
   $colors = array();
   $aux = 0;
  // debug($demanda['Atraso']);
   foreach($demanda['Atraso'] as $key => $value):
    if($key != 'total'){
      $colors[$key] = substr(md5($key), 0, 6);
       $legenda = $legenda . "<p class='legend'><span class='color-legend' style='background-color:#" . $colors[$key] .";'></span><b>" . round(($demanda['Atraso'][$key]/$demanda['Atraso']['total'])*100,2) . "%</b> - " . $key . " - " . $demanda['Atraso'][$key] . "</p>";
       if($aux == 1){
         $values = $values . "," .$demanda['Atraso'][$key];
       }else{
         $values = $values . $demanda['Atraso'][$key];
         $aux++;
       }
    }
   endforeach;

   return "
   <div class='col-sm-12 col-lg-4  col-md-12 well indis indis-atraso'>
    <div class='indis-tittle col-lg-12'>
      <a class='servico col-lg-12'><b>" . $Servico . "</b></a>
    </div>
    <div class='indis-body'>
      <div class='col-lg-4 col-xs-4 col-md-4'>
        <span class='pie-atraso" . $Servico . $cliente ."'>" . $values . "</span>
      </div>
      <div class='col-lg-8 col-xs-8 col-md-8'>
        ". $legenda ."
      </div>
    </div>
    <div class='indis-footer col-lg-12'>
      <b style='color:#D9534F;'>". $demanda['Atraso']['total']  ."</b> demanda(s) - (dias em atraso)
    </div>
      <script>
        $(document).ready(function() {
         $('.pie-atraso" . $Servico . $cliente ."').peity('pie', {
            fill: " . $this->colorAsArray($colors) .",
            radius: 35
          });
        });
       </script>
   </div>";
  }

  public function demandasTipos($demanda, $Servico, $cliente=""){
    $legenda = "";
    $values = "";
    $colors = array();
    $aux = 0;

    foreach($demanda['Tipo'] as $key => $value):
      if($key != 'total'){
        $colors[$key] = substr(md5($key), 0, 6);
        $legenda = $legenda . "<p class='legend'><span class='color-legend' style='background-color:#" . $colors[$key] .";'></span><b>" . round(($demanda['Tipo'][$key]['total']/$demanda['Status']['total'])*100,2) . "%</b> - " . $key . " - " . $demanda['Tipo'][$key]['total'] . "</p>";
        if($aux == 1){
          $values = $values . "," .$demanda['Tipo'][$key]['total'];
        }else{
          $values = $values . $demanda['Tipo'][$key]['total'];
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
          <span class='pie-Tipo-" . $Servico . $cliente ."'>" . $values . "</span>
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
         $('.pie-Tipo-" . $Servico . $cliente ."').peity('pie', {
           fill: " . $this->colorAsArray($colors) .",
           radius: 35
         });
        });
      </script>
    </div>";
  }

  public function colorAsArray($color){
    $string = "[";
    foreach($color as $co):
      $string = $string . "'#" . $co ."',";
    endforeach;

    return $string . "]";
  }

  public function demandasStatusTipos($demanda, $Servico){
      $div = "
      <div class='col-sm-12 col-lg-4  col-md-12 well indis demanda-indis'>
        <div class='indis-tittle col-lg-12'>
          <a class='servico col-lg-12'><b>" . $Servico . "</b></a>
        </div>
        <div class='indis-body'><table><tbody>";

      foreach($demanda['Tipo'] as $key => $value):
        if($key != 'total'){
          $div = $div . "<tr><th class='status-tipo' style='color: #" . substr(md5($key), 0, 6) . "; padding-left: 3px; border-left: 5px solid #" . substr(md5($key), 0, 6) . "; '>". $key ."</th><th><ul id='status_tipos'>";
          foreach($demanda['Tipo'][$key] as $key2 => $value):
            if($key2 != 'total'){
              $div = $div . "<li> " . "<span class='color-legend-sm' style='background-color:#" . substr(md5($key2), 0, 6) .";'></span>" .
              round(($demanda['Tipo'][$key][$key2]/$demanda['Tipo'][$key]['total'])*100,2) . "% - " . $key2 . " - " . $demanda['Tipo'][$key][$key2] . "</li>";
            }
          endforeach;
          $div = $div . "</th></ul></tr>";
        }
      endforeach;

      $div = $div . "</tbody></table></div>
        <div class='indis-footer col-lg-12'>
          <b style='color:#D9534F;'>". $demanda['Status']['total']  ."</b> demanda(s)
        </div>
      </div>";

      return $div;
  }

  /*
  * Analisa de forma geral todas as demandas de um Cliente
  */
  public function demandasGeral($demandas, $cliente){
    $status = array();
    $tipos = array();
    $statustipos = array();
    $atrasos = array();

    $status['Status']['total'] = 0;
    foreach($demandas as $serv){
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

    $tipos['Status']['total'] = $status['Status']['total'];
    foreach($demandas as $serv){
      foreach($serv['Tipo'] as $tipo => $tipost ){
        foreach($tipost as $key => $value ){
          if(isset($tipos['Tipo'][$tipo][$key])){
            $tipos['Tipo'][$tipo][$key] += $value;
          }else{
            $tipos['Tipo'][$tipo][$key] = $value;
          }
        }
      }
    }

    $atrasos['Atraso']['total'] = 0;
    foreach($demandas as $serv){
      foreach($serv['Atraso'] as $key => $value ){
        if(isset($serv['Atraso']['total'])){
          if($key != 'total'){
            if(isset($atrasos['Atraso'][$key])){
              $atrasos['Atraso'][$key] += $value;
            }
            else{
              $atrasos['Atraso'][$key] = $value;
            }
          }
        }
      }
      $atrasos['Atraso']['total'] += $serv['Atraso']['total'];
    }

    $legenda = "";
    $values = "";
    $colors = array();
    $aux = 0;
    $servicos['total'] = 0;
    foreach($demandas as $key => $serv){
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
          <span class='pie-demandas-Tipo-Serviços-" . $cliente . "'>" . $values . "</span>
        </div>
        <div class='col-lg-8 col-xs-8 col-md-8'>
          ". $legenda ."
        </div>
      </div>
      <div class='indis-footer col-lg-12'>
        <b style='color:#D9534F;'>". $servicos['total']  ."</b> demanda(s)
      </div>
      <script>
        $(document).ready(function() {
         $('.pie-demandas-Tipo-Serviços-" . $cliente ."').peity('pie', {
           fill: " . $this->colorAsArray($colors) .",
           radius: 35
         });
        });
      </script>
    </div>";

    $status = $this->demandasStatus($status, "Status",$cliente);
    $statustipos = $this->demandasStatusTipos($tipos, "StatusXTipos",$cliente);
    $tipos = $this->demandasTipos($tipos, 'Tipos',$cliente);
    //debug($atrasos);
    $atrasos = $this->demandasAtrasos($atrasos,"Atrasos",$cliente);

    return $statustipos . $status . $tipos . $atrasos . $servic;
  }

  public function select2(){
    return "
      $(\".select2demanda\").select2({
        minimumInputLength: 4,
        width: \"100%\",
        ajax: {
            url: \"" . Router::url('/', true) . "\" + 'demandas/json',
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return {
                q: params.term, // search term
              };
            },
            processResults: function (data, params) {
              return {
                results: data,
              };
            },
            cache: true
        },
      });
    ";
  }

}?>

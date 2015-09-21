<?php class RdmHelper extends AppHelper {
  public $helpers = array('Times');

  public function getAmbiente($value){
    switch ($value):
      case 1: return "<span class='label label-warning'>Homologação</span>";
      case 2: return "<span class='label label-info'>Produção</span>";
      case 3: return "<span class='label label-primary'>Treinamento</span>";
      case 4: return "<span class='label label-success'>Sustentação</span>";
    endswitch;
    return "<span class='label label-warning'>Homologação</span>";
  }

  /*
  * Destaca se a RDM foi concluida ou cancelada
  */
  public function sucesso($bol, $dt_executada, $class="") {
    if($bol == null){
        return " ";
    }

    switch ($bol) {
    case 0:
        return "<span class='label label-default' id='" . $class . "'>Não</span>";
    case 1:
      if($dt_executada != null)
        return "<span class='label label-success' id='" . $class . "'>Sim</span>";
      else
        return "";
    case 2:
      return "<span class='label label-danger' id='" . $class . "'>Cancelada</span>";
    default:
      return " ";
    }
  }

  public function rdmgraph($ambientes, $title ,$cliente="", $period, $total){

   $legenda = "";
   $values = "";
   $colors = array();
   $aux = 0;

   foreach($ambientes as $key => $value):
    $colors[$key] = substr(md5($key), 0, 6);
     $legenda = $legenda . "<p class='legend'><span class='color-legend' style='background-color:#" . $colors[$key] .";'></span><b>" . round(($ambientes[$key]/$total)*100,2) . "%</b> - " . $key . " - " . $ambientes[$key] . "</p>";
     if($aux == 1){
       $values = $values . "," .$ambientes[$key];
     }else{
       $values = $values . $ambientes[$key];
       $aux++;
     }
   endforeach;

   return "
   <div class='col-sm-12 col-lg-4  col-md-12 well indis demanda-indis'>
    <div class='indis-tittle col-lg-12'>
      <a class='servico col-lg-12'><b>" . $title . "</b></a>
    </div>
    <div class='indis-body'>
      <div class='col-lg-4 col-xs-4 col-md-4'>
        <span class='pie-rdm" . $period . $cliente ."'>" . $values . "</span>
      </div>
      <div class='col-lg-8 col-xs-8 col-md-8'>
        ". $legenda ."
      </div>
    </div>
    <div class='indis-footer col-lg-12'>
      <b style='color:#D9534F;'>". $total  ."</b> rdm(s)
    </div>
      <script>
        $(document).ready(function() {
         $('.pie-rdm" . $period . $cliente ."').peity('pie', {
            fill: " . $this->colorAsArray($colors) .",
            radius: 35
          });
        });
       </script>
   </div>";
  }

  public function rdmSucessoTimegraph($ano, $cliente){
    $points = array();
    foreach($ano as $key => $mes){
      foreach($mes as $numero => $valor){
        if(!isset($points[$key]))
          $points[$key] = "{ x: ". $numero .", y: ". $valor ." },";
        else
          $points[$key] = $points[$key] . "{ x: ". $numero .", y: ". $valor ." },";
      }
    }

    $string = " ";
    foreach($points as $key => $value){
      $string = $string . '{
        name: "'.$key.'",
        type: "spline",
        showInLegend: true,
        dataPoints: [ '. $value .' ]
      },';
    }

    return '
    <script type="text/javascript">
      $(document).ready(function() {
      	var chart = new CanvasJS.Chart("chartContainer'. $cliente .'",
      	{
          title:{
            text: "Sucesso das RDMs de '. date('Y') .'",
            fontSize: 18
          },
          axisX:{
            title: "Mês",
            titleFontSize: 12
          },
          axisY:{
            title: "Qtd de RDMs",
            titleFontSize: 12
          },
      		animationEnabled: true,
      		data: [
        		'. $string .'
          ],
      	});
      	chart.render();
      });
    </script>
    <div class="col-lg-8 chart-container" id="chartContainer'. $cliente .'" style="height: 300px; max-width: 800px;"></div>';
  }

  private function colorAsArray($color){
    $string = "[";
    foreach($color as $co):
      $string = $string . "'#" . $co ."',";
    endforeach;

    return $string . "]";
  }

  public function getCheck($check){

      $value = "<span>";

      if($check == 1){
          $value = $value . " <i class='fa fa-check-square-o fa-done checklist'><span>(OK)</span></i>";
      }else{
          $value = $value . " <i class='fa fa-square-o fa-undone checklist'><span>(  )</span></i>";
      }

      return $value . "</span>";

  }
}?>

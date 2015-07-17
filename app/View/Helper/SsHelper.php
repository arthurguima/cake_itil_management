<?php class SsHelper extends AppHelper {
  public $helpers = array('Historicos', 'Times', 'Html', 'Tables');

  public function getCheckList($dv, $contagem){

      $value = "<span>";

      if($dv != null){
          $value = $value . "<a target='_blank' href='" . $dv . "' title='Documento de Visão' ><b>DV</b> <i class='fa fa-check-square-o fa-done checklist'><span>(OK)</span></i></a>  ";
      }else{
          $value = $value . "<a title='Documento de Visão'><b>DV</b> <i class='fa fa-square-o fa-undone checklist'><span>(  )</span></i></a>  ";
      }

      if($contagem != null){
         $value = $value . "<a target='_blank' href='" . $contagem . "' title='Contagem de Pontos de Função'><b>PF</b> <i class='fa fa-check-square-o fa-done checklist'><span>(OK)</span></i></a>";
      }else{
        $value = $value . "<a title='Contagem de Pontos de Função'><b>PF</b> <i class='fa fa-square-o fa-undone checklist'><span>(  )</span></i></a>";
      }

      return $value . "</span>";

  }

  public function setTimelineItem($item, $name, $class, $text, $id){
    switch($class){
      case 'demanda':
        $group = 3;
        $style = "background-color: #428bca; color: #000;";
        break;
      case 'pe':
        $group = 1;
        $style = "background-color: #C6CFDB; color: #000;";
        break;
      case 'ord':
        $group = 2;
        $style = "background-color: #fcf8e3; color: #000;";
        break;
      case 'ss':
        $group = 0;
        $style = "background-color: #56CDDF; color: #000;";
        break;
    }

    $data = array(
      'id' => $id . "-" . $class . "-" . $name,
      'group' => $group,
      'content' => $text,
      'start' => $this->Times->AmericanDate($item),
      'style' => $style
    );
    return $data;
  }

  //TODO: Refatorar
  public function timelineItens($ss){

    foreach($ss['Pe'] as $pe){
      if (isset($pe['dt_emissao']))
        $data[] = $this->setTimelineItem($pe['dt_emissao'], 'emissao', 'pe', "<b>Emissão da PA: </b>" . $pe['numero'] . "/" . $pe['ano'], $pe['id']);
      if(isset($pe['validade_pdd']))
        $data[] = $this->setTimelineItem($pe['validade_pdd'], 'pdd', 'pe', "<b>Fim da Validade do PDD da PA: </b>" . $pe['numero'] . "/" . $pe['ano'], $pe['id']);
      if(isset($pe['dt_inicio']))
        $data[] = $this->setTimelineItem($pe['dt_inicio'], 'inicio', 'pe', "<b>Início Previsto da OS da PA: </b>" . $pe['numero'] . "/" . $pe['ano'], $pe['id']);

      foreach($pe['Historico'] as $item) {
        $data[] = $this->setTimelineItem($item['data'], 'inicio', 'pe',
          "<i class='fa fa-comment-o' style='font-size: 15px !important;'></i> <b>PA " . $pe['numero'] . "/" . $pe['ano'] . ":</b><br />" .
          $this->Tables->popupBox($this->Historicos->findLinks($item['descricao'])),
          $item['id']);
      }
    }

    foreach($ss['Ord'] as $ord){
      if (isset($ord['dt_emissao']))
        $data[] = $this->setTimelineItem($ord['dt_emissao'], 'emissao', 'ord', "<b>Data de Emissão: </b>OS " . $ord['numero'] . "/" . $ord['ano'], $ord['id']);
      if (isset($ord['dt_recebimento']))
        $data[] = $this->setTimelineItem($ord['dt_recebimento'], 'recebimento', 'ord', "<b>Data de Recebimento: </b>OS " . $ord['numero'] . "/" . $ord['ano'], $ord['id']);
      if (isset($ord['dt_deploy_producao']))
        $data[] = $this->setTimelineItem($ord['dt_deploy_producao'], 'deploy_producao', 'ord', "<b>Deploy Produção: </b>OS " . $ord['numero'] . "/" . $ord['ano'], $ord['id']);
      if (isset($ord['dt_deploy_homologacao']))
        $data[] = $this->setTimelineItem($ord['dt_deploy_homologacao'], 'deploy_homo', 'ord', "<b>Deploy Homologação: </b>OS " . $ord['numero'] . "/" . $ord['ano'], $ord['id']);
      if (isset($ord['dt_homologacao']))
        $data[] = $this->setTimelineItem($ord['dt_homologacao'], 'homo', 'ord', "<b>Homologação: </b>OS " . $ord['numero'] . "/" . $ord['ano'], $ord['id']);
      if (isset($ord['dt_recebimento_homo']))
        $data[] = $this->setTimelineItem($ord['dt_recebimento_homo'], 'rece_homo', 'ord',
                  $this->Html->link("<b>Data Prevista do Termo de Homologação: </b>OS " . $ord['numero'] . "/" . $ord['ano'],
                  array('controller'=>'ords', 'action' => 'view', $ord['id']), array('escape' => false)), $ord['id']);
      if (isset($ord['dt_recebimento_termo_prov']))
        $data[] = $this->setTimelineItem($ord['dt_recebimento_termo_prov'], 'rece_ter_prov', 'ord',
                  $this->Html->link("<b>Data Prevista do Termo de Recebimento Provisório: </b>OS " . $ord['numero'] . "/" . $ord['ano'],
                  array('controller'=>'ords', 'action' => 'view', $ord['id']), array('escape' => false)), $ord['id']);
      if (isset($ord['dt_recebimento_termo']))
        $data[] = $this->setTimelineItem($ord['dt_recebimento_termo'], 'recebimento_termo', 'ord',
                  $this->Html->link("<b>Data Prevista do Termo de Recebimento: </b><br />OS " . $ord['numero'] . "/" . $ord['ano'],
                  array('controller'=>'ords', 'action' => 'view', $ord['id']), array('escape' => false)), $ord['id']);

      foreach($ord['Historico'] as $item) {
        $data[] = $this->setTimelineItem($item['data'], 'emissao', 'ord',
                  "<i class='fa fa-comment-o' style='font-size: 15px !important;'></i> <b>OS " . $ord['numero'] . "/" . $ord['ano'] . ":</b><br />" . $this->Tables->popupBox($this->Historicos->findLinks($item['descricao'])),
                   $item['id']);
      }
    }

    foreach($ss['Demanda'] as $dem){
      if(isset($dem['dt_prevista']))
        $data[] = $this->setTimelineItem($dem['dt_prevista'], 'prevista', 'demanda',
          $this->Html->link("<b>Data Prevista: </b><br />" . $dem['nome'], array('controller'=>'demandas', 'action' => 'view', $dem['id']),
          array('escape' => false)), $dem['id']);

      if(isset($dem['data_homologacao']))
        $data[] = $this->setTimelineItem($dem['data_homologacao'], 'homologacao', 'demanda',
        $this->Html->link("<b>Data de Homologação: </b><br />" . $dem['nome'], array('controller'=>'demandas', 'action' => 'view', $dem['id']),
        array('escape' => false)), $dem['id']);

      if(isset($dem['data_cadastro']))
        $data[] = $this->setTimelineItem($dem['data_cadastro'], 'cadastro', 'demanda',
        $this->Html->link("<b>Cadastro da Demanda: </b><br />" . $dem['nome'], array('controller'=>'demandas', 'action' => 'view', $dem['id']),
        array('escape' => false)), $dem['id']);

      foreach($dem['Historico'] as $item) {
        $data[] = $this->setTimelineItem($item['data'], 'hist', 'demanda',
        $this->Html->link("<i class='fa fa-comment-o' style='font-size: 15px !important;'></i> <b>Demanda " . $dem['clarity_dm_id'] . ":</b>",
        array('controller'=>'demandas', 'action' => 'view', $dem['id']), array('escape' => false)) . "<br />" .
        $this->Tables->popupBox($dem['nome'] . " - " . $this->Historicos->findLinks($item['descricao'])), $item['id']);
      }
    }

    foreach($ss['Historico'] as $item)
      $data[] = $this->setTimelineItem($item['data'], 'hist', 'ss',
               $this->Tables->popupBox("<i class='fa fa-comment-o' style='font-size: 15px !important;'></i> " . $this->Historicos->findLinks($item['descricao'])), $item['id']);

    if(isset($ss['Ss']['dt_recebimento']))
      $data[] = $this->setTimelineItem($ss['Ss']['dt_recebimento'], 'recebimento', 'ss', "<b>Recebimento da SS</b>", 'x');


    if(isset($ss['Ss']['dt_prazo']))
      $data[] = $this->setTimelineItem($ss['Ss']['dt_prazo'], 'prazo', 'ss', "<b>Prazo final contratual</b>", 'y');

    if(isset($ss['Ss']['dt_finalizada']))
      $data[] = $this->setTimelineItem($ss['Ss']['dt_finalizada'], 'finalizada', 'ss', "<b>SS finalizada</b>", 'z');

    return json_encode($data);
  }

  public function ssesStatus($ss, $Servico, $cliente=""){

   $legenda = "";
   $values = "";
   $colors = array();
   $aux = 0;

   foreach($ss['Status'] as $key => $value):
    if($key != 'total'){
      $colors[$key] = substr(md5($key), 0, 6);
       $legenda = $legenda . "<p class='legend'><span class='color-legend' style='background-color:#" . $colors[$key] .";'></span><b>" . round(($ss['Status'][$key]['total']/$ss['Status']['total'])*100,2) . "%</b> - " . $key . " - " . $ss['Status'][$key]['total'] . "</p>";
       if($aux == 1){
         $values = $values . "," .$ss['Status'][$key]['total'];
       }else{
         $values = $values . $ss['Status'][$key]['total'];
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
        <span class='pie-ss" . $Servico . $cliente ."'>" . $values . "</span>
      </div>
      <div class='col-lg-8 col-xs-8 col-md-8'>
        ". $legenda ."
      </div>
    </div>
    <div class='indis-footer col-lg-12'>
      <b style='color:#D9534F;'>". $ss['Status']['total']  ."</b> ss(es)
    </div>
      <script>
        $(document).ready(function() {
         $('.pie-ss" . $Servico . $cliente ."').peity('pie', {
            fill: " . $this->colorAsArray($colors) .",
            radius: 35
          });
        });
       </script>
   </div>";
  }

  public function ssesAtrasos($ss, $Servico, $cliente=""){

   $legenda = "";
   $values = "";
   $colors = array();
   $aux = 0;
  // debug($ss['Atraso']);
   foreach($ss['Atraso'] as $key => $value):
    if($key != 'total'){
      $colors[$key] = substr(md5($key), 0, 6);
       $legenda = $legenda . "<p class='legend'><span class='color-legend' style='background-color:#" . $colors[$key] .";'></span><b>" . round(($ss['Atraso'][$key]/$ss['Atraso']['total'])*100,2) . "%</b> - " . $key . " - " . $ss['Atraso'][$key] . "</p>";
       if($aux == 1){
         $values = $values . "," .$ss['Atraso'][$key];
       }else{
         $values = $values . $ss['Atraso'][$key];
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
        <span class='pie-ssatraso" . $Servico . $cliente ."'>" . $values . "</span>
      </div>
      <div class='col-lg-8 col-xs-8 col-md-8'>
        ". $legenda ."
      </div>
    </div>
    <div class='indis-footer col-lg-12'>
      <b style='color:#D9534F;'>". $ss['Atraso']['total']  ."</b> ss(es) - (dias em atraso)
    </div>
      <script>
        $(document).ready(function() {
         $('.pie-ssatraso" . $Servico . $cliente ."').peity('pie', {
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

  /*
  * Analisa de forma geral todas as sses de um Cliente
  */
  public function ssesGeral($sses, $cliente){
    $status = array();
    $atrasos = array();

    $status['Status']['total'] = 0;
    foreach($sses as $serv){
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

    $atrasos['Atraso']['total'] = 0;
    foreach($sses as $serv){
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
    foreach($sses as $key => $serv){
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
          <span class='pie-sses-total-Tipo-Serviços-" . $cliente . "'>" . $values . "</span>
        </div>
        <div class='col-lg-8 col-xs-8 col-md-8'>
          ". $legenda ."
        </div>
      </div>
      <div class='indis-footer col-lg-12'>
        <b style='color:#D9534F;'>". $servicos['total']  ."</b> ss(es)
      </div>
      <script>
        $(document).ready(function() {
         $('.pie-sses-total-Tipo-Serviços-" . $cliente ."').peity('pie', {
           fill: " . $this->colorAsArray($colors) .",
           radius: 35
         });
        });
      </script>
    </div>";

    $status = $this->ssesStatus($status, "Status",$cliente);
    $atrasos = $this->ssesAtrasos($atrasos,"Atrasos",$cliente);

    return $status . $atrasos . $servic;
  }


  public function ssTimegraph($ano, $cliente){
    //debug($ano);
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
      	var chart = new CanvasJS.Chart("chartContainerSs'. $cliente .'",
      	{
          title:{
            text: "SS(es) de '. date('Y') .'",
            fontSize: 18
          },
          axisX:{
            title: "Mês",
            titleFontSize: 12
          },
          axisY:{
            title: "Qtd de SS",
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
    <div class="col-lg-9 chart-container" id="chartContainerSs'. $cliente .'" style="height: 300px; max-width: 800px;"></div>';
  }
}?>

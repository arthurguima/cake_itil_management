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
}?>

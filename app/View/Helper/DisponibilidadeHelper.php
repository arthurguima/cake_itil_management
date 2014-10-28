<?php class DisponibilidadeHelper extends AppHelper {

  public function online($url, $method){ // Utilizado no Home
    if($url != null):
      $begin = microtime(true); //Inicio do do c�lculo do tempo de resposta

      $headers = @get_headers($url,1);
      $x =  explode(" ", $headers[0]);

      if($headers == false ){
        $end = microtime(true); //Final do tempo de resposta
        $tempo = $end - $begin;
        return "<td><i class='fa fa-exclamation-circle yellow'></i></td><td> Host desconhecido!</td>";
      }

      if(intval($x[1]) >= 400):
        $end = microtime(true); //Final do tempo de resposta
        $tempo = $end - $begin;
        return "<td><i title='" . $x[1] ."' class='fa fa-times-circle red'></i></td> (" . $headers['Date'] . ") ";
      endif;

      $end = microtime(true); //Final do tempo de resposta
      $tempo = $end - $begin;
      return "<td><i title='" . $x[1] . "' class='fa fa-check-circle green'></i></td><td>" . number_format($tempo,3,",","") . " ms</td>";
    endif;
      return "<td><i class='fa fa-exclamation-triangle yellow'></i></td><td> A URL não foi cadastrada!</td>";
  }

  public function online2($url, $method){ // Utilizada na tabela de servicos
    if($url != null):
      $begin = microtime(true); //Inicio do do c�lculo do tempo de resposta

      $headers = @get_headers($url,1);
      $x =  explode(" ", $headers[0]);

      if($headers == false ){
        $end = microtime(true); //Final do tempo de resposta
        $tempo = $end - $begin;
        return "<i class='fa fa-exclamation-circle yellow' title='Host desconhecido!'></i>";
      }

      if(intval($x[1]) >= 400):
        $end = microtime(true); //Final do tempo de resposta
        $tempo = $end - $begin;
        return "<i class='fa fa-times-circle red' title='" . $x[1] ." (" . $headers['Date'] . ") '></i> ";
      endif;

      $end = microtime(true); //Final do tempo de resposta
      $tempo = $end - $begin;
      return "<i class='fa fa-check-circle green' title='Status code: " . $x[1] . " - Resposta: " . number_format($tempo,3,",","") . " s'></i> ";
    endif;
      return "<i class='fa fa-exclamation-triangle yellow' title='A URL não foi cadastrada!'></i> ";
  }

  public function indisponibilidades($servico){
    $total = 0;
    $ativas = 0;

    foreach ($servico['Indisponibilidade'] as $ind):
      $aux = date_diff(date_create($ind['dt_inicio']),date_create($ind['dt_fim']));
      $total += (($aux->y * 365.25 + $aux->m * 30 + $aux->d) * 24 + $aux->h + $aux->i/60);
      if($ind['dt_fim'] == null): $ativas++; endif;
    endforeach;
    unset($ind);

    if($total > 0): $percent = ($total/330)*100;
    else: $percent = 0;
    endif;

    return "<div class='col-sm-12 col-lg-4  col-md-6 well indis'>
      <div class='col-lg-6 col-xs-6 col-md-6'>
        <a class='servico col-lg-12'><b>" . $servico['Servico']['sigla'] . "</b></a>
        <div class='semicircle'>
          <div id='" . $servico['Servico']['id'] . "' data-dimension='100' data-text='" . round((100 - $percent),2) . "%' data-total='330' data-percent='" . $percent . "' data-part='" . $total . "' data-type='half' data-fontsize='10px'  data-fgcolor='#5CB85C' data-bgcolor='#eee' data-fill='#ddd'></div>
        </div>
      </div>
      <div class='col-lg-6 col-xs-6 col-md-6 pull-right'>
        <b style='color:#D9534F;'>" . count($servico['Indisponibilidade']) . "</b> indisponibilidade(s)
        <p>" . round($total,2) . " hora(s)</p>" . $ativas . " ativa(s)
      </div>
      <script>
        $(document).ready(function() {
          $('#" . $servico['Servico']['id'] . "').circliful();
        });
      </script>
    </div>";
  }

}?>

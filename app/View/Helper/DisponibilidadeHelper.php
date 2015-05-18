<?php class DisponibilidadeHelper extends AppHelper {
  public $helpers = array('Times');

  public function container_online($url, $method){
    if($url != null){
      $headers = @get_headers($url,1);
      $x =  explode(" ", $headers[0]);

      if($headers == false || (intval($x[1]) >= 400)){
        return 0;
      }

      return 1;
    }
    return 0;
  }

  public function online($url, $method){ // Utilizado no Home
    if($url != null):
      $begin = microtime(true); //Inicio do do c�lculo do tempo de resposta

      $headers = @get_headers($url,1);
      $x =  explode(" ", $headers[0]);

      if($headers == false ){
        $end = microtime(true); //Final do tempo de resposta
        $tempo = $end - $begin;
        return "<td><i class='fa fa-exclamation-circle yellow'></i> Host desconhecido!</td>";
      }

      if(intval($x[1]) >= 400):
        $end = microtime(true); //Final do tempo de resposta
        $tempo = $end - $begin;
        return "<td><i title='" . $x[1] ."' class='fa fa-times-circle red'></i> (" . $headers['Date'] . ") </td>";
      endif;

      $end = microtime(true); //Final do tempo de resposta
      $tempo = $end - $begin;
      return "<td><i title='" . $x[1] . "' class='fa fa-check-circle green'></i> " . number_format($tempo,3,",","") . " ms</td>";
    endif;
      return "<td><i class='fa fa-exclamation-triangle yellow'></i> URL não cadastrada!</td>";
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
      return "<i class='fa fa-exclamation-triangle yellow' title='URL não cadastrada!'></i> ";
  }

  public function indisponibilidades($servico,$dt_inicio,$dt_fim){
    $total = 0;
    $ativas = 0;
    $contabilizadas = 0;

    foreach ($servico['Indisponibilidade'] as $ind):
      if($ind['Motivo']['contavel'] != 0){ //
        $contabilizadas++;
        //$aux = date_diff(date_create($ind['dt_inicio']),date_create($ind['dt_fim']));
        $total += $this->Times->diffInSec($ind['dt_inicio'], $ind['dt_fim']);
      }

      if($ind['dt_fim'] == null){ $ativas++; }
    endforeach;
    unset($ind);

    if($total > 0){
      if(date("d") < 21){
        $dt_inicio = "21/" . date("m/Y",strtotime("-1 month"));
        $dt_fim =  "20/" . date('m/Y');
      }
      else{
        $dt_inicio = "21/" . date('m/Y');
        $dt_fim = "20/" . date("m/Y",strtotime("+1 month"));
      }
      $percent = ($total / $this->Times->diffInSec(
            $this->Times->AmericanDate($dt_inicio), $this->Times->AmericanDate($dt_fim)))*100;
    }
    else{
      $percent = 0;
    }

    return "
      <div class='col-sm-12 col-lg-2  col-md-4 well indis'>
        <a class='servico' href=". Router::url('/', true). "relatorios/indisponibilidades?servico_id=" . $servico['Servico']['id'] . "&dt_inicio=" . $dt_inicio . "&dt_fim=" . $dt_fim . ">
          <div class='indis-tittle col-lg-12'>
              <b>" . $servico['Servico']['sigla'] . "</b>
          </div>
          <div class='indis-body col-lg-12'>
            <div class='col-lg-6 col-xs-6 col-md-12'>
              <div class='semicircle'>
                <div id='" . $servico['Servico']['id'] . "' data-dimension='50' data-width='4'  data-text='" . round((100 - $percent),2) . "%' data-total='100' data-percent='" . $percent . "' data-fontsize='11'  data-fgcolor='#d9534f' data-bgcolor='#5CB85C' data-fill='#EEE'></div>
                </div>
            </div>
            <div class='col-lg-6 col-xs-6 col-md-12 indis-text'>
              " . $this->Times->SecToString($total) . "<br /> <span class=". ($ativas ? "red" : "")  .">" . $ativas . " ativa(s)</span>
            </div>
          </div>
          <div class='indis-footer col-lg-12'>
            <b style='" . (count($servico['Indisponibilidade']) ? "color:#D9534F;" : " ")  .
            "'>" . count($servico['Indisponibilidade']) . "</b> registrada(s) / <b style='" . ($contabilizadas ? "color:#D9534F;" : " ") .
            "'>" . $contabilizadas  . "</b> contabilizada(s)
          </div>
          <script>
            $(document).ready(function() {
              $('#" . $servico['Servico']['id'] . "').circliful();
            });
          </script>
        </a>
      </div>";
  }

}?>

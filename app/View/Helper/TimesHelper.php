<?php class TimesHelper extends AppHelper {
  public $helpers = array('Time');
    /*
    * Data de Início
    * Data prevista
    * Texto mostrado
    * Data de finalização
    */
    public function timeLeftTo($time1, $time2, $string, $time3) {
        $time1 = $this->AmericanDate($time1);
        $time2 = $this->AmericanDate($time2);
        $time3 = $this->AmericanDate($time3);

        /* Se ainda não foi homologado*/
        if ($time3 == null){

          /* Se ainda não haja uma previsão*/
          if($time2 == null){
            return "<div style='font-size: 12px;'><i class='fa fa-exclamation-circle' style='color: #D9534F;'></i>
                    Previsão Indisponível <i class='fa fa-exclamation-circle' style='color: #D9534F;'></i></div>" ;
          }

          /* Se não foi Homologado e está atrasado */
          if(strtotime($time2) < time()){
            return  " <span class='small'>" . $string . "</span>
                      <div class='progress active'>
                            <div class='progress-bar progress-bar-danger 'role='progressbar' aria-valuenow='100' aria-valuemin='0'
                            aria-valuemax='100' style='width: 100%'>
                            <i class='fa fa-exclamation-circle' style='color:white;'></i>
                            <b>Atrasado </b><i class='fa fa-exclamation-circle' style='color:white;'></i></div>
                      </div>";
          }

          /* Coloca as datas no formato para o calculo de tempo */
            $t1 = date_create($time1); $t2 = date_create($time2);
            $total = date_diff($t1,$t2); // Tempo total entre a data de Início e a prevista

            $left = date_diff(date_create(date('Y-m-d', time())),$t2); // Tempo entre a data de Hoje e data prevista
            $per = 100 - (($left->days / $total->days) * 100); // Quanto o $left representa do Tempo total

            $color = $this->color($per);

          return "<span class='small'>" . $string . "</span>
                  <div class='progress progress-striped active'>
                    <div class='progress-bar progress-bar-" . $color . "' role='progressbar' aria-valuenow='"
                    . $per . "' aria-valuemin='0' aria-valuemax='100' style='width: " . $per . "%'></div>
                  </div>";
        }
        /* Se já foi homologado */
        else{
          return "<div class=''><span class='label label-default'>" . $this->Time->format('d/m/Y', $time1) . " - " .
                   $this->Time->format('d/m/Y', $time3) . "</span></div>";
        }
    }
      /*
      * Seleciona a classe utilizada na Barra de Prazo de acordo com a porcentagem
      */
      private function color($value){
          if ( $value < 50):
            $color = "success";
          elseif( 50 < $value && $value < 80):
            $color = "warning";
          else:
            $color = "danger";
          endif;
          return $color;
      }

      /*
      * Coloca as datas no formato americano
      */
      private function AmericanDate($time){
        if($time != null){
          return date("Y-m-d", strtotime(str_replace('/', '-', $time)));
        }
        else{
          return $time;
        }
      }

    /*
    * Destaca a data mostrando se está no passado ou não
    */
    public function pastDate($time) {
        if (strtotime($time) > time()):
           return "<span class='label label-success'>" .  $this->Time->format('d/m/Y', $time) . "</span>";
        else:
           return "<span class='label label-default'>" . $this->Time->format('d/m/Y', $time) . "</span>";
        endif;
    }

    /*
    * Destaca a se o item está ativo ou não
    */
    public function active($bol, $class="") {
        if ($bol):
          return "<span class='label label-success' id='" . $class . "'>Ativo</span>";
        else:
          return "<span class='label label-default' id='" . $class . "'>Inativo</span>";
        endif;
    }

    /*
    * Destaca a se o item está ativo ou não
    */
    public function yesOrNo($bol, $class="") {
        if ($bol):
          return "<span class='label label-success' id='" . $class . "'>Sim</span>";
        else:
          return "<span class='label label-default' id='" . $class . "'>Não</span>";
        endif;
    }


    /*
    * Quanto tempo se passou entre duas datas
    * considerando o dia de trabalho da dataprev 07:00 até 22:00
    */
    public function totalTime($time1, $time2) {
      $t1 = date_create($time1);
      $t2 = date_create($time2);
      $total = date_diff($t1,$t2);

      return (($total->y * 365.25 + $total->m * 30 + $total->d) * 24 + $total->h). "h " . $total->i . "min" ;
    }
}?>

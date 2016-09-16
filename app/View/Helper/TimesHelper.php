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

        if($time1 == null){
          return "Indisponível <i class='fa fa-exclamation-circle' style='color: #D9534F; font-size: 12px;'></i>" ;
        }

        /* Se ainda não foi homologado*/
        if ($time3 == null){

          /* Se ainda não ha uma previsão*/
          if($time2 == null){
            return "Indisponível <i class='fa fa-exclamation-circle' style='color: #D9534F; font-size: 12px;'></i>" ;
          }

          /* Se não foi Homologado e está atrasado */
          if(strtotime($time2) < time()){
            return  " <span class='small red'>" . $string . "</span>
                        <i class='small fa fa-exclamation-circle red'></i>
                        <b class='small'>Atrasado </b><i class='fa fa-exclamation-circle red small'></i>
                    ";
          }

          /* Coloca as datas no formato para o calculo de tempo */
            $t1 = date_create($time1); $t2 = date_create($time2);
            $total = date_diff($t1,$t2); // Tempo total entre a data de Início e a prevista

            $left = date_diff(date_create(date('Y-m-d', time())),$t2); // Tempo entre a data de Hoje e data prevista
            $per = 100 - (($left->days / $total->days) * 100); // Quanto o $left representa do Tempo total

            $color = $this->color($per);

          return "<span class='small'>" . $string . "</span>
                  <div class='progress progress-striped active progress-xs'>
                    <div class='progress-bar progress-bar-" . $color . "' role='progressbar' aria-valuenow='"
                    . $per . "' aria-valuemin='0' aria-valuemax='100' style='width: " . $per . "%'></div>
                  </div>";
        }
        /* Se já foi homologado */
        else{
          return "<div class='finished'><span class='label label-default'>" . $this->Time->format('d/m/Y', $time1) . " - " .
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

      public function timeLeftTo_days($time) {
        $t1 = date_create(preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$time));
        $t2 = date_create(date('Y-m-d'));
        $total = date_diff($t1,$t2);

        return $total->days;
      }

      /*
      * Coloca as datas no formato americano
      */
      public function AmericanDate($time){
        if($time != null){
          return date("Y-m-d", strtotime(str_replace('/', '-', $time)));
        }
        else{
          return $time;
        }
      }

      /*
      * Coloca as datas no formato americano
      */
      public function CleanDate($time){
        if($time != null){
          return date("Ymd", strtotime(str_replace('/', '-', $time)));
        }
        else{
          return $time;
        }
      }

    /*
    * Destaca a data mostrando se está no passado ou não
    */
    public function pastDate($time) {
        if (strtotime($this->AmericanDate($time)) > time()):
           return "<span class='label label-success'>" . $time . "</span>";
        else:
          if ($this->AmericanDate($time) == date("Y-m-d")) {
            return "<span class='label label-warning'>" . $time . "</span>";
          }
          return "<span class='label label-default'>" . $time . "</span>";
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
    * considerando o dia de trabalho da dataprev  (aproximado)
      Segunda-Sexta, 07:00-22:00 hs
      Sábado, 07:00-14:00 hs
    */
    public function totalTime($time1, $time2) {
      $t1 = date_create($time1);
      $t2 = date_create($time2);
      $total = date_diff($t1,$t2);

      $value = ($total->y * 365.25 + $total->m * 30 + $total->d) * 15;
      $value -= round($value/7,0);
      return ($value + $total->h). "h " . round($total->i,2) . "min" ;
    }

    /*
    * Quanto tempo se passou entre duas datas em segundos
    * considerando o dia de trabalho da dataprev (aproximado)
      Segunda-Sexta, 07:00-22:00 hs
      Sábado, 07:00-14:00 hs
    */
    public function diffInSec($time1, $time2) {
      $t1 = date_create($time1);
      $t2 = date_create($time2);
      $total = date_diff($t1,$t2);

      $value = ($total->y * 365.25 + $total->m * 30 + $total->d) * 15;
      $value -= $value/7;
      $value = (( $value + $total->h) * 60 + $total->i)*60 + $total->s;
      return $value;
    }

    /*
    * Recebe um total de tempo em segundos e retorna uma string em Horas
    */
    public function SecToString($time) {
      return floor(($time/3600)) . "h " . round(($time%3600)/60,2) . "min";
    }
}?>

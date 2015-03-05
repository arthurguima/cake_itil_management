<?php class OrdHelper extends AppHelper {
  public $helpers = array('Times');

  public function getCheckList($ths, $trp, $trd){

      $value = "<span>";


      if($trp != null){
         $value = $value . "<a target='_blank' href='" . $trp . "' title='TRP'><b>TRP</b> <i class='fa fa-check-square-o fa-done checklist'><span>(OK)</span></i></a>";
      }else{
        $value = $value . "<a title='TRP'><b>TRP</b> <i class='fa fa-square-o fa-undone checklist'><span>(  )</span></i></a> ";
      }

      if($ths != null){
          $value = $value . "<a target='_blank' href='" . $ths . "' title='TH' ><b>TH</b> <i class='fa fa-check-square-o fa-done checklist'><span>(OK)</span></i></a>  ";
      }else{
          $value = $value . "<a title='TH'><b>TH</b> <i class='fa fa-square-o fa-undone checklist'><span>(  )</span></i></a>  ";
      }

      if($trd != null){
         $value = $value . "<a target='_blank' href='" . $trd . "' title='TRD'><b>TRD</b> <i class='fa fa-check-square-o fa-done checklist'><span>(OK)</span></i></a>";
      }else{
        $value = $value . "<a title='TRD'><b>TRD</b> <i class='fa fa-square-o fa-undone checklist'><span>(  )</span></i></a>";
      }

      return $value . "</span>";

  }

  public function PrazocheckList($dt_ini, $trp, $dt_trp, $th, $dt_th, $trd, $dt_trd){

    if($trp != null){// possui o termo provisório
      if($th != null){// possui o termo de homologação
        if($trd != null){// possui o termo definitivo
          return "<span></span>";
        }
        else{// não possui o termo definitivo
          if( $dt_trd != null){
            return $this->Times->timeLeftTo($dt_ini, $dt_trd, $dt_ini . " - " . $dt_trd, null);
          }
        }
      }
      else{// não possui o termo de homologação
        if( $dt_th != null){
          return $this->Times->timeLeftTo($dt_ini, $dt_th, $dt_ini . " - " . $dt_th, null);
        }
      }
    }
    else{// não possui o termo provisório
      if( $dt_trp != null){
        return $this->Times->timeLeftTo($dt_ini, $dt_trp, $dt_ini . " - " . $dt_trp, null);
      }
    }

  }

}?>

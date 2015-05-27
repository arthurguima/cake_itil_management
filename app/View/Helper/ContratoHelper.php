<?php class ContratoHelper extends AppHelper {

    public function VolumeRestante($total, $metrica) {
      if($total < 0)
        return "<span class='red' style='font-size: 15px !important;font-weight: bold;'>". $total ." " . $metrica ."</span>";
      else
        return "<span class='green' style='font-size: 15px !important;font-weight: bold;'>". $total ." " . $metrica ."</span>";
    }
}?>

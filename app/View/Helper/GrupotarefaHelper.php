<?php class GrupotarefaHelper extends AppHelper {

    public function tipo($tipo) {
      switch ($tipo) {
        case 1:
            return 'Demandas';
        case 3:
            return 'RDMs';
        case 4:
            return 'Chamados';
        case 6:
            return 'Releases';
      }
    }
}?>

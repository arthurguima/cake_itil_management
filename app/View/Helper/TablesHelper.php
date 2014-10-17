<?php class TablesHelper extends AppHelper {

  /*
  * Exibe um texto em popup
  */
  public function popupBox($string) {
    return "<a type='button' data-container='body' data-toggle='popover'
            data-placement='top'
            data-content='" . $string ."'
            data-original-title='' title='Descrição'>
              <div class='sub-20'>" .  $string . "</div>
            </a>";
  }

  public function StatusEditable($id, $controller){
    return  "
            <script>
              $(document).ready(function() {
                  $('#" . $id . "').editable('" . Router::url('/', true). "/indisponibilidades/ajax_edit_status',{
                     name: 'status',
                     data   : \"{0:'Fechado'}\",
                     type   : 'select',
                     submit: \"<button class='btn btn-sm btn-default' type='submit' >Salvar</button>\",
                  });
              });
            </script>";
  }

  public function DemandaStatusEditable($id){
    return  '
            <script>
              $(document).ready(function() {
                  $("#status-' . $id . '").editable("' . Router::url('/', true). '/demandas/ajax_edit_status",{
                     name: "status_id",
                     loadurl : "' . Router::url('/', true). '/status/json?tipo=1",
                     type   : "select",
                     submit: \'<button class="btn btn-sm btn-default" type="submit" >Salvar</button>\',
                  });
              });
            </script>';
  }

  public function PrioridadeEditable($id, $controller){
    return  "
            <script>
              $(document).ready(function() {
                  $('#" . $id . "').editable('" . Router::url('/', true). "/demandas/ajax_edit_prioridade',{
                     name: 'prioridade',
                     width:($('#" . $id . "').width() + 20) + 'px',
                     height:($('#" . $id . "').height() + 6) + 'px',
                     submit: \"<button class='btn btn-sm btn-default' type='submit' >Salvar</button>\",
                  });
              });
            </script>";
  }

}?>

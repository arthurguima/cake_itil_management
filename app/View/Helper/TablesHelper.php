<?php class TablesHelper extends AppHelper {
  public $helpers = array('Html', 'Form');
  /*
  * Exibe um texto em popup
  */
  public function popupBox($string, $description=null) {
    return "<a type='button' data-container='body' data-toggle='popover'
            data-placement='top'
            data-content='" . (($description != null) ? "<b>". $string  ."</b><br />" : $string) . " " . $description . "'
            data-original-title='' title='Descrição'>
              <div class='sub-20'>" . $string . "</div>
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

  /*
  * Imprime os menus da Tabela de Index
  * 2: Visualizar
  * 4: Editar
  * 8: Excluir
  * Qualquer soma entre os valores resulta nos menus dos valores somados: Ex: Visuzlizar e Excluir (2+8 = 10)
  */
  public function getMenu($controller, $id, $actions=14){

    return ( (($actions == 2) || ($actions == 6) || ($actions == 10) || ($actions == 14)) ?
            $this->Html->link("<i class='fa fa-search-plus ' style='margin-right: 5px;' title='Visualizar detalhes da demanda.'></i>",
            array('controller' => $controller, 'action' => 'view', $id),
            array('escape' => false)) : "") .

           ( (($actions == 4) || ($actions == 6) || ($actions == 12) || ($actions == 14)) ?
            $this->Html->link("<i class='fa fa-pencil' title='Editar demanda.'></i>",
            array('controller' => $controller, 'action' => 'edit', $id),
            array('escape' => false)) : "") .

           ( (($actions == 8) || ($actions == 10) || ($actions == 12) || ($actions == 14)) ?
            $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;' title='Excluir " . $controller . ".'></i>",
            array('controller'=> $controller, 'action' => 'delete', $id),
            array('escape' => false), "O registro será excluído, você tem certeza dessa ação?") : "");
  }
}?>

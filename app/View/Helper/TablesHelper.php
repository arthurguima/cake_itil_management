<?php class TablesHelper extends AppHelper {
  public $helpers = array('Html', 'Form', 'Ldap');
  /*
  * Exibe um texto em popup
  */
  public function popupBox($string, $description=null) {
    $value = h(((($description != null) ? "<b>". ($string)  ."</b><br />" : $string) . " " . $description));

    return '<div type="button" data-container="body" data-toggle="popover" data-placement="right" data-content="' . $value .
            '"<div class="sub-20">' . $string . '</div>
            </div>';
  }

  public function popupBox2($string, $description=null, $margin = "38") {
    $value = h(((($description != null) ? "<b>". ($string)  ."</b><br />" : $string) . " " . $description));

    return '<div class="pull-right" style="margin-right: '. $margin .'px; max-width: 10px;" type="button" data-container="body" data-toggle="popover2" data-original-title="Guias" data-placement="left" data-content="' . $value . '"><i class="fa fa-question-circle"></i></div>';
  }

  public function StatusEditable($id, $controller){
    return  "
            <script>
              $(document).ready(function() {
                  $('#" . $id . "').editable('" . Router::url('/', true). "/indisponibilidades/ajax_edit_status',{
                     name: 'status',
                     data   : \"{0:'Fechado'}\",
                     type   : 'select',
                     submit: \"<button class='btn btn-sm btn-success' type='submit' >Salvar</button>\",
                     cancel: \"<button class='btn btn-sm btn-danger' type='cancel' >Cancelar</button>\",
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
                     submit: \'<button class="btn btn-sm btn-success" type="submit" >Salvar</button>\',
                     cancel: \'<button class="btn btn-sm btn-danger" type="cancel" >Cancelar</button>\',
                  });
              });
            </script>';
  }

  public function SsStatusEditable($id){
    return  '
            <script>
              $(document).ready(function() {
                  $("#status-' . $id . '").editable("' . Router::url('/', true). '/sses/ajax_edit_status",{
                     name: "status_id",
                     loadurl : "' . Router::url('/', true). '/status/json?tipo=2",
                     type   : "select",
                     submit: \'<button class="btn btn-sm btn-success" type="submit" >Salvar</button>\',
                     cancel: \'<button class="btn btn-sm btn-danger" type="cancel" >Cancelar</button>\',
                  });
              });
            </script>';
  }

  public function PeStatusEditable($id){
    return  '
            <script>
              $(document).ready(function() {
                  $("#statuspa-' . $id . '").editable("' . Router::url('/', true). '/pes/ajax_edit_status",{
                     name: "status_id",
                     loadurl : "' . Router::url('/', true). '/status/json?tipo=4",
                     type   : "select",
                     submit: \'<button class="btn btn-sm btn-success" type="submit" >Salvar</button>\',
                     cancel: \'<button class="btn btn-sm btn-danger" type="cancel" >Cancelar</button>\',
                  });
              });
            </script>';
  }

  public function OrdStatusEditable($id){
    return  '
            <script>
              $(document).ready(function() {
                  $("#statusos-' . $id . '").editable("' . Router::url('/', true). '/ords/ajax_edit_status",{
                     name: "status_id",
                     loadurl : "' . Router::url('/', true). '/status/json?tipo=3",
                     type   : "select",
                     submit: \'<button class="btn btn-sm btn-success" type="submit" >Salvar</button>\',
                     cancel: \'<button class="btn btn-sm btn-danger" type="cancel" >Cancelar</button>\',
                  });
              });
            </script>';
  }

  public function ChamadoStatusEditable($id){
    return  '
            <script>
              $(document).ready(function() {
                  $("#status-' . $id . '").editable("' . Router::url('/', true). '/chamados/ajax_edit_status",{
                     name: "status_id",
                     loadurl : "' . Router::url('/', true). '/status/json?tipo=5",
                     type   : "select",
                     submit: \'<button class="btn btn-sm btn-success" type="submit" >Salvar</button>\',
                     cancel: \'<button class="btn btn-sm btn-danger" type="cancel" >Cancelar</button>\',
                  });
              });
            </script>';
  }

  public function PrioridadeEditable($id, $controller){
    return  "
            <script>
              $(document).ready(function() {
                  $('#" . $id . "').editable('" . Router::url('/', true). $controller . "/ajax_edit_prioridade',{
                     name: 'prioridade',
                     width:($('#" . $id . "').width() + 20) + 'px',
                     height:($('#" . $id . "').height() + 6) + 'px',
                     submit: \"<button class='btn btn-sm btn-success' type='submit' >Salvar</button>\",
                     cancel: \"<button class='btn btn-sm btn-danger' type='cancel' >Cancelar</button>\",
                  });
              });
            </script>";
  }

  public function SubtarefaStatusEditable($id, $controller){
    return  "
            <script>
              $(document).ready(function() {
                  $('#sub-" . $id . "').editable('" . Router::url('/', true). "/subtarefas/ajax_edit_status',{
                     name: 'check',
                     data   : \"{2:'Aguardando Início', 0:'Em andamento', 1:'Finalizada' }\",
                     type   : 'select',
                     submit: \"<button class='btn btn-sm btn-success' type='submit' >Salvar</button>\",
                     cancel: \"<button class='btn btn-sm btn-danger' type='cancel' >Cancelar</button>\",
                  });
              });
            </script>";
  }

  public function RdmCheckEditable($id, $controller, $column){
    return  "
            <script>
              $(document).ready(function() {
                  $('#rdm-" . $column . "-" . $id . "').editable('" . Router::url('/', true). "/rdms/ajax_edit_item',{
                     name: 'check',
                     data   : \"{0:'Desmarcar', 1:'Marcar'}\",
                     type   : 'select',
                     submit: \"<button class='btn btn-sm btn-success' type='submit' >Salvar</button>\",
                     cancel: \"<button class='btn btn-sm btn-danger' type='cancel' >Cancelar</button>\",
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

    $menu = ( (($actions == 2) || ($actions == 6) || ($actions == 10) || ($actions == 14)) ?
            $this->Html->link("<i class='fa fa-search-plus ' style='margin-right: 5px;' title='Visualizar detalhes'></i>",
            array('controller' => $controller, 'action' => 'view', $id),
            array('escape' => false)) : "");

    if($this->Ldap->autorizado(2)){
      $menu = $menu .
           ( (($actions == 4) || ($actions == 6) || ($actions == 12) || ($actions == 14)) ?
            $this->Html->link("<i class='fas fa-pencil-alt' title='Editar'></i>",
            array('controller' => $controller, 'action' => 'edit', $id),
            array('escape' => false)) : "");
    }

    if($this->Ldap->autorizado(1)){
        if (($actions == 8) || ($actions == 10) || ($actions == 12) || ($actions == 14)){
            $menu =  $menu . $this->Form->postLink("<i class='fas fa-times' style='margin-left: 5px;' title='Excluir " . $controller . ".'></i>",
                    array('controller'=> $controller, 'action' => 'delete', $id),
                    array('escape' => false), "O registro será excluído, você tem certeza dessa ação?");
        }
        else{
          $menu =  $menu . "";
        }
    }

    return $menu;
  }
}?>

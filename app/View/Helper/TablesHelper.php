<?php class TablesHelper extends AppHelper {
  public $helpers = array('Html', 'Form', 'Ldap');
  /*
  * Exibe um texto em popup
  */
  public function popupBox($string, $description=null) {
    $value = h(((($description != null) ? "<b>". ($string)  ."</b><br />" : $string) . " " . $description));

    return '<div type="button" data-container="body" data-toggle="popover" data-original-title="Descrição" data-placement="right" data-content="' . $value .
            '"<div class="sub-20">' . $string . '</div>
            </div>';
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

  public function SsStatusEditable($id){
    return  '
            <script>
              $(document).ready(function() {
                  $("#status-' . $id . '").editable("' . Router::url('/', true). '/sses/ajax_edit_status",{
                     name: "status_id",
                     loadurl : "' . Router::url('/', true). '/status/json?tipo=2",
                     type   : "select",
                     submit: \'<button class="btn btn-sm btn-default" type="submit" >Salvar</button>\',
                  });
              });
            </script>';
  }

  public function PeStatusEditable($id){
    return  '
            <script>
              $(document).ready(function() {
                  $("#status-pe-' . $id . '").editable("' . Router::url('/', true). '/pes/ajax_edit_status",{
                     name: "status_id",
                     loadurl : "' . Router::url('/', true). '/status/json?tipo=4",
                     type   : "select",
                     submit: \'<button class="btn btn-sm btn-default" type="submit" >Salvar</button>\',
                  });
              });
            </script>';
  }

  public function OrdStatusEditable($id){
    return  '
            <script>
              $(document).ready(function() {
                  $("#status-os-' . $id . '").editable("' . Router::url('/', true). '/ords/ajax_edit_status",{
                     name: "status_id",
                     loadurl : "' . Router::url('/', true). '/status/json?tipo=3",
                     type   : "select",
                     submit: \'<button class="btn btn-sm btn-default" type="submit" >Salvar</button>\',
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
                     submit: \'<button class="btn btn-sm btn-default" type="submit" >Salvar</button>\',
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

    $menu = ( (($actions == 2) || ($actions == 6) || ($actions == 10) || ($actions == 14)) ?
            $this->Html->link("<i class='fa fa-search-plus ' style='margin-right: 5px;' title='Visualizar detalhes'></i>",
            array('controller' => $controller, 'action' => 'view', $id),
            array('escape' => false)) : "") .

           ( (($actions == 4) || ($actions == 6) || ($actions == 12) || ($actions == 14)) ?
            $this->Html->link("<i class='fa fa-pencil' title='Editar'></i>",
            array('controller' => $controller, 'action' => 'edit', $id),
            array('escape' => false)) : "");

    if($this->Ldap->autorizado()){
        if (($actions == 8) || ($actions == 10) || ($actions == 12) || ($actions == 14)){
            $menu =  $menu . $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;' title='Excluir " . $controller . ".'></i>",
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

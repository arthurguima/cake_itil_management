<?php
  $this->Html->addCrumb('Indicadores', '/indicadores');
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      Indicadores das regras de ANS
      <div class="col-lg-2 pull-right">
        <?php /*
          if($this->Ldap->autorizado(2)){
            echo $this->Html->link("<i class='fa fa-plus'></i> Nova",
             array('controller' => 'Indisponibilidades', 'action' => 'add'),
             array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false));
          }*/
        ?>
      </div>
    </h3>
  </div>

  <div class="col-lg-12 pull-left filters">
    <div class="">
      <div class="row"><span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">Filtros <i class="fa fa-plus-square"></i></span></div>
      <div class="row inner">
        <?php  echo $this->BootstrapForm->create(false, array('class' => 'form-inline')); ?>
        <div class="col-lg-12 filters-item">
          <div class="form-group" style="float:left;">
            <?php echo $this->BootstrapForm->input('contrato_id', array(
                              'label' => array('text' => 'Contrato: '),
                              'class' => "form-control pull-right",
                              'empty' => 'Contrato')); ?>
          </div>
          <div id="aditivoList" style="float:left;"></div>
        </div>
        <?php
          echo $this->BootstrapForm->button("Filtrar <i class='fa fa-search'></i>", array('type' => 'submit', 'class' => 'control-label btn btn-default pull-right'));
          echo $this->BootstrapForm->end();
        ?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"><b> Lista de Indicadores </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-Indicadores">
            <thead>
              <tr>
                <th>Contrato/Aditivo</th>
                <th>Regra</th>
                <th>Data</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($indicadores as $in): ?>
                <tr>
                  <td>
                    <?php
                      if(isset($in['Regra']['Contrato']['numero']))
                        echo $in['Regra']['Contrato']['numero'];
                      else
                        echo $in['Regra']['Aditivo']['Contrato']['numero'] . " - Aditivo " . $in['Regra']['Aditivo']['dt_inicio'];
                    ?>
                  </td>
                  <td><?php echo $in['Regra']['nome']; ?></td>
                  <td><?php echo $in['Indicadore']['mes'] . "/" . $in['Indicadore']['ano']; ?></td>
                  <td>
                    <?php
                      echo $this->Html->link("<i class='fa fa-search-plus'></i> ",
                         array('controller' => 'indicadores', 'action' => 'view', $in['Indicadore']['id'], '?' => array('controller' => 'indicadores', 'action' => 'index', 'id' =>'' )),
                         array('escape' => false));

                      if($this->Ldap->autorizado(2)){
                        echo $this->Html->link("<i class='fa fa-pencil'></i>",
                              array('controller' => 'indicadores', 'action' => 'edit', $in['Indicadore']['id'], '?' => array('controller' => 'indicadores', 'action' => 'index', 'id' =>'' )),
                              array('escape' => false));
                        echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                              array('controller' => 'indicadores', 'action' => 'delete', $in['Indicadore']['id'], '?' => array('controller' => 'indicadores', 'action' => 'index', 'id' =>'' )),
                              array('escape' => false), "Você tem certeza");
                      }
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
              <?php unset($in); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
/* Lista de Aditivos */
  function getAditivos(contrato){
    $.ajax({
      url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "aditivos/optionlist?controller=relatorios&contrato=" + contrato,
      cache: false,
      success: function(html){
        $("#aditivoList").html(html);
      }
    });
  }

  $(document).ready(function() {
    // Quando selecionado o Contrato
    $( "select#contrato_id" ).change(function () {
      var str = "";
      $( "select#contrato_id option:selected" ).each(function() {
         //getItens("Contrato", $(this).val());
         getAditivos($(this).val());
      })
    }).change();
  });
</script>

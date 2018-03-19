<?php
  $this->Html->addCrumb('Indicadores', '/indicadores');
?>
<div class="col-lg-12 page-header-box">
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
                <th>Data</th>
                <th>Contrato/Aditivo</th>
                <th>Regra</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($indicadores as $in): ?>
                <tr>
                  <td><?php echo $in['Indicadore']['mes'] . "/" . $in['Indicadore']['ano']; ?></td>
                  <td>
                    <?php
                      if(isset($in['Regra']['Contrato']['numero']))
                        echo $in['Regra']['Contrato']['numero'];
                      else
                        echo $in['Regra']['Aditivo']['Contrato']['numero'] . " - Aditivo " . $in['Regra']['Aditivo']['dt_inicio'];
                    ?>
                  </td>
                  <td><?php echo $in['Regra']['nome']; ?></td>
                  <td>
                    <?php
                      echo $this->Html->link("<i class='fa fa-search-plus'></i> ",
                         array('controller' => 'indicadores', 'action' => 'view', $in['Indicadore']['id'], '?' => array('controller' => 'indicadores', 'action' => 'index', 'id' =>'' )),
                         array('escape' => false));

                      if($this->Ldap->autorizado(2)){
                        echo $this->Html->link("<i class='fa fa-pencil'></i>",
                              array('controller' => 'indicadores', 'action' => 'edit', $in['Indicadore']['id'], '?' => array('controller' => 'indicadores', 'action' => 'index', 'id' =>'' )),
                              array('escape' => false));
                        echo $this->Form->postLink("<i class='fas fa-times' style='margin-left: 5px;'></i>",
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

<?php
  //-- DataTables JavaScript --
  echo $this->Html->script('plugins/dataTables/media/js/jquery.dataTables.js');
  echo $this->Html->script('plugins/dataTables/dataTables.bootstrap.js');
  echo $this->Html->css('plugins/dataTables.bootstrap.css');
  //-- DataTables --> TableTools
  echo $this->Html->script('plugins/dataTables/extensions/TableTools/js/dataTables.tableTools.min.js');
  echo $this->Html->css('plugins/dataTablesExtensions/TableTools/css/dataTables.tableTools.min.css');
  //-- DataTables --> Responsive
  echo $this->Html->script('plugins/dataTables/extensions/Responsive/js/dataTables.responsive.min.js');
  echo $this->Html->css('plugins/dataTablesExtensions/Responsive/css/dataTables.responsive.css');
  //-- DataTables --> ColVis
    echo $this->Html->script('plugins/dataTables/extensions/ColVis/js/dataTables.colVis.min.js');
    echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colVis.min.css');
    echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colvis.jqueryui.css');
?>

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


    var  oTable =  $('#dataTables-Indicadores').dataTable({
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
          language: {
            url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
          },
          "dom": 'TC<"clear">lfrtip',
          "colVis": {
            "buttonText": "Esconder Colunas"
          },
          "tableTools": {
              "sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
              "aButtons": [
                {
                    "sExtends": "copy",
                    "sButtonText": "Copiar",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "sFileName": "Indicadores.csv",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "sFileName": "Indicadores.pdf",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    //"mColumns": [ 0,1,2,3,4,5,7,8 ],
                    "sPdfOrientation": "landscape",
                    "sTitle": "Controle de Indicadores",
                    "sPdfMessage": "Extraído em: <?php echo date('d/m/y')?>",
                },
              ]
          }
      });
      var colvis = new $.fn.dataTable.ColVis( oTable );
  });
</script>

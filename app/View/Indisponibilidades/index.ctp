<?php
  $this->Html->addCrumb('Indisponibilidades', '/indisponibilidades');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Controle de Disponibilidade
        <div class="col-lg-2 pull-right">
          <?php
            if($this->Ldap->autorizado(2)){
              echo $this->Html->link("<i class='fa fa-plus'></i> Nova",
               array('controller' => 'Indisponibilidades', 'action' => 'add'),
               array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false));
            }
          ?>
        </div>
      </h3>
    </div>
    <div class="col-lg-12 pull-left filters">
      <div class="">
        <div class="row"><span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">Filtros <i class="fa fa-plus-square"></i></span></div>
        <div class="row inner" style="display: none;">
          <?php echo $this->Search->create("", array('class' => 'form-inline')); ?>
          <div class="col-lg-12 filters-item">
            <div class="form-group">
              <b>Data de Início: </b>
              <?php echo $this->Search->input('dtinicio',
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
              ?>
              <b>Data de Término: </b>
              <?php echo $this->Search->input('dtfim',
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
              ?>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="form-group"><?php echo $this->Search->input('motivo', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('servico', array('class' => 'form-control')); ?></div>
          </div>
          <?php
            echo $this->Form->button("Filtrar <i class='fa fa-search'></i>", array('type' => 'submit',
                      'onclick' => 'javascript:if(oTable != null)oTable.fnDestroy();', 'class' => 'control-label btn btn-default pull-right'));
            echo $this->Search->end();
          ?>
        </div>
    </div>
    </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"><b> Lista de Indisponibilidades </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-Indisponibilidades">
            <thead>
              <tr>
                <th>Serviço</th>
                <th>Nº Evento   <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
                <th>Nº Incidente   <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
                <th>Início</th>
        				<th>Duração</th>
        				<th>Motivo</th>
                <th>Observação</th>
        				<th><span class="editable">Status</span></th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($Indisponibilidades as $Indisponibilidade): ?>
                <tr>
                  <td class="area-list">
                    <?php
                        foreach($Indisponibilidade['Servico'] as $servico):
                          echo $this->Html->link($servico['sigla'] . "  ",
                          array('controller' => 'servicos', 'action' => 'view', $servico['id']));
                        endforeach;
                    ?>
                  </td>
                  <td>
                    <?php
                      echo $this->Html->link($Indisponibilidade['Indisponibilidade']['num_evento'],
                            "http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH+FACTORY=in+SKIPLIST=1+QBE.IN.ref_num=" . $Indisponibilidade['Indisponibilidade']['num_evento'] . "%25",
                            array('target' => '_blank'));
                    ?>
                  </td>
                  <td>
                    <?php
                      echo $this->Html->link($Indisponibilidade['Indisponibilidade']['num_incidente'],
                            "http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH+FACTORY=in+SKIPLIST=1+QBE.IN.ref_num=" . $Indisponibilidade['Indisponibilidade']['num_incidente'] . "%25",
                            array('target' => '_blank'));
                    ?>
                  </td>
        				  <td data-order=<?php echo $this->Time->format('Ymd', $Indisponibilidade['Indisponibilidade']['dt_inicio']); ?>>
                    <?php echo $this->Time->format('d/m/Y h:i:s', $Indisponibilidade['Indisponibilidade']['dt_inicio']); ?>
                  </td>
                  <td>
                    <?php if($Indisponibilidade['Indisponibilidade']['dt_fim'] != null):
                            echo $this->Times->totalTime($Indisponibilidade['Indisponibilidade']['dt_inicio'],
                                                   $Indisponibilidade['Indisponibilidade']['dt_fim']);
                          endif;
                    ?>
                  </td>
        				  <td><?php echo $Indisponibilidade['Motivo']['nome']; ?></td>
                  <td><?php echo $this->Tables->popupBox($Indisponibilidade['Indisponibilidade']['observacao']) ?></td>

                  <td id="<?php echo $Indisponibilidade['Indisponibilidade']['id']?>">
                    <?php
                      if($Indisponibilidade['Indisponibilidade']['dt_fim'] == null):
                        echo "<span class='label label-success'>Aberto</span>";
                        echo $this->Tables->StatusEditable($Indisponibilidade['Indisponibilidade']['id'], "indisponibilidades");
                      else:
                        echo "<span class='label label-default'>Fechado</span>";
                      endif;
                    ?>
                  </td>
                  <td><?php echo $this->Tables->getMenu('Indisponibilidades', $Indisponibilidade['Indisponibilidade']['id'], 14); ?></td>
                </tr>
              <?php endforeach; ?>
              <?php unset($Indisponibilidade); ?>
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

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');

  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
?>

<script>
  $(document).ready(function() {
    var  oTable =  $('#dataTables-Indisponibilidades').dataTable({
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
          language: {
            url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
          },
        //  responsive: true,
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
                    "mColumns": [ 0,1,2,3,4,5,6,7 ]
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,5,6,7 ]
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "sFileName": "Indisponibilidades.csv",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,5,6,7 ]
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "sFileName": "Indisponibilidades.pdf",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,5,6,7 ],
                    "sPdfOrientation": "landscape",
                    "sTitle": "Controle de Disponibilidade",
                    "sPdfMessage": "<?php echo date('d/m/y')?>",
                },
              ]
          }
      });
      var colvis = new $.fn.dataTable.ColVis( oTable );

      $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'top'});

      $("[id*='filterDt']").datetimepicker({
        format: "yyyy-mm-dd",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
      });
  });
</script>

<?php $this->Html->addCrumb('Contratos', '/contratos'); ?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Contratos
        <div class="col-lg-2 pull-right">
          <?php echo $this->Html->link("<i class='fa fa-plus'></i> Novo",
             array('controller' => 'contratos', 'action' => 'add'),
             array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false)); ?>
        </div>
      </h3>
    </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"><b> Lista de Contratos </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Número</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Cliente</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($contratos as $contrato): ?>
                <tr>
                  <td><?php echo $this->Html->link($contrato['Contrato']['numero'],
                       array('controller' => 'contratos', 'action' => 'view', $contrato['Contrato']['id'])); ?></td>
                  <td><?php echo $this->Time->format('d/m/Y', $contrato['Contrato']['data_ini']); ?></td>
                  <td><?php echo $this->Times->pastDate($contrato['Contrato']['data_fim']) ?></td>
                  <td><?php echo $contrato['Cliente']['sigla'] ?></td>
                  <td><?php echo $this->Times->active($contrato['Contrato']['status'])?></td>
                   <td>
                     <?php
                        echo $this->Html->link("<i class='fa fa-pencil'></i>",
                          array('controller' => 'contratos', 'action' => 'edit', $contrato['Contrato']['id']),
                          array('escape' => false));

                        echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                          array('action' => 'delete', $contrato['Contrato']['id']),
                          array('escape' => false), "O registro será excluído, você tem certeza dessa ação?");
                     ?>
                   </td>
                </tr>
              <?php endforeach; ?>
              <?php unset($contrato); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
//-- DataTables JavaScript -->
  echo $this->Html->script('plugins/dataTables/media/js/jquery.dataTables.js');
  echo $this->Html->script('plugins/dataTables/dataTables.bootstrap.js');
  echo $this->Html->css('plugins/dataTables.bootstrap.css');
  //-- DataTables --> TableTools
  echo $this->Html->script('plugins/dataTables/extensions/TableTools/js/dataTables.tableTools.min.js');
  echo $this->Html->css('plugins/dataTablesExtensions/TableTools/css/dataTables.tableTools.min.css');
  //-- DataTables --> Responsive
  echo $this->Html->script('plugins/dataTables/extensions/Responsive/js/dataTables.responsive.min.js');
  echo $this->Html->css('plugins/dataTablesExtensions/Responsive/css/dataTables.responsive.css');

?>

<script>
  $(document).ready(function() {
      $('#dataTables-contrato').dataTable({
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
          language: {
            url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
          },
          responsive: true,
          "dom": 'T<"clear">lfrtip',
          "tableTools": {
              "sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
              "aButtons": [
                {
                    "sExtends": "copy",
                    "sButtonText": "Copiar"
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir"
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV"
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF"
                },
              ]
          }
      });
  });
</script>

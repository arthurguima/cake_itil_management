<?php $this->Html->addCrumb('Dependencias', '/dependencias'); ?>

<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Dependências
        <div class="col-lg-2 pull-right">
          <?php echo $this->Html->link("<i class='fa fa-plus'></i> Nova",
             array('controller' => 'dependencias', 'action' => 'add'),
             array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false)); ?>
        </div>
      </h3>
    </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"><b> Lista de Dependências </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-dependencia">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dependencias as $dependencia): ?>
                <tr>
                  <td><?php echo $dependencia['Dependencia']['nome']; ?></td>
                  <td><?php echo $this->Tables->getMenu('dependencias', $dependencia['Dependencia']['id'], 12); ?></td>
                </tr>
              <?php endforeach; ?>
              <?php unset($dependencia); ?>
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


?>

<script>
  $(document).ready(function() {
      $('#dataTables-dependencia').dataTable({
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
          language: {
            url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
          },
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
                    "sButtonText": "PDF",
                },
              ]
          }
      });
  });
</script>

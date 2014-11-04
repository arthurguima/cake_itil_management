<?php
  $this->Html->addCrumb('Tipos de Demandas', '/demandatipos');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Tipos de Demandas
        <div class="col-lg-2 pull-right">
          <?php echo $this->Html->link("<i class='fa fa-plus'></i> Nova",
             array('controller' => 'demandatipos', 'action' => 'add'),
             array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false)); ?>
        </div>
      </h3>
    </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"><b> Lista de Tipos de Demandas </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-demanda">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($demandaTipos as $tipo): ?>
                <tr>
                   <td><?php echo $tipo['DemandaTipo']['nome']; ?></td>
                   <td><?php echo $this->Tables->getMenu('demandatipos', $tipo['DemandaTipo']['id'], 12); ?></td>
                </tr>
              <?php endforeach; ?>
              <?php unset($tipo); ?>
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

?>

<script>
  $(document).ready(function() {
    $('#dataTables-demanda').dataTable({
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
                    "sButtonText": "Copiar",
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
                    "mColumns": [ 0, 1, 4 ]
                },
              ]
          }
      });
  });
</script>

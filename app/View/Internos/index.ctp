<?php
  $this->Html->addCrumb('Sistemas Internos', '/internos');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
         Sistemas Internos
         <div class="col-lg-2 pull-right">
           <?php echo $this->Html->link("<i class='fa fa-plus'></i> Novo",
              array('controller' => 'internos', 'action' => 'add'),
              array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false)); ?>
         </div>
      </h3>
    </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"><b> Lista de Sistemas Internos </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-demanda">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Instruções</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($internos as $interno): ?>
                <tr>
                  <td><?php echo $this->Html->link($interno['Interno']['nome'], $interno['Interno']['url'], array('target' => '_blacnk')); ?></td>
                  <td><?php echo $this->Tables->popupBox($interno['Interno']['descricao']); ?></td>
                  <td><?php echo $this->Tables->popupBox($interno['Interno']['instrucoes']); ?></td>
                  <td><?php echo $this->Tables->getMenu('internos', $interno['Interno']['id'], 14); ?></td>
                </tr>
              <?php endforeach; ?>
              <?php unset($interno); ?>
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

      $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'top'});
  });
</script>

<?php
  $this->Html->addCrumb('Clientes', '/clientes');
?>

<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">
    Clientes
  </h3></div>
</div>


<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <b> Lista de Clientes </b>
        <div class="col-lg-2 pull-right">
          <?php
            if($this->Ldap->autorizado(2)){
              echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
               array('controller' => 'clientes', 'action' => 'add'),
               array('escape' => false));
            }
          ?>
        </div>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-clientes">
            <thead>
              <tr>
                <th>Sigla</th>
                <th>Nome</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($clientes as $clie): ?>
                <tr>
                  <td><?php echo $clie['Cliente']['sigla']; ?></td>
                  <td><?php echo $clie['Cliente']['nome']; ?></td>
                  <td><?php echo $this->Tables->getMenu('clientes', $clie['Cliente']['id'], 12); ?></td>
                </tr>
              <?php endforeach; ?>
              <?php unset($clie); ?>
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
      $('#dataTables-clientes').dataTable({
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
  });
</script>

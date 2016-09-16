<?php
  $this->Html->addCrumb('Status', '/status');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Status
      </h3>
    </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <b> Lista de Status </b>
        <div class="col-lg-2 pull-right">
          <?php
            if($this->Ldap->autorizado(2)){
               echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
               array('controller' => 'status', 'action' => 'add'),
               array('escape' => false));
            }
          ?>
        </div>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-demanda">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Finaliza o Processo</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($status as $stat): ?>
                <tr>
                   <td><?php echo $stat['Status']['nome']; ?></td>
                   <td><?php echo $this->Status->tipo($stat['Status']['tipo']); ?></td>
                   <td><?php echo $this->Times->yesOrNo($stat['Status']['fim']); ?></td>
                   <td><?php echo $this->Tables->getMenu('status',  $stat['Status']['id'], 12); ?></td>
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

<!-- DataTables JavaScript -->
<?php
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
          "order": [[ 1, "asc" ]],
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
                }
              ]
          }
      });
  });
</script>

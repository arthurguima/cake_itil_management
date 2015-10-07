<?php
  $this->Html->addCrumb('Serviços', '');
  $this->Html->addCrumb('Release', '/releases');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Releases
        <div class="col-lg-2 pull-right">
          <?php
            if($this->Ldap->autorizado(2)){
              echo $this->Html->link("<i class='fa fa-plus'></i> Novo",
               array('controller' => 'Releases', 'action' => 'add'),
               array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false));
            }
          ?>
        </div>
      </h3>
    </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"><b> Lista </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-releases">
            <thead>
              <tr>
                <th>Servico</th>
                <th>Versão</th>
                <th>RDM</th>
                <th>Data</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($releases as $release): ?>
                <tr>
                  <td><?php echo $release['Servico']['sigla']; ?></td>
                  <td/><?php echo $release['Release']['versao']; ?></td>
                  <td/><?php echo $release['Rdm']['numero']; ?></td>
                  <td/><?php echo $release['Rdm']['dt_executada']; ?></td>
                 <td><?php echo $this->Tables->getMenu('Releases', $release['Release']['id'], 14); ?></td>
                </tr>
              <?php endforeach; ?>
              <?php unset($release); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
  //-- DataTables JavaScript
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
      $('#dataTables-releases').dataTable({
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

<?php
  $this->Html->addCrumb('Mapeamento DTP', '/responsabilidades');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
         Mapeamento DTP
         <div class="col-lg-2 pull-right">
           <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus'></i> Novo",
                array('controller' => 'responsabilidades', 'action' => 'add'),
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
      <div class="panel-heading"><b> Lista de Processos <i>vs</i> Responsabilidades </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-demanda">
            <thead>
              <tr>
                <th>Processo</th>
                <th>Responsável</th>
                <th>Área</th>
                <th>Ramal</th>
                <th>email</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($responsabilidades as $responsabilidade): ?>
                <tr>
                  <td><?php echo $responsabilidade['Responsabilidade']['processo'] ?></td>
                  <td><?php echo $responsabilidade['Responsabilidade']['responsavel']; ?></td>
                  <td><?php echo $responsabilidade['Responsabilidade']['area']; ?></td>
                  <td><?php echo $responsabilidade['Responsabilidade']['ramal']; ?></td>
                  <td><?php echo $responsabilidade['Responsabilidade']['email']; ?></td>
                  <td><?php echo $this->Tables->getMenu('responsabilidades', $responsabilidade['Responsabilidade']['id'], 12); ?></td>
                </tr>
              <?php endforeach; ?>
              <?php unset($responsabilidade); ?>
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

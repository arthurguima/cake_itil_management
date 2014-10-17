<?php
  $this->Html->addCrumb('Procedimentos', '/procedimentos');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
         Procedimentos Documentados
         <div class="col-lg-2 pull-right">
           <?php echo $this->Html->link("<i class='fa fa-plus'></i> Novo",
              array('controller' => 'procedimentos', 'action' => 'add'),
              array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false)); ?>
         </div>
      </h3>
    </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"><b> Lista de Procedimentos Documentados </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-demanda">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Data de Alteração</th>
                <th>Responsável</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($procedimentos as $procedimento): ?>
                <tr>
                  <td><?php echo $this->Html->link($procedimento['Procedimento']['nome'],$procedimento['Procedimento']['url'], array('target' => '_blank')); ?></td>
                  <td><?php echo $procedimento['Procedimento']['dt_alteracao']; ?></td>
                  <td><?php echo $procedimento['Procedimento']['responsavel']; ?></td>
                  <td>
                    <?php
                       echo $this->Html->link("<i class='fa fa-pencil'></i>",
                             array('controller' => 'procedimentos', 'action' => 'edit', $procedimento['Procedimento']['id']),
                             array('escape' => false));

                       echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                             array('action' => 'delete', $procedimento['Procedimento']['id']),
                             array('escape' => false), "O registro será excluído, você tem certeza dessa ação?");
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
              <?php unset($procedimento); ?>
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
  })
  
 });
</script>

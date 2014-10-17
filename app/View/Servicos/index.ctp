<?php
  $this->Html->addCrumb('Serviços', '/servicos');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Serviços
        <div class="col-lg-2 pull-right">
          <?php echo $this->Html->link("<i class='fa fa-plus'></i> Novo",
             array('controller' => 'Servicos', 'action' => 'add'),
             array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false)); ?>
        </div>
      </h3>
    </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"><b> Lista de Serviços </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-Servico">
            <thead>
              <tr>
                <th>Sigla</th>
                <th>Nome</th>
                <th>Tecnologia</th>
                <th>Áreas</th>
                <th>Status</th>
                <th>Online?</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($servicos as $servico): ?>
                <tr>
                  <td><?php echo $this->Html->link($servico['Servico']['sigla'],
                       array('controller' => 'Servicos', 'action' => 'view', $servico['Servico']['id'])); ?></td>
                  <td/><?php echo $servico['Servico']['nome']; ?></td>
                  <td/><?php echo $servico['Servico']['tecnologia']; ?></td>
                  <td class="area-list">
                    <?php
                        foreach($servico['Area'] as $area):
                          echo $this->Html->link($area['sigla'] . "  ",
                          array('controller' => 'areas', 'action' => 'view', $area['id']));
                        endforeach;
                    ?>
                  </td>
                  <td><?php echo $this->Times->active($servico['Servico']['status'])?></td>
                  <td><?php echo $this->Disponibilidade->online2($servico['Servico']['url'], 'GET'); ?></td>
                 <td>
                   <?php
                      echo $this->Html->link("<i class='fa fa-pencil'></i>",
                            array('controller' => 'Servicos', 'action' => 'edit', $servico['Servico']['id']),
                            array('escape' => false));
                      echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                            array('action' => 'delete', $servico['Servico']['id']),
                            array('escape' => false), "O registro será excluído, você tem certeza dessa ação?");
                   ?>
                 </td>
                </tr>
              <?php endforeach; ?>
              <?php unset($servico); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php //debug($servicos); ?>


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
      $('#dataTables-Servico').dataTable({
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

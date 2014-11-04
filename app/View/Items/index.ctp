<?php
  $this->Html->addCrumb('Contratos', '/contratos');
  $this->Html->addCrumb($this->data['Contrato']['numero'], array('controller' => 'contratos', 'action' => 'view', $this->data['Contrato']['id']));
  $this->Html->addCrumb('Itens de contrato', '');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Itens de Contrato
        <div class="col-lg-2 pull-right">
          <?php echo $this->Html->link("<i class='fa fa-plus'></i> Novo",
             array('controller' => 'Items', 'action' => 'add'),
             array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false)); ?>
        </div>
      </h3>
    </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"> Lista de Itens de Contrato </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-Servico">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Metrica</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $item): ?>
                <tr>
                  <td><?php echo $this->Html->link($item['Item']['id'],
                       array('controller' => 'Servicos', 'action' => 'view', $item['Item']['id'])); ?></td>
                  <td/><?php echo $item['Item']['nome']; ?></td>
                  <td><?php echo $item['Item']['metrica']; ?></td>
                  <td>
                     <?php
                        echo $this->Html->link("<i class='fa fa-pencil'></i>",
                              array('controller' => 'Item', 'action' => 'edit', $item['Item']['id']),
                              array('escape' => false));
                        echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                              array('action' => 'delete', $item['Item']['id']),
                              array('escape' => false), "Você tem certeza");
                     ?>
                   </td>
                </tr>
              <?php endforeach; ?>
              <?php unset($item); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php //debug($items); ?>


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
      $('#dataTables-Servico').dataTable({
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

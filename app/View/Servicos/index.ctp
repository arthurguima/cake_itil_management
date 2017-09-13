<?php
  $this->Html->addCrumb('Serviços', '/servicos');
?>
<div class="col-lg-12 page-header-box">
    <div class="col-lg-12">
      <h3 class="page-header">
        Serviços
      </h3>
      <div class="col-lg-12 pull-left filters">
        <div class="">
          <div class="row"><span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">Filtros <i class="fa fa-plus-square"></i></span></div>
          <div class="row inner" style="display: none;">
            <?php echo $this->Search->create("", array('class' => 'form-inline')); ?>
            <div class="col-lg-12 filters-item">
              <div class="form-group"><?php echo $this->Search->input('Cliente', array('class' => 'form-control select2')); ?></div>
            </div>
            <?php
        		  echo $this->Form->button("Filtrar <i class='fa fa-search'></i>", array('type' => 'submit',
                              'onclick' => 'javascript:if(oTable != null)oTable.fnDestroy();', 'class' => 'control-label btn btn-default pull-right'));
        			echo $this->Search->end();
            ?>
          </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <b> Lista de Serviços </b>
        <div class="col-lg-2 pull-right">
          <?php
            if($this->Ldap->autorizado(2)){
              echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
               array('controller' => 'Servicos', 'action' => 'add'),
               array('escape' => false));
            }
          ?>
        </div>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-Servicos">
            <thead>
              <tr>
                <th>Sigla</th>
                <th>Nome</th>
                <th>Tecnologia</th>
                <th>Áreas</th>
                <th>Cliente</th>
                <th>Status</th>
                <!--th>Online?</th-->
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
                  <td/><?php echo $servico['Cliente']['nome']; ?></td>
                  <td><?php echo $this->Times->active($servico['Servico']['status'])?></td>
                  <!--td><?php //echo $this->Disponibilidade->online2($servico['Servico']['url'], 'GET'); ?></td-->
                 <td><?php echo $this->Tables->getMenu('Servicos', $servico['Servico']['id'], 12); ?></td>
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
      $('#dataTables-Servicos').dataTable({
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
                    "sButtonText": "Copiar",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4 ]
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4 ]
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "sFileName": "Servicos.csv",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4 ]
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "sFileName": "Servicos.pdf",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4 ],
                    "sPdfOrientation": "landscape",
                    "sTitle": "Serviços Cadastrados",
                    "sPdfMessage": "<?php echo date('d/m/y')?>",
                },
              ]
          }
      });
  });
</script>

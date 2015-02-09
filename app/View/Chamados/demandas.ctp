<?php
  $this->Html->addCrumb('Chamados X Demandas', '/chamados');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
         Chamados X Demandas
      </h3>
    </div>
    <div class="col-lg-12 pull-left filters">
      <div class="">
        <div class="row">
          <span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">Filtros <i class="fa fa-plus-square"></i></span>
        </div>
        <div class="row inner" style="display: none;">
          <?php echo $this->Search->create("", array('class' => 'form-inline')); ?>
          <div class="col-lg-12 filters-item">
            <div class="form-group"><?php echo $this->Search->input('servico', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('nome_', array('class' => 'form-control', 'placeholder' => "Nome")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('numero_', array('class' => 'form-control', 'placeholder' => "Número")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('pai_', array('class' => 'form-control', 'placeholder' => "Pai?")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('aberto_', array('class' => 'form-control', 'placeholder' => "Aberto?")); ?></div>
          </div>
          <div class="col-lg-12 filters-item">
            <div class="form-group"><?php echo $this->Search->input('status', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('status_diferente', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('tipo', array('class' => 'form-control')); ?></div>
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

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-heading"><b> Lista de Chamados </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-chamado">
            <thead>
              <tr>
                <th>Número</th>
                <th>Nome</th>
                <th>Demanda <i class="fa fa-comment-o" style="font-size: 15px !important;"></i></th>
                <th>Demanda</th>
                <th>Status da Demanda</th>
                <th>Aberto?</th>
                <th>Pai?</th>
                <th><span class="editable">Status do Chamado</span></th>
                <th>Tipo</th>
                <th class="hidden-xs hidden-sm">Responsável</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($chamados as $chamado): ?>
                <tr>
                  <td><?php echo $chamado['Chamado']['numero'] . "/". $chamado['Chamado']['ano']; ?></td>
                  <td><?php echo $chamado['Chamado']['nome']; ?></td>
                  <td><?php echo $this->Tables->popupBox($chamado['Demanda']['nome'], $chamado['Demanda']['descricao']) ?></td>
                  <td><?php echo $chamado['Demanda']['nome']; ?></td>
                  <td><?php echo $chamado['Demanda']['Status']['nome']; ?></td>
                  <td><?php echo $this->Times->yesOrNo($chamado['Chamado']['aberto'])?></td>
                  <td><?php echo $this->Times->yesOrNo($chamado['Chamado']['pai'])?></td>
                  <td>
                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $chamado['Chamado']['id'] ?>"><?php echo $chamado['Status']['nome']; ?></span>
                  </td>
                  <?php echo $this->Tables->ChamadoStatusEditable($chamado['Chamado']['id']) ?>
                  <td><?php echo $chamado['ChamadoTipo']['nome']; ?></td>
                  <td class="hidden-xs hidden-sm"><div class="sub-17"><?php echo $chamado['Chamado']['responsavel']; ?></div></td>
                  <td>
                    <?php
                      echo $this->Tables->getMenu('chamados', $chamado['Chamado']['id'], 2);
                      if($this->Ldap->autorizado(2)){
                        echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                  array('controller' => 'chamados', 'action' => 'edit', $chamado['Chamado']['id'], '?' => array('controller' => 'chamados', 'action' => 'demandas' )),
                                  array('escape' => false));
                      }
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
              <?php unset($chamado); ?>
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

  //-- Jeditable
    echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');
?>

<script>
  $(document).ready(function() {
      oTable = $('#dataTables-chamado').dataTable({
          "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
          language: {
            url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
          },
          "dom": 'T<"clear">lfrtip',
          "columnDefs": [  { "visible": false, "targets": 3 } ],
          "tableTools": {
              "sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
              "aButtons": [
                {
                    "sExtends": "copy",
                    "sButtonText": "Copiar",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,3,4,5,6,7,8,9 ]
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,3,4,5,6,7,8,9 ]
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "sFileName": "Chamados.csv",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,3,4,5,6,7,8,9 ]
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "sFileName": "Chamados.pdf",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "sPdfOrientation": "landscape",
                    "mColumns": [ 0,1,4,5,6,7,8,9 ],
                    "sTitle": "Listagem de Chamados",
                    "sPdfMessage": "<?php echo date('d/m/y')?>"
                },
              ]
          }
      });

        $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'right', html: 'true'});
  });
</script>

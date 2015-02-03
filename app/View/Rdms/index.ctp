<?php
  $this->Html->addCrumb('Rdms', '/rdms');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
         RDM - Requisições de Mudança
         <div class="col-lg-2 pull-right">
           <?php echo $this->Html->link("<i class='fa fa-plus'></i> Nova",
              array('controller' => 'rdms', 'action' => 'add'),
              array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false)); ?>
         </div>
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
            <div class="form-group">
              <b>Data Prevista: </b>
              <?php echo $this->Search->input('dtprevista',
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
              ?>
            </div>
            <div class="form-group">
              <b>Data de Execução: </b>
              <?php echo $this->Search->input('dtexecutada',
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
              ?>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="form-group"><?php echo $this->Search->input('nome_', array('class' => 'form-control', 'placeholder' => "Nome")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('versao_', array('class' => 'form-control', 'placeholder' => "Versão")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('numero_', array('class' => 'form-control', 'placeholder' => "Número")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('servico', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('ambiente_', array('class' => 'form-control')); ?></div>
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
      <div class="panel-heading"><b> Lista de RDMs </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-rdm">
            <thead>
              <tr>
                <th>Servico</th>
                <th>Versão</th>
                <th>Ambiente</th>
                <th>Tipo</th>
                <th>Sucesso?</th>
                <th>Nome</th>
                <th>Número</th>
                <th>Data Prevista</th>
                <th>Data de Execução</th>
                <th>Responsável</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rdms as $rdm): ?>
                <tr>
                  <td><?php echo $this->Html->link($rdm['Servico']['sigla'], array('controller' => 'servicos', 'action' => 'view', $rdm['Servico']['id'])); ?></td>
                  <td><?php echo $rdm['Rdm']['versao']; ?></td>
                  <td><?php echo $this->Rdm->getAmbiente($rdm['Rdm']['ambiente']); ?></td>
                  <td><?php echo $rdm['RdmTipo']['nome']; ?></td>
                  <td><?php echo $this->Rdm->sucesso($rdm['Rdm']['sucesso'], $rdm['Rdm']['dt_executada']); ?></a></td>
                  <td><?php echo $this->Html->link($rdm['Rdm']['nome'], array('controller' => 'rdms', 'action' => 'view', $rdm['Rdm']['id'])); ?></td>
                  <td><?php echo $rdm['Rdm']['numero']; ?></td>
                  <td><?php echo $this->Times->pastDate($rdm['Rdm']['dt_prevista']); ?></td>
                  <td><?php echo (($rdm['Rdm']['dt_executada'] == null) ? "" : $this->Time->format('d/m/Y', $rdm['Rdm']['dt_executada'])); ?></td>
                  <td><?php echo $rdm['Rdm']['responsavel']; ?></td>
                  <td><?php echo $this->Tables->getMenu('rdms', $rdm['Rdm']['id'], 14); ?></td>
                </tr>
              <?php endforeach; ?>
              <?php unset($rdm); ?>

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

//-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
?>

<script>
  $(document).ready(function() {
      $('#dataTables-rdm').dataTable({
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
                    "sButtonText": "Copiar",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,5,6,7 ]
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,5,6,7 ]
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "sFileName": "RDM.csv",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,5,6,7 ]
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "sFileName": "RDM.pdf",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,5,6,7 ],
                    "sPdfOrientation": "landscape",
                    "sTitle": "Requisições de Mudança",
                    "sPdfMessage": "<?php echo date('d/m/y')?>",
                },
              ]
          }
      });

      $("[id*='filterDt']").datetimepicker({
        format: "yyyy-mm-dd",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
      });
  });
</script>

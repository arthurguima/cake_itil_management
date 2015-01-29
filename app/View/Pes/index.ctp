<?php
  $this->Html->addCrumb('PA', '/pes');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
         PA - Propostas de Atendimento
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
              <b>Data de Início: </b>
              <?php echo $this->Search->input('dtinicio',
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
              ?>

            </div>
            <div class="form-group">
              <b>Data de Emissão: </b>
              <?php echo $this->Search->input('dtemissao',
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
              ?>
            </div>
          </div>
          <div class="col-lg-12 filters-item">
            <div class="form-group"><?php echo $this->Search->input('responsavel_', array('class' => 'form-control', 'placeholder' => "Responsável")); ?></div>
            <!--div class="form-group"><?php //echo $this->Search->input('nome_', array('class' => 'form-control', 'placeholder' => "Nome")); ?></div -->
            <div class="form-group"><?php echo $this->Search->input('numero_', array('class' => 'form-control', 'placeholder' => "Número")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('num_ce_', array('class' => 'form-control', 'placeholder' => "Número da CE de envio:")); ?></div>
          </div>
          <div class="col-lg-12">
            <div class="form-group"><?php echo $this->Search->input('status', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('status_diferente', array('class' => 'form-control')); ?></div>
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
      <div class="panel-heading"><b> Lista de PA </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-ss">
            <thead>
              <tr>
                <th>Número</th>
                <th>Número da CE</th>
                <th>SS</th>
                <!--th>Nome</th-->
                <th><span class="editable">Status</span></th>
                <th class="hidden-xs hidden-sm">Responsável</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pes as $pe): ?>
                <tr>
                  <td><?php echo $this->Html->link(($pe['Pe']['numero'] . "/" . $pe['Pe']['ano']), $pe['Pe']['cvs_url']); ?></td>
                  <td><?php echo $pe['Pe']['num_ce']; ?></td>
                  <td><?php echo $this->Html->link($pe['Ss']['nome'], array('controller' => 'sses', 'action' => 'view', $pe['Ss']['id'])); ?></td>
                  <!--td><?php echo $this->Html->link($pe['Pe']['nome'], $pe['Pe']['cvs_url']); ?></td-->
                  <td>
                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $pe['Pe']['id'] ?>">
                    <?php echo $pe['Status']['nome']; ?></span>
                  </td>
                  <?php echo $this->Tables->PeStatusEditable($pe['Pe']['id']) ?>
                  <td class="hidden-xs hidden-sm"><div class="sub-17"><?php echo $pe['Pe']['responsavel']; ?></div></td>
                  <td><?php echo $this->Tables->getMenu('pes', $pe['Pe']['id'], 14); ?></td>
                </tr>
              <?php endforeach; ?>
              <?php unset($pe); ?>

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

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');
?>

<script>
  $(document).ready(function() {
    $('#dataTables-ss').dataTable({
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
                  "mColumns": [ 0,1,2,3,4,5 ]
              },
              {
                  "sExtends": "print",
                  "sButtonText": "Imprimir"
              },
              {
                  "sExtends": "csv",
                  "sButtonText": "CSV",
                  "sFileName": "Propostas de Atendimento.csv",
                  "oSelectorOpts": { filter: 'applied', order: 'current' },
                  "mColumns": [ 0,1,2,3,4,5 ]
              },
              {
                  "sExtends": "pdf",
                  "sButtonText": "PDF",
                  "sFileName": "Propostas de Atendimento.pdf",
                  "oSelectorOpts": { filter: 'applied', order: 'current' },
                  "sPdfOrientation": "landscape",
                  "mColumns": [ 0,1,2,3,4,5 ],
                  "sTitle": "Listagem de Propostas de Atendimento",
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

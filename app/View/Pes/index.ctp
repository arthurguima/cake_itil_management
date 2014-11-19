<?php
  $this->Html->addCrumb('Pe', '/pes');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
         PEs - Propostas de Execução
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
              <?php echo $this->Search->input('dtprevisao',
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
              ?>
            </div>
            <div class="form-group">
              <b>Data de Execução: </b>
              <?php echo $this->Search->input('dtrecebimento',
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
              ?>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="form-group"><?php echo $this->Search->input('responsavel_', array('class' => 'form-control', 'placeholder' => "Responsável")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('status', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('status_diferente', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('nome_', array('class' => 'form-control', 'placeholder' => "Nome")); ?></div>
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
      <div class="panel-heading"><b> Lista de PEs </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-ss">
            <thead>
              <tr>
                <th>Número</th>
                <th>Número da CE</th>
                <th>Nome</th>
                <th class="hidden-xs hidden-sm">Responsável:</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($sses as $ss): ?>
                <tr>
                  <td><?php echo $ss['Pe']['numero']; ?></td>
                  <td><?php echo $ss['Pe']['num_ce']; ?></td>
                  <td><?php echo $this->Html->link($ss['Pe']['nome'], array('controller' => 'sses', 'action' => 'view', $ss['Pe']['id'])); ?></td>
                  <td class="hidden-xs hidden-sm"><div class="sub-17"><?php echo $ss['Pe']['responsavel']; ?></div></td>
                  <td><?php echo $this->Tables->getMenu('pes', $ss['Pe']['id'], 14); ?></td>
                </tr>
              <?php endforeach; ?>
              <?php unset($ss); ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
Número da PE:   xxx
Data da PE: xx/xx/xxxx
Quantidade de Ponto de Função: xxx
Número da CE de envio: xx/xxxx
Tempo estimado para execução da demanda : xxxx dias utéis
Previsão para ínicio de atendimento da demanda : xx/xx/xxxx.

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
    $('#myModal').on('shown.bs.modal', function (e) {
      document.getElementById('modal-body').appendChild(
          document.getElementById('demandaFrame')
      );
      document.getElementById('demandaFrame').style.display = "block";
      //document.getElementById('demandaFrame').style.height = "720px";
    });

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

    $("[id*='filterDt']").datetimepicker({
      format: "yyyy-mm-dd",
      minView: 2,
      autoclose: true,
      todayBtn: true,
      language: 'pt-BR'
    });
  });
</script>

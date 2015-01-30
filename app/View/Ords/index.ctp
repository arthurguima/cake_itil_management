<?php
  $this->Html->addCrumb('OS', '/ords');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
         OS - Ordens de Serviço
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
            <div class="col-lg-6">
              <div class="form-group">
                <b>Data de Recebimento: </b>
                <?php echo $this->Search->input('dtrecebimento',
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
                ?>
              </div>
              <div class="form-group">
                <b>Data de Emissão: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                <?php echo $this->Search->input('dtemissao',
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
                ?>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <b>Data de Deploy Homologação: </b>
                <?php echo $this->Search->input('dtdhomologacao',
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
                ?>

              </div>
              <div class="form-group">
                <b>Data de Deploy Produção: </b>
                <?php echo $this->Search->input('dtdproducao',
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
                ?>

              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <b>Data de Homologação: </b>
                <?php echo $this->Search->input('dthomologacao',
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
                ?>

              </div>
            </div>
          </div>
          <div class="col-lg-12 filters-item">
            <div class="form-group"><?php echo $this->Search->input('responsavel_', array('class' => 'form-control', 'placeholder' => "Responsável")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('nome_', array('class' => 'form-control', 'placeholder' => "Nome")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('numero_', array('class' => 'form-control', 'placeholder' => "Número")); ?></div>
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
      <div class="panel-heading"><b> Lista de OS </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-ss">
            <thead>
              <tr>
                <th>Número</th>
                <th>SS</th>
                <th>PA</th>
                <!--th>Nome</th-->
                <th>Prazo</th>
                <th><span class="editable">Status</span></th>
                <th class="hidden-xs hidden-sm">Responsável</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($ords as $ord): ?>
                <tr>
                  <td><?php echo $this->Html->link($ord['Ord']['numero'] . "/" . $ord['Ord']['ano'], $ord['Ord']['cvs_url']); ?></td>
                  <td><?php echo $this->Html->link($ord['Ss']['nome'], array('controller' => 'sses', 'action' => 'view', $ord['Ss']['id'])); ?></td>
                  <td><?php echo $ord['Pe']['numero'] . "/" . $ord['Pe']['ano']; ?></td>
                  <!--td><?php //echo $this->Html->link($ord['Ord']['nome'], $ord['Ord']['cvs_url']); ?></td-->

                  <td class="text-center">
                    <?php
                      if($ord['Ord']['dt_ini_pdd'] != null){
                        echo $this->Times->timeLeftTo($ord['Ord']['dt_ini_pdd'], $ord['Ord']['dt_fim_pdd'],
                              $ord['Ord']['dt_ini_pdd'] . " - " . $ord['Ord']['dt_fim_pdd'],
                              ($ord['Ord']['dt_homologacao']));
                      }
                    ?>
                  </td>

                  <td>
                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $ord['Ord']['id'] ?>">
                    <?php echo $ord['Status']['nome']; ?></span>
                  </td>
                  <?php echo $this->Tables->OrdStatusEditable($ord['Ord']['id']) ?>

                  <td class="hidden-xs hidden-sm"><div class="sub-17"><?php echo $ord['Ord']['responsavel']; ?></div></td>
                  <td><?php echo $this->Tables->getMenu('ords', $ord['Ord']['id'], 14); ?></td>
                </tr>
              <?php endforeach; ?>
              <?php unset($ord); ?>

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
                  "mColumns": [ 0,1,2,3]
              },
              {
                  "sExtends": "print",
                  "sButtonText": "Imprimir"
              },
              {
                  "sExtends": "csv",
                  "sButtonText": "CSV",
                  "sFileName": "Ordens de Serviço.csv",
                  "oSelectorOpts": { filter: 'applied', order: 'current' },
                  "mColumns": [ 0,1,2,3]
              },
              {
                  "sExtends": "pdf",
                  "sButtonText": "PDF",
                  "sFileName": "Ordens de Serviço.pdf",
                  "oSelectorOpts": { filter: 'applied', order: 'current' },
                  "sPdfOrientation": "landscape",
                  "mColumns": [ 0,1,2,3],
                  "sTitle": "Listagem de Ordens de Serviço",
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

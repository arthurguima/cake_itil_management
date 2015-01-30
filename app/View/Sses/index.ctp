<?php
  $this->Html->addCrumb('Ss', '/sses');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
         SS - Solicitações de Serviço
         <div class="col-lg-2 pull-right">
           <?php echo $this->Html->link("<i class='fa fa-plus'></i> Nova",
              array('controller' => 'sses', 'action' => 'add'),
              array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false)); ?>
         </div>
      </h3>
    </div>
    <div class="col-lg-12 filters">
      <div class="">
        <div class="row">
          <span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">Filtros <i class="fa fa-plus-square"></i></span>
        </div>
        <div class="row inner" style="display: none;">
          <?php echo $this->Search->create("", array('class' => 'form-inline')); ?>
          <div class="col-lg-12 filters-item">
            <div class="col-lg-6">
              <div class="form-group">
                <b>Prazo de entrega: </b>
                <?php echo $this->Search->input('dtprazo',
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
                ?>
              </div>
              <div class="form-group">
                <b>Data de Recebimento: </b>
                <?php echo $this->Search->input('dtrecebimento',
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
                ?>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <b>Data Prevista: </b>
                <?php echo $this->Search->input('dtprevisao',
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                            array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
                ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 filters-item">
            <div class="form-group"><?php echo $this->Search->input('responsavel_', array('class' => 'form-control', 'placeholder' => "Responsável")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('clarity_dm', array('class' => 'form-control', 'placeholder' => "Clarity DM")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('servico', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('nome_', array('class' => 'form-control', 'placeholder' => "Nome")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('prioridade_', array('class' => 'form-control', 'placeholder' => "Prioridade Maior que")); ?></div>
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
      <div class="panel-heading"><b> Lista de SS </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-ss">
            <thead>
              <tr>
                <th>Servico</th>
                <th class="hidden-xs hidden-sm"><span class="editable">Prioridade</span></th>
                <th class="hidden-xs hidden-sm">Clarity DM</th>
                <th>Número</th>
                <th>Nome <i class="fa fa-comment-o" style="font-size: 15px !important;"></th>
                <th>Nome</th>
                <th>Prazo</th>
                <th class="hidden-xs hidden-sm"><span class="editable">Status</span></th>
                <th class="hidden-xs hidden-sm">Responsável:</th>
                <th class="hidden-xs hidden-sm">CheckList</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($sses as $ss): ?>
                <tr>
                  <td><?php echo $this->Html->link($ss['Servico']['sigla'], array('controller' => 'servicos', 'action' => 'view', $ss['Servico']['id'])); ?></td>
                  <td class="hidden-xs hidden-sm">
                    <span style="cursor:pointer;" title="Clique para alterar a prioridade!" id="<?php echo $ss['Ss']['id'];?>"><?php echo $ss['Ss']['prioridade']; ?></span>
                  </td>
                  <?php echo $this->Tables->PrioridadeEditable($ss['Ss']['id'], "sses") ?>

                  <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!">
                      <?php echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                                 $ss['Ss']['clarity_id'] .")'>" . $ss['Ss']['clarity_dm_id'] ."</a></span>" ?>
                  </td>

                  <td><?php echo $ss['Ss']['numero'] . "/" . $ss['Ss']['ano'] ; ?></td>
                  <td><?php echo $this->Tables->popupBox($ss['Ss']['nome'], $ss['Ss']['observacao']) ?></td>
                  <td><?php echo $ss['Ss']['nome']; ?></td>

                  <td class="text-center">
                    <?php echo $this->Times->timeLeftTo($ss['Ss']['dt_recebimento'], $ss['Ss']['dt_prazo'],
                             $ss['Ss']['dt_recebimento'] . " - " . $ss['Ss']['dt_prazo'],
                            ($ss['Ss']['dt_finalizada']));
                    ?>
                  </td>

                  <td class="hidden-xs hidden-sm">
                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $ss['Ss']['id'] ?>">
                    <?php echo $ss['Status']['nome']; ?></span>
                  </td>
                  <?php echo $this->Tables->SsStatusEditable($ss['Ss']['id']) ?>

                  <td class="hidden-xs hidden-sm"><div class="sub-17"><?php echo $ss['Ss']['responsavel']; ?></div></td>
                  <td class="checklist hidden-xs hidden-sm"><?php echo $this->Ss->getCheckList($ss['Ss']['dv'], $ss['Ss']['contagem']) ?></td>
                  <td><?php echo $this->Tables->getMenu('sses', $ss['Ss']['id'], 14); ?></td>
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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body" id="modal-body">
      </div>
    </div>
  </div>
</div>
<iframe id="demandaFrame" style="display:none;" name='demanda' width='100%' height='720px' frameborder='0'></iframe>

<?php
  //-- ClarityID
    echo $this->Html->script('getIdClarity.js');

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

    $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'right', html: 'true'});

    $('#dataTables-ss').dataTable({
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
        language: {
          url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
        },
        "columnDefs": [  { "visible": false, "targets": 5 } ],
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
            "aButtons": [
              {
                  "sExtends": "copy",
                  "sButtonText": "Copiar",
                  "oSelectorOpts": { filter: 'applied', order: 'current' },
                  "mColumns": [ 0,1,2,3,5,6,7,8,9 ]
              },
              {
                  "sExtends": "print",
                  "sButtonText": "Imprimir",
                  "oSelectorOpts": { filter: 'applied', order: 'current' },
                  "mColumns": [ 0,1,2,3,5,6,7,8,9 ]
              },
              {
                  "sExtends": "csv",
                  "sButtonText": "CSV",
                  "sFileName": "SS.csv",
                  "oSelectorOpts": { filter: 'applied', order: 'current' },
                  "mColumns": [ 0,1,2,3,5,6,7,8,9 ]
              },
              {
                  "sExtends": "pdf",
                  "sButtonText": "PDF",
                  "sFileName": "SS.pdf",
                  "oSelectorOpts": { filter: 'applied', order: 'current' },
                  "sPdfOrientation": "landscape",
                  "mColumns": [ 0,1,2,3,6,7,8,9 ],
                  "sTitle": "Listagem de Solicitações de Serviço",
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

<?php
  $this->Html->addCrumb('Demandas', '/demandas');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Demandas Internas
        <div class="col-lg-2 pull-right">
          <?php echo $this->Html->link("<i class='fa fa-plus'></i> Nova",
             array('controller' => 'demandas', 'action' => 'add'),
             array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false)); ?>
        </div>
      </h3>
    </div>
    <div class="col-lg-12 pull-left filters">
      <div class="">
        <div class="row"><span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">Filtros <i class="fa fa-plus-square"></i></span></div>
        <div class="row inner" style="display: none;">
          <?php echo $this->Search->create("", array('class' => 'form-inline')); ?>
          <div class="col-lg-12 filters-item">
            <div class="form-group">
              <b>Data de Cadastro: </b>
              <?php echo $this->Search->input('dtcadastro',
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
              ?>
            </div>
            <div class="form-group">
              <b>Previsão de Término: </b>
              <?php echo $this->Search->input('dtprevisao',
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
              ?>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="form-group"><?php echo $this->Search->input('responsavel', array('class' => 'form-control', 'placeholder' => "Solicitante")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('clarity_dm', array('class' => 'form-control', 'placeholder' => "Clarity DM")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('tipo', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('servico', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('status', array('class' => 'form-control')); ?></div>
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
      <div class="panel-heading"><b> Lista de Demandas Internas </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-demanda">
            <thead>
              <tr>
                <th>Serviço</th>
                <th class="hidden-xs hidden-sm"><span class="editable">Prioridade</span></th>
                <th class="hidden-xs hidden-sm">Clarity DM</th>
                <th class="hidden-xs hidden-sm">Mantis</th>
                <th>Descrição</th>
				        <th>Tipo da Demanda</th>
                <th>Prazo</th>
                <th><span class="editable">Status</span></th>
                <th class="hidden-xs hidden-sm">Solicitante</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($demandas as $demanda): ?>
                <tr>
                  <td><?php echo $this->Html->link($demanda['Servico']['sigla'], array('controller' => 'servicos', 'action' => 'view', $demanda['Servico']['id'])); ?></td>
                  <td>
                    <span class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para alterar a prioridade!" id="<?php echo $demanda['Demanda']['id']?>"><?php echo $demanda['Demanda']['prioridade']; ?></span>
                  </td>
                  <?php echo $this->Tables->PrioridadeEditable($demanda['Demanda']['id'], "demandas") ?>
                  <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!"><?php echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                                  $demanda['Demanda']['clarity_id'] .")'>" . $demanda['Demanda']['clarity_dm_id'] ."</a></span>" ?>
                  </td>
                  <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Mantis!">
                    <?php echo $this->Html->link($demanda['Demanda']['mantis_id'],"http://www-testes/view.php?id=" . $demanda['Demanda']['mantis_id'], array('target' => '_blank')); ?>
                  </td>
                  <td><?php echo $this->Tables->popupBox($demanda['Demanda']['descricao']) ?></td>
				          <td><?php echo $demanda['DemandaTipo']['nome']; ?></td>
                  <td class="text-center">
                    <?php echo $this->Times->timeLeftTo($demanda['Demanda']['data_cadastro'], $demanda['Demanda']['dt_prevista'],
                            $this->Time->format('d/m/Y', $demanda['Demanda']['data_cadastro']) . " - " . $this->Time->format('d/m/Y', $demanda['Demanda']['dt_prevista']),
                            ($demanda['Demanda']['data_homologacao'] == null));
                    ?>
                  </td>
                  <td>
                    <span class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $demanda['Demanda']['id'] ?>"><?php echo $demanda['Status']['nome']; ?></span>
                  </td>
                  <?php echo $this->Tables->DemandaStatusEditable($demanda['Demanda']['id'], "demandas") ?>
                  <td class="hidden-xs hidden-sm"><?php echo $demanda['Demanda']['criador']; ?></td>
                  <td>
                   <?php
                      echo $this->Html->link("<i class='fa fa-eye' style='margin-right: 5px;' title='Visualizar detalhes da demanda.'></i>",
                        array('controller' => 'demandas', 'action' => 'view', $demanda['Demanda']['id']),
                        array('escape' => false));
                      echo $this->Html->link("<i class='fa fa-pencil' title='Editar demanda.'></i>",
                        array('controller' => 'demandas', 'action' => 'edit', $demanda['Demanda']['id']),
                        array('escape' => false));
                      echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;' title='Excluir demanda.'></i>",
                        array('action' => 'delete', $demanda['Demanda']['id']),
                        array('escape' => false), "O registro será excluído, você tem certeza dessa ação?");
                   ?>
                  </td>
                </tr>
              <?php endforeach; ?>
              <?php unset($demanda); ?>
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

  //-- DataTables JavaScript --
  echo $this->Html->script('plugins/dataTables/media/js/jquery.dataTables.js');
  echo $this->Html->script('plugins/dataTables/dataTables.bootstrap.js');
  echo $this->Html->css('plugins/dataTables.bootstrap.css');
    //-- DataTables --> TableTools
    echo $this->Html->script('plugins/dataTables/extensions/TableTools/js/dataTables.tableTools.min.js');
    echo $this->Html->css('plugins/dataTablesExtensions/TableTools/css/dataTables.tableTools.min.css');
    //-- DataTables --> Responsive
    echo $this->Html->script('plugins/dataTables/extensions/Responsive/js/dataTables.responsive.min.js');
    echo $this->Html->css('plugins/dataTablesExtensions/Responsive/css/dataTables.responsive.css');

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');

  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
?>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
  $(document).ready(function() {
      oTable = $('#dataTables-demanda').dataTable({
          "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
          language: {
            url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
          },
        //  responsive: true,
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

      $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'top'});

      $("[id*='filterDt']").datetimepicker({
        format: "yyyy-mm-dd",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
      });

      $('#myModal').on('shown.bs.modal', function (e) {
        document.getElementById('modal-body').appendChild(
            document.getElementById('demandaFrame')
        );
        document.getElementById('demandaFrame').style.display = "block";
        //document.getElementById('demandaFrame').style.height = "720px";
      });
  });
</script>

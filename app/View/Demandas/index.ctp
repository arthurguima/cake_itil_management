<?php
  $this->Html->addCrumb('Demandas', '/demandas');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Demandas Internas
        <div class="col-lg-2 pull-right">
          <?php
            if($this->Ldap->autorizado(2)){
              echo $this->Html->link("<i class='fa fa-plus'></i> Nova",
               array('controller' => 'demandas', 'action' => 'add'),
               array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false));
            }
          ?>
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
          <div class="col-lg-12 filters-item">
            <div class="form-group"><?php echo $this->Search->input('nome_', array('class' => 'form-control', 'placeholder' => "Nome")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('responsavel', array('class' => 'form-control', 'placeholder' => "Solicitante")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('clarity_dm', array('class' => 'form-control', 'placeholder' => "Clarity DM")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('tipo', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('servico', array('class' => 'select2 form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('status', array('class' => 'form-control')); ?></div>
          </div>
          <div class="col-lg-12">
            <div class="form-group"><?php echo $this->Search->input('status_diferente', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('status_diferente2', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('status_diferente3', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('status_diferente4', array('class' => 'form-control')); ?></div>
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
                <th class="hidden-xs hidden-sm">Clarity DM <i class='fa-expand fa' style="font-size: 15px !important;"></i></th>
                <th class="hidden-xs hidden-sm">Mantis <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
                <th>Título <i class="fa fa-comment-o" style="font-size: 15px !important;"></i></th>
                <th>Nome</th>

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
                  <td class="hidden-xs hidden-sm">
                    <span style="cursor:pointer;" title="Clique para alterar a prioridade!" id="<?php echo $demanda['Demanda']['id']?>"><?php echo $demanda['Demanda']['prioridade']; ?></span>
                  </td>
                  <?php echo $this->Tables->PrioridadeEditable($demanda['Demanda']['id'], "demandas") ?>
                  <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!">
                    <?php
                      echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                            $demanda['Demanda']['clarity_id'] .")'>" . $demanda['Demanda']['clarity_dm_id'] ."</a></span>"
                    ?>
                  </td>
                  <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Mantis!">
                    <?php echo $this->Html->link($demanda['Demanda']['mantis_id'],"http://www-testes/view.php?id=" . $demanda['Demanda']['mantis_id'], array('target' => '_blank')); ?>
                  </td>
                  <td><?php echo $this->Tables->popupBox($demanda['Demanda']['nome'], $demanda['Demanda']['descricao']) ?></td>
                  <td><?php echo $demanda['Demanda']['nome']; ?></td>
				          <td style="max-width: 110px;"><div class="tipo-demanda"><?php echo $demanda['DemandaTipo']['nome']; ?></div></td>

                  <td class="text-center">
                    <?php echo $this->Times->timeLeftTo($demanda['Demanda']['data_cadastro'], $demanda['Demanda']['dt_prevista'],
                             $demanda['Demanda']['data_cadastro'] . " - " . $demanda['Demanda']['dt_prevista'],
                            ($demanda['Demanda']['data_homologacao']));
                    ?>
                  </td>

                  <td>
                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $demanda['Demanda']['id'] ?>">
                      <?php echo $demanda['Status']['nome']; ?>
                    </span>
                  </td>
                  <?php echo $this->Tables->DemandaStatusEditable($demanda['Demanda']['id'], "demandas") ?>
                  <td class="hidden-xs hidden-sm"><div class="sub-17"><?php echo $demanda['Demanda']['criador']; ?></div></td>
                  <td>
                    <?php
                      echo $this->Tables->getMenu('demandas', $demanda['Demanda']['id'], 14);
                      echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $demanda['Demanda']['id'] . ")'>
                        <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
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

<div class="modal fade" id="Historico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body" id="modal-body">
        <iframe id="historicoFrame" name='demanda' width='100%' height='720px' frameborder='0'></iframe>
      </div>
    </div>
  </div>
</div>

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
    //-- DataTables --> ColVis
      echo $this->Html->script('plugins/dataTables/extensions/ColVis/js/dataTables.colVis.min.js');
      echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colVis.min.css');
      echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colvis.jqueryui.css');

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');

  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');

  //Select2
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->css('plugins/select2-bootstrap');
?>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      containerCssClass: 'select2'
    });

    var  oTable = $('#dataTables-demanda').dataTable({
          "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
          language: {
            url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
          },
          "columnDefs": [  { "visible": false, "targets": 5 } ],
          //"dom": 'T<"clear">lfrtip',
          "dom": 'TC<"clear">lfrtip',
          "colVis": {
            "buttonText": "Esconder Colunas"
          },
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
                    "sFileName": "Demandas.csv",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,5,6,7,8,9 ]
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "sFileName": "Demandas.pdf",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "sPdfOrientation": "landscape",
                    "mColumns": [ 0,1,2,3,6,7,8,9 ],
                    "sTitle": "Listagem de Demandas Internas",
                    "sPdfMessage": "<?php echo date('d/m/y')?>"
                },
              ]
          }
      });
      var colvis = new $.fn.dataTable.ColVis( oTable );

      $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'right', html: 'true'});

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

  function historico(id){
    document.getElementById('historicoFrame').src = "<?php echo(Router::url('/', true). "historicos/popup?controller=demandas&id=");?>" + id;
  }
</script>

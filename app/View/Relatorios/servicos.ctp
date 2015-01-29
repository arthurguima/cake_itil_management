<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Serviço
      </h3>
    </div>
  <div class="col-lg-12 pull-left filters">
    <div class="">
      <div class="row"><span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">Filtros <i class="fa fa-plus-square"></i></span></div>
      <div class="row inner">
        <?php  echo $this->BootstrapForm->create(false, array('class' => 'form-inline')); ?>
        <div class="col-lg-12 filters-item">
          <div class="form-group">
            <?php echo $this->BootstrapForm->input('servico_id', array(
                              'label' => array('text' => 'Serviço: '))); ?>
          </div>
        </div>
        <div class="col-lg-12 filters-item">
          <div class="form-group">
            <?php
              echo $this->BootstrapForm->input('dt_inicio', array(
                          'type' => 'text',
                          'label' => array('text' => 'Data de Início:'),
                          'id' => 'dp '));
            ?>
            <?php
              echo $this->BootstrapForm->input('dt_fim', array(
                          'type' => 'text',
                          'label' => array('text' => 'Data de Fim:'),
                          'id' => 'dp '));
            ?>
          </div>
        </div>
        <?php
          echo $this->BootstrapForm->button("Filtrar <i class='fa fa-search'></i>", array('type' => 'submit', 'class' => 'control-label btn btn-default pull-right'));
          echo $this->BootstrapForm->end();
        ?>
      </div>
    </div>
  </div>
</div>

<?php if($this->request->data != null): ?>
  <?php $totaltime = 0; ?>
  <div class="row">
    <div class="col-lg-4">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <p>
            <h3 class="panel-title">Informações</h3>
          </p>
        </div>
        <div class="panel-body">
          <ul class="nav nav-pills nav-stacked">
            <li><a><b>Nome: </b><?php echo $servico['Servico']['nome']; ?></a></li>
            <li><a><b>Sigla: </b><?php echo $servico['Servico']['sigla']; ?></a></li>
            <li><a><b>Tecnologia: </b><?php echo $servico['Servico']['tecnologia']; ?></a></li>
            <li><a style="overflow: auto;"><b>URL: </b><?php echo $servico['Servico']['url']; ?></a></li>
            <li><a><b>Status: </b><?php echo $this->Times->active($servico['Servico']['status'])?></td></a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading"><b> Lista de Demandas Internas </b></div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-demanda">
              <thead>
                <tr>
                  <th class="hidden-xs hidden-sm"><span class="editable">Prioridade</span></th>
                  <th class="hidden-xs hidden-sm">Clarity DM</th>
                  <th class="hidden-xs hidden-sm">Mantis</th>
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
                <?php foreach ($servico['Demanda'] as $serv): ?>
                  <tr>
                    <td class="hidden-xs hidden-sm">
                      <span style="cursor:pointer;" title="Clique para alterar a prioridade!" id="<?php echo $serv['id']?>"><?php echo $serv['prioridade']; ?></span>
                    </td>
                    <?php echo $this->Tables->PrioridadeEditable($serv['id'], "demandas") ?>
                    <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!">
                      <?php
                        echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                              $serv['clarity_id'] .")'>" . $serv['clarity_dm_id'] ."</a></span>"
                      ?>
                    </td>
                    <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Mantis!">
                      <?php echo $this->Html->link($serv['mantis_id'],"http://www-testes/view.php?id=" . $serv['mantis_id'], array('target' => '_blank')); ?>
                    </td>
                    <td><?php echo $this->Tables->popupBox($serv['nome'], $serv['descricao']) ?></td>
                    <td><?php echo $serv['nome']; ?></td>
                    <td style="max-width: 110px;"><div class="tipo-demanda"><?php echo $serv['DemandaTipo']['nome']; ?></div></td>

                    <td class="text-center">
                      <?php echo $this->Times->timeLeftTo($serv['data_cadastro'], $serv['dt_prevista'],
                              $this->Time->format('d/m/Y', $serv['data_cadastro']) . " - " . $this->Time->format('d/m/Y', $serv['dt_prevista']),
                              ($serv['data_homologacao']));
                      ?>
                    </td>

                    <td>
                      <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $serv['id'] ?>"><?php echo $serv['Status']['nome']; ?></span>
                    </td>
                    <?php echo $this->Tables->DemandaStatusEditable($serv['id'], "demandas") ?>
                    <td class="hidden-xs hidden-sm"><div class="sub-17"><?php echo $serv['criador']; ?></div></td>
                    <td><?php echo $this->Tables->getMenu('demandas', $serv['id'], 14); ?></td>
                  </tr>
                <?php endforeach; ?>
                <?php unset($serv); ?>
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
<?php endif; ?>

<script>
  $(document).ready(function() {
    $("[id*='dp']").datetimepicker({
      format: 'dd/mm/yyyy',
      minView: 2,
      autoclose: true,
      todayBtn: true,
      language: 'pt-BR'
    });

    oTable = $('#dataTables-demanda').dataTable({
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
</script>


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
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
?>

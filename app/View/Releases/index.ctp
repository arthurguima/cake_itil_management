<?php
  $this->Html->addCrumb('Serviços', '');
  $this->Html->addCrumb('Release', '/releases');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Releases
        <div class="col-lg-2 pull-right">
          <?php
            if($this->Ldap->autorizado(2)){
              echo $this->Html->link("<i class='fa fa-plus'></i> Novo",
               array('controller' => 'Releases', 'action' => 'add'),
               array('class' => 'btn btn-sm btn-success pull-right', 'escape' => false));
            }
          ?>
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
              <?php echo $this->Search->input('servico', array('class' => 'select2 form-control')); ?>
            </div>
            <div class="form-group">
              <b>Data de Fim: </b>
              <?php echo $this->Search->input('dt_fim',
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
              ?>
            </div>
          </div>
          <div class="col-lg-12 filters-item">
            <b>Data de Execução da RDM: </b>
            <?php echo $this->Search->input('dt_executada',
                        array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                        array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
            ?>
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
    <?php $var = 0; foreach ($releases as $release): ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <b>
            <?php echo $release['Servico']['sigla'] . " - " .$release['Release']['versao']; ?>
            <span style="float: right;"><?php echo $this->Tables->getMenu('Releases', $release['Release']['id'], 14); ?></span>
          </b>
        </div>
        <div class="panel-body">
          <div class="">
            <div class="bs-callout bs-callout-warning col-lg-5 pull-left">
              <h4 class="normal">
                RDM: <?php echo $this->Html->link($release['Rdm']['numero'], array('controller' => 'rdms', 'action' => 'view', $release['Rdm']['id'])); ?>
                 -- Data Prevista: <?php echo $release['Rdm']['dt_prevista']; ?>
                 <span class="bs-callout-actions">
                   <?php
                     echo $this->Tables->getMenu('rdms', $release['Rdm']['id'], 14);
                     echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $release['Rdm']['id'] . ")'>
                       <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a>";
                   ?>
                 </span>
              </h4>
            </div>
            <div class="bs-callout bs-callout-default col-lg-6 pull-right">
                <h4 class="normal">
                <?php echo $this->Times->timeLeftTo($release['Release']['dt_ini_prevista'], $release['Release']['dt_fim_prevista'],
                          $release['Release']['dt_ini_prevista'] . " - " .  $release['Release']['dt_fim_prevista'],
                          ($release['Release']['dt_fim']));
                          ?>
                </h4>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-releases-<?php echo $var; ?>">
              <thead>
                <tr>
                  <th>Prioridade</th>
                  <th><span class="editable">Status</span></th>
                  <th>Solicitada pelo Cliente?</th>
                  <th>Demanda</th>
                  <th>Mantis</th>
                  <th>Título <i class="fa fa-comment-o" style="font-size: 15px !important;"></i></th>
                  <th>Prazo</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($release['Rdm']['Demanda'] as $d): ?>
                  <tr>
                    <td class="hidden-xs hidden-sm">
                      <span style="cursor:pointer;" title="Clique para alterar a prioridade!" id="<?php echo $d['id']?>"><?php echo $d['prioridade']; ?></span>
                    </td>
                    <?php echo $this->Tables->PrioridadeEditable($d['id'], "demandas") ?>
                    <td>
                      <span style="border-bottom: 3px solid #<?php echo substr(md5($d['Status']['nome']), 0, 6) ?>;" cursor:pointer; title="Clique para alterar o status!" id="<?php echo "status-" . $d['id'] ?>">
                        <?php echo $d['Status']['nome']; ?>
                      </span>
                    </td>
                    <?php echo $this->Tables->DemandaStatusEditable($d['id'], "demandas") ?>
                    <td><?php echo $this->Times->yesOrNo($d['origem_cliente']); ?></td>
                    <td><?php echo $d['clarity_dm_id']; ?></td>
                    <td><?php echo $d['mantis_id']; ?></td>
                    <td><?php echo $this->Tables->popupBox($d['nome'], $d['descricao']) ?></td>
                    <td>
                      <?php echo $this->Times->timeLeftTo($d['data_cadastro'], $d['dt_prevista'],
                             $d['data_cadastro'] . " - " . $d['dt_prevista'],
                            ($d['data_homologacao']));?>
                    </td>
                   <td>
                     <?php echo $this->Tables->getMenu('Releases', $release['Release']['id'], 14);
                      echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $d['id'] . ")'>
                       <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";?>
                   </td>
                  </tr>
                <?php endforeach; ?>
                <?php unset($d); ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <script>
        $(document).ready(function() {
          $('#dataTables-releases-<?php echo $var; ?>').dataTable({
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
        });
      </script>
    <?php $var++; endforeach; ?>
    <?php unset($release); ?>
  </div>
</div>

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

  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');

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

      $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'right', html: 'true'});

      $("[id*='filterDt']").datetimepicker({
        format: "yyyy-mm-dd",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
      });
  });

  function historico(id){
    document.getElementById('historicoFrame').src = "<?php echo(Router::url('/', true). "historicos/popup?controller=demandas&id=");?>" + id;
  }
</script>

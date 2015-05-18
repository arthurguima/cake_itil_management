<?php
  $this->Html->addCrumb("Relatórios", '');
  $this->Html->addCrumb("Disponibilidade por Serviço", '/relatorios/indisponibilidades');
?>

<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Disponibilidade por Serviço
      </h3>
    </div>
  <div class="col-lg-12 pull-left filters">
    <div class="">
      <div class="row">
        <span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">
          Filtros <i class="fa fa-plus-square"></i>
        </span>
      </div>
      <div class="row inner">
        <?php  echo $this->BootstrapForm->create(false, array('class' => 'form-inline')); ?>
        <div class="col-lg-12 filters-item">
          <div class="form-group">
            <?php echo $this->BootstrapForm->input('servico_id', array(
                              'label' => array('text' => 'Serviço: '),
                              'class' => 'select2 form-control',
                              'empty' => 'servico',
                              'selected' => $this->params['url']['servico_id'])); ?>
          </div>
          <div class="form-group">
            <?php echo $this->BootstrapForm->input('motivo_id', array(
                       'type' => 'select',
                       'label' => array('text' => 'Motivo: '),
                       'default' => 0,
                       'empty' => true )); ?>
          </div>
        </div>
        <div class="col-lg-12 filters-item">
          <div class="form-group">
            <?php
              echo $this->BootstrapForm->input('dt_inicio', array(
                          'type' => 'text',
                          'label' => array('text' => 'Data de Início:'),
                          'id' => 'dp ',
                          'value' => $this->params['url']['dt_inicio']));
            ?>
            <?php
              echo $this->BootstrapForm->input('dt_fim', array(
                          'type' => 'text',
                          'label' => array('text' => 'Data de Fim:'),
                          'id' => 'dp ',
                          'value' => $this->params['url']['dt_fim']));
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

<?php if($this->request->data != null || $this->params['url']['servico_id'] != null): ?><div class="row">
  <?php $totaltime = 0; $contatime = 0; ?>
    <div class="col-lg-9">
      <div class="panel panel-default">
        <div class="panel-heading">Lista de Indisponibilidades - <b><?php echo $servico['Servico']['nome']; ?></b></div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-Indisponibilidades">
              <thead>
                <tr>
                  <th>Nº Evento</th>
                  <th>Nº Incidente</th>
                  <th>Início</th>
                  <th>Duração</th>
                  <th>Observação</th>
                  <th>Observação</th>
                  <th>Tipo</th>
                  <th><span class="editable">Status</span></th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($servico['Indisponibilidade'] as $Indisponibilidade): ?>
                  <tr>
                    <td>
                      <?php
                        echo $this->Html->link($Indisponibilidade['num_evento'],
                              "http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH+FACTORY=in+SKIPLIST=1+QBE.IN.ref_num=" . $Indisponibilidade['Indisponibilidade']['num_evento'] . "%25",
                              array('target' => '_blank'));
                      ?>
                    </td>
                    <td>
                      <?php
                        echo $this->Html->link($Indisponibilidade['num_incidente'],
                              "http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH+FACTORY=in+SKIPLIST=1+QBE.IN.ref_num=" . $Indisponibilidade['Indisponibilidade']['num_incidente'] . "%25",
                              array('target' => '_blank'));
                      ?>
                    </td>
                    <td data-order=<?php echo $this->Time->format('Ymd', $Indisponibilidade['dt_inicio']); ?>>
                      <?php echo $this->Time->format('d/m/Y H:i', $Indisponibilidade['dt_inicio']); ?>
                    </td>
                    <td><!-- TODO: transformar em HELPER -->
                      <?php
                        if($Indisponibilidade['dt_fim'] != null){
                          echo $this->Times->totalTime($Indisponibilidade['dt_inicio'], $Indisponibilidade['dt_fim']);
                          $totaltime += $this->Times->diffInSec($Indisponibilidade['dt_inicio'], $Indisponibilidade['dt_fim']);

                          if($Indisponibilidade['Motivo']['contavel'] == true)
                            $contatime += $this->Times->diffInSec($Indisponibilidade['dt_inicio'], $Indisponibilidade['dt_fim']);
                        }
                        else{
                          echo $this->Times->totalTime($Indisponibilidade['dt_inicio'], date('Y-m-d'));
                          $totaltime += $this->Times->diffInSec($Indisponibilidade['dt_inicio'], date('Y-m-d'));

                          if($Indisponibilidade['Motivo']['contavel'] == true)
                            $contatime += $this->Times->diffInSec($Indisponibilidade['dt_inicio'], date('Y-m-d'));
                        }
                      ?>
                    </td><!-- TODO: transformar em HELPER -->
                    <td><?php echo $this->Tables->popupBox($Indisponibilidade['observacao']) ?></td>
                    <td><?php echo $Indisponibilidade['observacao']; ?></td>
                    <td><?php echo $Indisponibilidade['Motivo']['nome'] ?></td>

                    <td id="<?php echo $Indisponibilidade['id']?>">
                      <?php
                        if($Indisponibilidade['dt_fim'] == null):
                          echo "<span class='label label-success'>Aberto</span>";
                        else:
                          echo "<span class='label label-default'>Fechado</span>";
                        endif;
                      ?>
                    </td>
                    <?php
                      if($Indisponibilidade['dt_fim'] == null)
                        echo $this->Tables->StatusEditable($Indisponibilidade['id'], "indisponibilidades");
                    ?>
                    <td><?php echo $this->Tables->getMenu('Indisponibilidades', $Indisponibilidade['id'], 14); ?></td>
                  </tr>
                <?php endforeach; ?>
                <?php unset($Indisponibilidade); ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <p>
            <h3 class="panel-title">Relatório de Indisponibilidade</h3>
          </p>
        </div>
        <?php if($this->request->data != null): ?>
          <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
              <li>
                <a><b>Tempo Total: </b>
                  <?php
                    echo $this->Times->totalTime(
                        $this->Times->AmericanDate($this->request->data['dt_inicio']), $this->Times->AmericanDate($this->request->data['dt_fim']));
                  ?>
                </a>

              </li>
              <!--li><a><b>Indisponível: </b><?php //echo   $this->Times->SecToString($totaltime); ?></a></li-->
              <li><a><b>Indisponibilidade Contabilizada: </b><?php echo   $this->Times->SecToString($contatime); ?></a></li>
            </ul>
            <div class='semicircle col-md-6 col-md-offset-3'>
              <?php
                $percent = ($contatime / $this->Times->diffInSec(
                        $this->Times->AmericanDate($this->request->data['dt_inicio']), $this->Times->AmericanDate($this->request->data['dt_fim'])))*100;
              ?>
              <div id='semicircle' data-dimension='100' data-width='8'
                                   data-text='<?php echo round((100 - $percent),2); ?>%'
                                   data-percent='<?php echo $percent ?>'
                                   data-fontsize='9px' data-fgcolor='#d9534f' data-bgcolor='#5CB85C' data-fill='#EEE'></div>
            </div>
          </div>
        <?php else: ?>
          <div class="panel-body">
            <ul class="nav nav-pills nav-stacked">
              <li>
                <a><b>Tempo Total: </b>
                  <?php
                    echo round($this->Times->totalTime(
                      $this->Times->AmericanDate($this->params['url']['dt_inicio']), $this->Times->AmericanDate($this->params['url']['dt_fim'])), 2);
                  ?>
                </a>
              </li>
              <!--li><a><b>Indisponível: </b><?php //echo   $this->Times->SecToString($totaltime); ?></a></li-->
              <li><a><b>Indisponibilidade Contabilizada: </b><?php echo   $this->Times->SecToString($contatime); ?></a></li>
            </ul>
            <div class='semicircle col-md-6 col-md-offset-3'>
              <?php
                $percent = ($contatime / $this->Times->diffInSec(
                        $this->Times->AmericanDate($this->params['url']['dt_inicio']), $this->Times->AmericanDate($this->params['url']['dt_fim'])))*100;
              ?>
              <div id='semicircle' data-dimension='100' data-width='8'
                                   data-text='<?php echo round((100 - $percent),2); ?>%'
                                   data-percent='<?php echo $percent ?>'
                                   data-fontsize='9px' data-fgcolor='#d9534f' data-bgcolor='#5CB85C' data-fill='#EEE'></div>
            </div>
          </div>
        <?php endif; ?>
    </div>
  </div>
</div><?php endif; ?>


<script>
  $(document).ready(function() {
    $("[id*='dp']").datetimepicker({
      format: 'dd/mm/yyyy',
      minView: 2,
      autoclose: true,
      todayBtn: true,
      language: 'pt-BR'
    });

    $('#semicircle').circliful();

    $('.select2').select2({
     containerCssClass: 'select2'
    });

    var  oTable =  $('#dataTables-Indisponibilidades').dataTable({
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
          language: {
            url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
          },
        //  responsive: true,
          "dom": 'TC<"clear">lfrtip',
          "colVis": {
            "buttonText": "Esconder Colunas"
          },
          "columnDefs": [  { "visible": false, "targets": 5 } ],
          "tableTools": {
              "sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
              "aButtons": [
                {
                    "sExtends": "copy",
                    "sButtonText": "Copiar",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,5,6,7 ],
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,5,6,7 ],
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "sFileName": "Indisponibilidades - <?php if(isset($servico['Servico']['sigla'])) echo $servico['Servico']['sigla']; ?>.pdf",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,5,6,7 ],
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "sFileName": "Indisponibilidades - <?php if(isset($servico['Servico']['sigla'])) echo $servico['Servico']['sigla']; ?>.pdf",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,6,7 ],
                    "sPdfOrientation": "landscape",
                    "sTitle": "<?php if(isset($servico['Servico']['nome'])) echo $servico['Servico']['nome']; ?> - Controle de Disponibilidade",
                    <?php
                      if (isset($this->request->data['dt_inicio'])){
                        echo ('"sPdfMessage": "A partir de: ' . $this->request->data['dt_inicio'] .
                              ' Até ' . $this->request->data['dt_fim'] .
                              ' Extraido em: ' . date('d/m/y') . '"');
                      }
                      else{
                        if(isset($this->params['url']['dt_inicio'])){
                          echo ('"sPdfMessage": "A partir de: ' . $this->params['url']['dt_inicio'] .
                                ' Até ' . $this->params['url']['dt_fim'] .
                                ' Extraído em: ' . date('d/m/y') . '"');
                        }else{
                          echo('"sPdfMessage": "Extraido em: ' . date('d/m/y') . '"');
                        }
                      }
                    ?>
                },
              ]
          }
    });
    var colvis = new $.fn.dataTable.ColVis( oTable );

    $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'top'});
});
</script>



<?php
  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');

  // Circliful
  echo $this->Html->script('plugins/circliful/js/jquery.circliful.js');
  echo $this->Html->css('plugins/jquery.circliful.css');

  //Select2
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->css('plugins/select2-bootstrap');

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

  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
?>

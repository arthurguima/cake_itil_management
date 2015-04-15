<?php
  $this->Html->addCrumb("Relatórios", '');
  $this->Html->addCrumb("Disponibilidade Geral", '/relatorios/indis_total');
?>

<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Disponibilidade
      </h3>
    </div>
  <div class="col-lg-12 pull-left filters">
    <div class="">
      <div class="row"><span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">Filtros <i class="fa fa-plus-square"></i></span></div>
      <div class="row inner">
        <?php  echo $this->BootstrapForm->create(false, array('class' => 'form-inline')); ?>
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
          <div class="form-group">
            <?php echo $this->BootstrapForm->input('motivo_id', array(
                       'type' => 'select',
                       'label' => array('text' => 'Motivo: '),
                       'default' => 0,
                       'empty' => true )); ?>
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
  <?php
    $totaltime = 0;
    $total = $this->Times->diffInSec(
              $this->Times->AmericanDate($this->request->data['dt_inicio']), $this->Times->AmericanDate($this->request->data['dt_fim']));
  ?>

  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading"><b> Lista de Indisponibilidades </b></div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-Indisponibilidades">
              <thead>
                <tr>
                  <th>Serviço</th>
                  <th>Tempo Indisponível</th>
                  <th>Tempo Acordado(Hora)</th>
                  <th>Disponibilidade Obtida</th>
                  <th>Disponibilidade Acordada</th>
                  <th>IQOM(qtd incidentes)</th>
                  <th>MTTR(tempo médio de restauração)</th>
                </tr>
              </thead>
              <tbody>
                <?php
                //  debug($servicos);
                  foreach ($servicos as $ser):
                    $totaltime = 0;
                    foreach ($ser['Indisponibilidade'] as $in):
                      if($in['dt_fim'] != null):
                        $totaltime += $this->Times->diffInSec($in['dt_inicio'], $in['dt_fim']);
                      endif;
                    endforeach;
                ?>
                <tr>
                  <td><?php echo $ser['Servico']['sigla']; ?></td>
                  <td data-order="<?php echo $totaltime; ?>">
                    <?php echo $this->Times->SecToString($totaltime); ?>
                  </td>
                  <td>
                    <?php
                      echo $this->Times->SecToString(0.02*$this->Times->diffInSec(
                        $this->Times->AmericanDate($this->request->data['dt_inicio']), $this->Times->AmericanDate($this->request->data['dt_fim'])));
                    ?>
                  </td-->
                  <td><?php echo round(100 - ($totaltime/$total)*100,2); ?>%</td>
                  <td>98%</td>
                  <td><?php echo sizeof($ser['Indisponibilidade']); ?></td>
                  <?php if(sizeof($ser['Indisponibilidade']) > 0): ?>
                    <td data-order="<?php echo $totaltime/sizeof($ser['Indisponibilidade']); ?>">
                      <?php
                        if(sizeof($ser['Indisponibilidade']))
                          echo $this->Times->SecToString($totaltime/sizeof($ser['Indisponibilidade']));
                        else
                          echo "---";
                      ?>
                    </td>
                <?php else: ?>
                  <td>0h</td>
                <?php endif ?>
                </tr>
                <?php endforeach; ?>
                <?php unset($Indisponibilidade); ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php
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


<script>
  $(document).ready(function() {
    $("[id*='dp']").datetimepicker({
      format: 'dd/mm/yyyy',
      minView: 2,
      autoclose: true,
      todayBtn: true,
      language: 'pt-BR'
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
          "tableTools": {
              "sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
              "aButtons": [
                {
                    "sExtends": "copy",
                    "sButtonText": "Copiar",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    //"mColumns": [ 0,1,2,3,4,5,6,7 ]
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    //"mColumns": [ 0,1,2,3,4,5,6,7 ]
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "sFileName": "Indisponibilidades.csv",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    //"mColumns": [ 0,1,2,3,4,5,6,7 ]
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "sFileName": "Indisponibilidades(<?php
                      if (isset($this->request->data['dt_inicio']) && isset($this->request->data['dt_fim']))
                          echo str_replace('/', '_', $this->request->data['dt_inicio'] . " a "  . $this->request->data['dt_fim']);
                    ?>).pdf",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    //"mColumns": [ 0,1,2,3,4,5,6,7 ],
                    "sPdfOrientation": "landscape",
                    "sTitle": "Controle de Disponibilidade",
                    <?php
                      if (isset($this->request->data['dt_inicio'])){
                        echo ('"sPdfMessage": "A partir de: ' . $this->request->data['dt_inicio'] .
                              ' Até ' . $this->request->data['dt_fim'] .
                              ' Extraído em: ' . date('d/m/y') . '"');
                      }
                      else{
                          echo('"sPdfMessage": "Extraido em: ' . date('d/m/y') . '"');
                      }
                    ?>
                },
              ]
          }
      });
      var colvis = new $.fn.dataTable.ColVis( oTable );
  });
</script>

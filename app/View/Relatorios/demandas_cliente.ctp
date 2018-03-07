<?php
  $this->Html->addCrumb("Relatórios", '');
  $this->Html->addCrumb("Demandas Não Finalizadas do Cliente", '/relatorios/demandas_cliente');
?>

<div class="col-lg-12 page-header-box">
  <div class="col-lg-12">
    <h3 class="page-header">
      Demandas Não Finalizadas do Cliente
      <span style="cursor:pointer;" onclick="javascript:$('div.panel-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
    </h3>
  </div>
</div>

<div>
  <div class="col-lg-12 pull-left filters">
    <div class="">
      <div class="row">
        <span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">
          Filtros <i class="fa fa-plus-square"></i>
        </span>
      </div>
      <div class="row inner">
        <?php  echo $this->BootstrapForm->create(false, array('id' => "form-filter-results", 'class' => 'form-inline')); ?>
        <div class="col-lg-12 filters-item">
          <div class="form-group ">
            <?php

              echo $this->BootstrapForm->input('cliente_id', array(
                          'label' => array('text' => 'Cliente: '),
                          'class' => 'select2 form-control',
                          'empty' => 'Cliente'));

              $options = array( 1 => 'Sim', 0 => 'Não');
              echo $this->BootstrapForm->input('origem_cliente', array(
                          'label' => array('text' => 'Solicitada pelo Cliente?: '),
                          'empty' => 'Solicitada pelo Cliente?',
                          'options' => $options));

              echo $this->BootstrapForm->input('demanda_tipo_id', array(
                          'label' => array('text' => 'Tipo da Demanda: '),
                          'empty' =>  'Tipo'));

              echo $this->BootstrapForm->input('user_id', array(
                     'class' => 'select2',
                     'label' => array('text' => 'Responsável: '),
                     'empty' => "Responsável"));
            ?>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="form-group">
            <?php
            echo $this->BootstrapForm->input('status_id', array(
                        'label' => array('text' => 'Status: '),
                        'empty' =>  'Status'));
            ?>
          </div>
        </div>
        <?php
          echo $this->BootstrapForm->button("Filtrar <i class='fa fa-search'></i>", array('type' => 'submit', 'class' => 'control-label btn btn-default pull-right'));
          if(sizeof($filtro) > 0) $id = $filtro['Filtro']['id']; else $id = "'null'";
          echo $this->Filtros->btnSave("r_dem_cliente", $this->Session->read('User.uid'), $id);
          echo $this->BootstrapForm->end();
        ?>
      </div>
    </div>
  </div>
</div>

<?php if($this->request->data['cliente_id']):
  $key = $this->request->data['cliente_id']; ?>
  <div class="row">
    <div class="col-lg-12 demandas delete">
      <div class="panel panel-default">
        <div class="panel-heading">
          <b>
            Demandas - <?php echo $clientes[$this->request->data['cliente_id']]; ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.hide-d').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </b>
        </div>
        <div class="panel-body hide-d">
          <div class="table-responsive">
            <table class="table display table-striped table-bordered table-hover" id="dataTables-d">
              <thead>
                <tr>
                  <th>Demanda</th>
                  <th>Nome</th>
                  <th>Tipo</th>
                  <th>Status</th>
                  <th>Solicitada pelo Cliente?</th>
                  <th>Prazo</th>
                  <th>Histórico</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($demandas as $dem): ?>
                  <tr>
                    <td style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!">
                      <?php
                        echo '<a id="viewClarity" href="https://projetos.dataprev.gov.br/niku/nu#action:pma.ideaProperties&id='. $dem['Demanda']['clarity_id'] .'" target="_blank">' . $dem['Demanda']['clarity_dm_id'] . '</a>'
                        /*echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                              $dem['Demanda']['clarity_id'] .")'>" . $dem['Demanda']['clarity_dm_id'] ."</a></span>"*/
                      ?>
                    </td>
                    <td><?php echo $this->html->link($dem['Demanda']['nome'], array('controller'=> 'demandas', 'action' => 'view', $dem['Demanda']['id'])); ?></td>
                    <td><?php echo $dem['DemandaTipo']['nome']; ?></td>
                    <td><?php echo $dem['Status']['nome']; ?></td>
                    <td><?php echo $this->Times->yesOrNo($dem['Demanda']['origem_cliente']); ?></td>
                    <td class="text-center">
                      <?php echo $this->Times->timeLeftTo($dem['Demanda']['data_cadastro'], $dem['Demanda']['dt_prevista'],
                               $dem['Demanda']['data_cadastro'] . " - " . $dem['Demanda']['dt_prevista'],
                              ($dem['Demanda']['data_homologacao']));
                      ?>
                    </td>
                    <td>
                      <ul style="overflow: auto;">
                        <?php
                          if(isset($dem['DemandaPai']['id'])) echo "<li><b>Demanda Pai: </b>" . $dem['DemandaPai']['clarity_dm_id'] . "</li>";
                          foreach ($dem['Historico'] as $h):
                            echo  '<li>(' . $h['data'] . ') - ' .$this->Historicos->findLinks($h['descricao']) . '</li>';
                          endforeach;
                          unset($dem);
                        ?>
                      </ul>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <?php unset($dem); ?>
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

  <script>
    $(document).ready(function() {
      var  oTable =   $('#dataTables-d').dataTable({
          "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
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
                      "mColumns": "visible",
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
                      "sFileName": "Demandas(<?php echo $clientes[$this->request->data['cliente_id']]; ?>).csv",
                      "oSelectorOpts": { filter: 'applied', order: 'current' },
                      "mColumns": "visible",
                  },
                  {
                      "sExtends": "pdf",
                      "sButtonText": "PDF",
                      "sFileName": "Demandas(<?php echo $clientes[$this->request->data['cliente_id']]; ?>).pdf",
                      "oSelectorOpts": { filter: 'applied', order: 'current' },
                      "mColumns": "visible",
                      "sPdfOrientation": "landscape",
                      "sTitle": "Demandas(<?php echo $clientes[$this->request->data['cliente_id']]; ?>)",
                      "sPdfMessage": "Extraído em: <?php echo date('d/m/y')?>",
                  },
                ]
            },
        });
        var colvis = new $.fn.dataTable.ColVis( oTable );

        $('#myModal').on('shown.bs.modal', function (e) {
          document.getElementById('modal-body').appendChild(
              document.getElementById('demandaFrame')
          );
          document.getElementById('demandaFrame').style.display = "block";
          //document.getElementById('demandaFrame').style.height = "720px";
        });
    });
  </script>
<?php endif; ?>

<script>
  <?php
    if(sizeof($filtro) > 0){
      $valor =  unserialize($filtro['Filtro']['valor']);
      echo "var filtro_array = " . json_encode($valor). ";";
    }
    echo $this->Filtros->camelCase();
  ?>

  $(document).ready(function() {
    $('.select2').select2({
      language: "pt-BR",
      theme: "bootstrap"
    });

    <?php
      if(sizeof($filtro) > 0)
        echo $this->Filtros->fillFormB();
    ?>
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
  //-- DataTables --> ColVis
    echo $this->Html->script('plugins/dataTables/extensions/ColVis/js/dataTables.colVis.min.js');
    echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colVis.min.css');
    echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colvis.jqueryui.css');

    //-- Select2 --
    echo $this->Html->script('plugins/select2/select2.full.min');
    echo $this->Html->css('plugins/select2.min');
    echo $this->Html->css('plugins/select2-bootstrap.min');
    echo $this->Html->script('plugins/select2/pt-BR');
?>

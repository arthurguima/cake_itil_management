<?php
  $this->Html->addCrumb("Relatórios", '');
  $this->Html->addCrumb("Prioridade das Demandas", '/relatorios/prioridades');
?>

<div class="col-lg-12 page-header-box">
  <div class="col-lg-12">
    <h3 class="page-header">
      Prioridade das Demandas
      <span style="cursor:pointer;" onclick="javascript:$('div.panel-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
    </h3>
  </div>
</div>

<div class="row">
    <div class="col-lg-12 pull-left filters">
      <div class="">
        <div class="row">
          <span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">
            Filtros <i class="fa fa-plus-square"></i>
          </span>
        </div>
        <div class="row inner">
          <?php  echo $this->BootstrapForm->create(false, array('id' => "form-filter-results", 'class' => 'form-inline')); ?>
          <div class="col-lg-12">
            <div class="form-group">
              <?php
                  echo $this->BootstrapForm->input('servico_id', array(
                              'label' => array('text' => 'Serviço: '),
                              'class' => 'select2 form-control',
                              'selected' => $this->request->data['servico_id'],
                              'empty' => 'Serviço'));

                  $options = array( 1 => 'Sim', 0 => 'Não');
                  echo $this->BootstrapForm->input('origem_cliente', array(
                              'label' => array('text' => 'Solicitada pelo Cliente?: '),
                              'empty' => 'Solicitada pelo Cliente?',
                              'options' => $options));

                  echo $this->BootstrapForm->input('demanda_tipo_id', array(
                              'label' => array('text' => 'Tipo da Demanda: '),
                              'class' => 'select2 form-control',
                              'empty' =>  'Tipo'));

                  echo $this->BootstrapForm->input('user_id', array(
                         'class' => 'select2',
                         'label' => array('text' => 'Responsável: '),
                         /*'selected' => $this->Session->read('User.uid'),*/
                         'empty' => "Responsável"));
              ?>
            </div>
          </div>
          <?php
            echo $this->BootstrapForm->button("Filtrar <i class='fa fa-search'></i>", array('type' => 'submit', 'class' => 'control-label btn btn-default pull-right'));
            if(sizeof($filtro) > 0) $id = $filtro['Filtro']['id']; else $id = "'null'";
            echo $this->Filtros->btnSave("r_prioridades", $this->Session->read('User.uid'), $id);
            echo $this->BootstrapForm->end();
          ?>
        </div>
      </div>
    </div>
  </div>

<?php if(isset($demandas)): ?>
  <div class="row">
    <div class="col-lg-12 demandas">
      <div class="panel panel-default">
        <div class="panel-heading">
          <b>
            Prioridade das Demandas
          </b>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table display table-striped table-bordered table-hover" id="dataTables-dem">
              <thead>
                <tr>
                  <th><span class="editable">Prioridade</span></th>
                  <th>Demanda</th>
                  <th>Mantis</th>
                  <th>Título <i class="fa fa-comment-o" style="font-size: 15px !important;"></i></th>
                  <th>Título</th>
                  <th>Tipo</th>
                  <th><span class="editable">Status</span></th>
                  <th>Release</th>
                  <th>Prazo</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($demandas as $dem): ?>
                  <tr>
                    <td >
                      <span style="cursor:pointer;" title="Clique para alterar a prioridade!" id="<?php echo $dem['Demanda']['id']?>"><?php echo $dem['Demanda']['prioridade']; ?></span>
                    </td>
                    <?php echo $this->Tables->PrioridadeEditable($dem['Demanda']['id'], "demandas") ?>
                    <td style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!">
                      <?php
                        echo '<a id="viewClarity" href="https://projetos.dataprev.gov.br/niku/nu#action:pma.ideaProperties&id='. $dem['Demanda']['clarity_id'] .'" target="_blank">' . $dem['Demanda']['clarity_dm_id'] . '</a>'
                        /*echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                              $dem['Demanda']['clarity_id'] .")'>" . $dem['Demanda']['clarity_dm_id'] ."</a></span>"*/
                      ?>
                    </td>
                    <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Mantis!">
                      <?php echo $this->Html->link($dem['Demanda']['mantis_id'],"http://www-testes/view.php?id=" . $dem['Demanda']['mantis_id'], array('target' => '_blank')); ?>
                    </td>
                    <td><?php echo $this->Tables->popupBox($dem['Demanda']['nome'], $dem['Demanda']['descricao']) ?></td>
                    <td><?php echo $dem['Demanda']['nome']; ?></td>
                    <td>
                      <span style="border-bottom: 3px solid #<?php echo substr(md5($dem['DemandaTipo']['nome']), 0, 6) ?>;">
                        <?php echo $dem['DemandaTipo']['nome']; ?>
                      </span>
                    </td>
                    <td>
                      <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $dem['Demanda']['id'] ?>">
                        <?php echo $dem['Status']['nome']; ?>
                      </span>
                    </td>
                    <?php echo $this->Tables->DemandaStatusEditable($dem['Demanda']['id'], "demandas") ?>
                    <td>
                      <?php
                        if($dem['Rdm'])
                          foreach ($dem['Rdm'] as $r) {
                            if($r['Release'])
                              echo "<li>" . $r['Release']['versao'] . "</li>";
                          }
                      ?>
                    </td>
                    <td class="text-center">
                      <?php echo $this->Times->timeLeftTo($dem['Demanda']['data_cadastro'], $dem['Demanda']['dt_prevista'],
                               $dem['Demanda']['data_cadastro'] . " - " . $dem['Demanda']['dt_prevista'],
                              ($dem['Demanda']['data_homologacao']));
                      ?>
                    </td>
                    <td>
                      <?php
                        echo $this->Tables->getMenu('demandas', $dem['Demanda']['id'], 2);
                        echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $dem['Demanda']['id'] . ")'>
                          <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
                      ?>
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
<?php endif; ?>

<?php
  //-- ClarityID
  echo $this->Html->script('getIdClarity.js');

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');

  //-- DataTables JavaScript --
  echo $this->Html->script('plugins/dataTables/media/js/jquery.dataTables.js');
  echo $this->Html->script('plugins/dataTables/dataTables.bootstrap.js');
  echo $this->Html->css('plugins/dataTables.bootstrap.css');
  //-- DataTables --> TableTools
  echo $this->Html->script('plugins/dataTables/extensions/TableTools/js/dataTables.tableTools.min.js');
  echo $this->Html->css('plugins/dataTablesExtensions/TableTools/css/dataTables.tableTools.min.css');
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

  <script>
    <?php
      if(sizeof($filtro) > 0){
        $valor =  unserialize($filtro['Filtro']['valor']);
        echo "var filtro_array = " . json_encode($valor). ";";
      }
      echo $this->Filtros->camelCase();
    ?>

    $(document).ready(function() {
      <?php
        if(sizeof($filtro) > 0)
          echo $this->Filtros->fillFormB();
      ?>

      $('.select2').select2({
        language: "pt-BR",
        theme: "bootstrap"
      });

      $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'right', html: 'true'});

      var  oTable =   $('#dataTables-dem').dataTable({
          "lengthMenu": [[50, 25, 10, 100, -1], [50, 25, 10, 100, "Todos"]],
            language: {
              url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
            },
            "columnDefs": [  { "visible": false, "targets": 4 } ],
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
                      "mColumns": [ 0,1,2,4,5,6,7,8,9 ]
                  },
                  {
                      "sExtends": "csv",
                      "sButtonText": "CSV",
                      "sFileName": "Prioridades.csv",
                      "oSelectorOpts": { filter: 'applied', order: 'current' },
                      "mColumns": [ 0,1,2,4,5,6,7,8,9 ]
                  },
                  {
                      "sExtends": "pdf",
                      "sButtonText": "PDF",
                      "sFileName": "Prioridades - Demandas.pdf",
                      "oSelectorOpts": { filter: 'applied', order: 'current' },
                      "mColumns": [ 0,1,2,5,6,7,8,9 ],
                      "sPdfOrientation": "landscape",
                      "sTitle": "Prioridade das Demandas",
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

    function historico(id){
      document.getElementById('historicoFrame').src = "<?php echo(Router::url('/', true). "historicos/popup?controller=demandas&id=");?>" + id;
    }
  </script>

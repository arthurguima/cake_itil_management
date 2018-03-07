<?php
  $this->Html->addCrumb('Indisponibilidades', '/indisponibilidades');
?>
<div class="col-lg-12 page-header-box">
    <div class="col-lg-12">
      <h3 class="page-header">
        Controle de Disponibilidade
      </h3>
    </div>
</div>

<div class="row">
<div class="col-lg-12 pull-left filters">
  <div class="">
    <div class="row"><span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">Filtros <i class="fa fa-plus-square"></i></span></div>
    <div class="row inner" style="display: none;">
      <?php echo $this->Search->create("", array('class' => 'form-inline')); ?>
      <div class="col-lg-12 filters-item">
        <div class="form-group">
          <b>Data de Início: </b>
          <?php echo $this->Search->input('dtinicio',
                      array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                      array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
          ?>
          <b>Data de Término: </b>
          <?php echo $this->Search->input('dtfim',
                      array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                      array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
          ?>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="form-group"><?php echo $this->Search->input('numerof', array('class' => 'form-control', 'placeholder' => "Número")); ?></div>
        <div class="form-group"><?php echo $this->Search->input('motivo', array('class' => 'form-control')); ?></div>
        <div class="form-group"><?php echo $this->Search->input('servico', array('class' => 'select2 form-control')); ?></div>
        <div class="form-group"><?php echo $this->Search->input('encerrada', array('class' => 'select2 form-control')); ?></div>
      </div>
      <?php
        echo $this->Form->button("Filtrar <i class='fa fa-search'></i>", array('type' => 'submit',
                  'onclick' => 'javascript:if(oTable != null)oTable.fnDestroy();', 'class' => 'control-label btn btn-default pull-right'));
        if(sizeof($filtro) > 0) $id = $filtro['Filtro']['id']; else $id = "'null'";
        echo $this->Filtros->btnSave("indispon_index", $this->Session->read('User.uid'), $id);
        echo $this->Search->end();
      ?>
    </div>
  </div>
</div>
</div>

<?php if ($conditions):  ?>
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <b> Lista de Indisponibilidades </b>
          <div class="col-lg-2 pull-right">
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                 array('controller' => 'Indisponibilidades', 'action' => 'add'),
                 array('escape' => false));
              }
            ?>
          </div>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-Indisponibilidades">
              <thead>
                <tr>
                  <th>Serviço</th>
                  <th>Nº Evento   <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
                  <th>Nº Incidente   <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
                  <th>Início</th>
          				<th>Duração</th>
          				<th>Motivo/Ambiente</th>
                  <th>Observação</th>
                  <th>Observação</th>
          				<th><span class="editable">Status</span></th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($Indisponibilidades as $Indisponibilidade): ?>
                  <tr>
                    <td class="area-list">
                      <?php
                          foreach($Indisponibilidade['Servico'] as $servico):
                            echo $this->Html->link($servico['sigla'] . "  ",
                            array('controller' => 'servicos', 'action' => 'view', $servico['id']));
                          endforeach;
                      ?>
                    </td>
                    <td>
                      <?php
                        echo $this->Html->link($Indisponibilidade['Indisponibilidade']['num_evento'],
                              "http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH+FACTORY=in+SKIPLIST=1+QBE.IN.ref_num=" . $Indisponibilidade['Indisponibilidade']['num_evento'] . "%25",
                              array('target' => '_blank'));
                      ?>
                    </td>
                    <td>
                      <?php
                        echo $this->Html->link($Indisponibilidade['Indisponibilidade']['num_incidente'],
                              "http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH+FACTORY=in+SKIPLIST=1+QBE.IN.ref_num=" . $Indisponibilidade['Indisponibilidade']['num_incidente'] . "%25",
                              array('target' => '_blank'));
                      ?>
                    </td>
          				  <td data-order=<?php echo $this->Time->format('Ymd', $Indisponibilidade['Indisponibilidade']['dt_inicio']); ?>>
                      <?php echo $this->Time->format('d/m/Y H:i', $Indisponibilidade['Indisponibilidade']['dt_inicio']); ?>
                    </td>
                    <td>
                      <?php if($Indisponibilidade['Indisponibilidade']['dt_fim'] != null):
                              echo $this->Times->totalTime($Indisponibilidade['Indisponibilidade']['dt_inicio'],
                                                     $Indisponibilidade['Indisponibilidade']['dt_fim']);
                            endif;
                      ?>
                    </td>
          				  <td>
                      <?php echo $Indisponibilidade['Motivo']['nome']; ?><br />
                      <?php echo $this->Rdm->getAmbiente($Indisponibilidade['Motivo']['ambiente']); ?>
                    </td>
                    <td><?php echo $this->Tables->popupBox($Indisponibilidade['Indisponibilidade']['observacao']) ?></td>
                    <td><?php echo $Indisponibilidade['Indisponibilidade']['observacao']; ?></td>

                    <td id="<?php echo $Indisponibilidade['Indisponibilidade']['id']?>">
                      <?php
                        if($Indisponibilidade['Indisponibilidade']['dt_fim'] == null):
                          echo "<span class='label label-success'>Aberto</span>";
                        else:
                          echo "<span class='label label-default'>Fechado</span>";
                        endif;
                      ?>
                    </td>
                    <?php
                      if($Indisponibilidade['Indisponibilidade']['dt_fim'] == null)
                        echo $this->Tables->StatusEditable($Indisponibilidade['Indisponibilidade']['id'], "indisponibilidades");
                    ?>
                    <td>
                      <?php
                        echo $this->Tables->getMenu('Indisponibilidades', $Indisponibilidade['Indisponibilidade']['id'], 14);
                        echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $Indisponibilidade['Indisponibilidade']['id'] . ",\"indisponibilidades\")'>
                          <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
                      ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
                <?php unset($Indisponibilidade); ?>
              </tbody>
            </table>
          </div>
        </div>
        <ul class="list-group">
          <li class="list-group-item small red">
            * Lista limitada em 550 resultados.
          </li>
        </ul>
      </div>
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

<?php endif;?>

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

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');

  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');

  //-- Select2 --
  echo $this->Html->script('plugins/select2/select2.full.min');
  echo $this->Html->css('plugins/select2.min');
  echo $this->Html->css('plugins/select2-bootstrap.min');
  echo $this->Html->script('plugins/select2/pt-BR');
?>

<script>
  function historico(id, controller){
    document.getElementById('historicoFrame').src = "<?php echo(Router::url('/', true). "historicos/popup?");?>" + "controller=" + controller + "&id=" + id;
  }

  <?php
    if(sizeof($filtro) > 0){
      $valor =  unserialize($filtro['Filtro']['valor']);
      echo "var filtro_array = " . json_encode($valor). ";";
    }
    echo $this->Filtros->camelCase();
  ?>

  $(document).ready(function() {

    <?php
      if(!$conditions)
        echo "$('.filters > div > .inner').toggle();";

      if(sizeof($filtro) > 0)
        echo $this->Filtros->fillForm();;
    ?>

    $('.select2').select2({
      language: "pt-BR",
      theme: "bootstrap"
    });

    var  oTable =  $('#dataTables-Indisponibilidades').dataTable({
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
          language: {
            url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
          },
        //  responsive: true,
          "columnDefs": [  { "visible": false, "targets": 7 } ],
          "dom": 'TC<"clear">lfrtip',
          "order": [[ 3, "desc" ]],
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
                    "mColumns": [ 0,1,2,3,4,5,7,8 ]
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,5,7,8 ]
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "sFileName": "Indisponibilidades.csv",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,5,7,8 ]
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "sFileName": "Indisponibilidades.pdf",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,5,7,8 ],
                    "sPdfOrientation": "landscape",
                    "sTitle": "Controle de Disponibilidade",
                    "sPdfMessage": "Extraído em: <?php echo date('d/m/y')?>",
                },
              ]
          }
      });
      var colvis = new $.fn.dataTable.ColVis( oTable );

      $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'top'});

      $("[id*='filterDt']").datetimepicker({
        format: "yyyy-mm-dd",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
      });
  });
</script>

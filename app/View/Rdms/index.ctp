<?php
  $this->Html->addCrumb('Rdms', '/rdms');
?>
<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
         RDM - Requisições de Mudança
         <div class="col-lg-2 pull-right">
           <?php
            if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus'></i> Nova",
                array('controller' => 'rdms', 'action' => 'add'),
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
              <b>Data Prevista: </b>
              <?php echo $this->Search->input('dtprevista',
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
              ?>
            </div>
            <div class="form-group">
              <b>Data de Execução: </b>
              <?php echo $this->Search->input('dtexecutada',
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Início do período"),
                          array('class' => 'form-control', 'type' => 'text','placeholder' => "Fim"));
              ?>
            </div>
          </div>
          <div class="col-lg-12 filters-item">
            <div class="form-group"><?php echo $this->Search->input('nome_', array('class' => 'form-control', 'placeholder' => "Nome")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('responsavel_', array('class' => 'form-control', 'placeholder' => "Responsável")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('solicitante_', array('class' => 'form-control', 'placeholder' => "Solicitante")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('versao_', array('class' => 'form-control', 'placeholder' => "Versão")); ?></div>
            <div class="form-group"><?php echo $this->Search->input('numero_', array('class' => 'form-control', 'placeholder' => "Número")); ?></div>
          </div>
          <div class="col-lg-12">
            <div class="form-group"><?php echo $this->Search->input('servico', array('class' => 'select2 form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('ambiente_', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('concluida_', array('class' => 'form-control')); ?></div>
            <div class="form-group"><?php echo $this->Search->input('tipo', array('class' => 'form-control')); ?></div>
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
      <div class="panel-heading"><b> Lista de RDMs </b></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-rdm">
            <thead>
              <tr>
                <th>Servico</th>
                <th>Versão</th>
                <th>Ambiente</th>
                <th>Tipo</th>
                <th>Concluída?</th>
                <th>Nome <i class="fa fa-comment-o" style="font-size: 15px !important;"></th>
                <th>Nome</th>
                <th>Número  <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
                <th>Data Prevista</th>
                <th>Data de Execução</th>
                <th>Responsável</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rdms as $rdm): ?>
                <tr>
                  <td><?php echo $this->Html->link($rdm['Servico']['sigla'], array('controller' => 'servicos', 'action' => 'view', $rdm['Servico']['id'])); ?></td>
                  <td><?php echo $rdm['Rdm']['versao']; ?></td>
                  <td><?php echo $this->Rdm->getAmbiente($rdm['Rdm']['ambiente']); ?></td>
                  <td><?php echo $rdm['RdmTipo']['nome']; ?></td>
                  <td><?php echo $this->Rdm->sucesso($rdm['Rdm']['sucesso'], $rdm['Rdm']['dt_executada']); ?></a></td>
                  <td>
                    <?php
                      echo $this->Tables->popupBox(
                        $this->Html->link($rdm['Rdm']['nome'], array('controller' => 'rdms', 'action' => 'view', $rdm['Rdm']['id'])),
                        $rdm['Rdm']['observacao']
                      );
                    ?>
                  </td>
                  <td><?php echo $rdm['Rdm']['nome']; ?></td>
                  <td>
                    <?php
                      echo $this->Html->link($rdm['Rdm']['numero'],
                            "http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH+SKIPLIST=1+FACTORY=chg+QBE.EQ.chg_ref_num=" . $rdm['Rdm']['numero'],
                            array('target' => '_blank'));
                    ?>
                  </td>
                  <td data-order=<?php echo $this->Times->CleanDate($rdm['Rdm']['dt_prevista']); ?>>
                    <?php echo $this->Times->pastDate($rdm['Rdm']['dt_prevista']); ?>
                  </td>
                  <td>
                    <?php
                      //TODO: refatorar essa lógica
                      if($rdm['Rdm']['sucesso'] == 2)
                        echo $this->Rdm->sucesso($rdm['Rdm']['sucesso'], $rdm['Rdm']['dt_executada']);
                      else
                        echo (($rdm['Rdm']['dt_executada'] == null) ? " " : $this->Times->pastDate($rdm['Rdm']['dt_executada']));
                    ?>
                  </td>
                  <td><div class="sub-17"><?php echo $rdm['Rdm']['responsavel']; ?></div></td>
                  <td>
                    <?php
                      echo $this->Tables->getMenu('rdms', $rdm['Rdm']['id'], 14);
                      echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $rdm['Rdm']['id'] . ")'>
                        <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
              <?php unset($rdm); ?>

            </tbody>
          </table>
        </div>
      </div>
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

<?php
//-- DataTables JavaScript -->
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

    var  oTable =  $('#dataTables-rdm').dataTable({
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
          language: {
            url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
          },
          "columnDefs": [  { "visible": false, "targets": 6 } ],
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
                    "mColumns": [ 0,1,2,3,4,6,7,8,9,10 ]
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,6,7,8,9,10 ]
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "sFileName": "RDM.csv",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,6,7,8,9,10 ]
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "sFileName": "RDM.pdf",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,7,8,9,10 ],
                    "sPdfOrientation": "landscape",
                    "sTitle": "Requisições de Mudança",
                    "sPdfMessage": "<?php echo date('d/m/y')?>",
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
  });

  function historico(id){
    document.getElementById('historicoFrame').src = "<?php echo(Router::url('/', true). "historicos/popup?controller=rdms&id=");?>" + id;
  }
</script>

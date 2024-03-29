<?php
  $this->Html->addCrumb('Rdms', '/rdms');
?>
<div class="col-lg-12 page-header-box">
    <div class="col-lg-12">
      <h3 class="page-header">
         RDM - Requisições de Mudança
      </h3>
    </div>
</div>

<div class="row">
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
          <div class="form-group"><?php echo $this->Search->input('cliente', array('class' => 'select2 form-control')); ?></div>
          <div class="form-group"><?php echo $this->Search->input('nomef', array('class' => 'form-control', 'placeholder' => "Nome")); ?></div>
          <div class="form-group"><?php echo $this->Search->input('responsavelf', array('class' => 'form-control select2', 'placeholder' => "Responsável")); ?></div>
          <div class="form-group"><?php echo $this->Search->input('solicitantef', array('class' => 'form-control', 'placeholder' => "Solicitante")); ?></div>
          <div class="form-group"><?php echo $this->Search->input('versaof', array('class' => 'form-control', 'placeholder' => "Versão")); ?></div>
          <div class="form-group"><?php echo $this->Search->input('numerof', array('class' => 'form-control', 'placeholder' => "Número")); ?></div>
        </div>
        <div class="col-lg-12">
          <div class="form-group"><?php echo $this->Search->input('servico', array('class' => 'select2 form-control')); ?></div>
          <div class="form-group"><?php echo $this->Search->input('ambientef', array('class' => 'select2 form-control')); ?></div>
          <div class="form-group"><?php echo $this->Search->input('concluidaf', array('class' => 'form-control')); ?></div>
          <div class="form-group"><?php echo $this->Search->input('tipo', array('class' => 'select2 form-control')); ?></div>
        </div>
        <?php
          echo $this->Form->button("Filtrar <i class='fa fa-search'></i>", array('type' => 'submit',
                          'onclick' => 'javascript:if(oTable != null)oTable.fnDestroy();', 'class' => 'control-label btn btn-default pull-right'));

          if(sizeof($filtro) > 0) $id = $filtro['Filtro']['id']; else $id = "'null'";
          echo $this->Filtros->btnSave("rdms_index", $this->Session->read('User.uid'), $id);
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
          <b> Lista de RDMs </b>
          <div class="col-lg-2 pull-right">
            <?php
             if($this->Ldap->autorizado(2)){
                 echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                 array('controller' => 'rdms', 'action' => 'add'),
                 array('escape' => false));
             }
            ?>
          </div>
        </div>
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
                  <th>Execução</th>
                  <th>CheckList</th>
                  <th>Responsável</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($rdms as $rdm): ?>
                  <tr>
                    <td><?php echo $this->Html->link($rdm['Servico']['sigla'], array('controller' => 'servicos', 'action' => 'view', $rdm['Servico']['id'])); ?></td>
                    <td ><div class="sub-17" style="font-size: 10px;"><?php echo $rdm['Rdm']['versao']; ?></div></td>
                    <td><?php echo $this->Rdm->getAmbiente($rdm['Rdm']['ambiente']); ?></td>
                    <td><div class="sub-17" style="font-size: 10px;"><?php echo $rdm['RdmTipo']['nome']; ?></div></td>
                    <td><?php echo $this->Rdm->sucesso($rdm['Rdm']['sucesso'], $rdm['Rdm']['dt_executada']); ?></a></td>
                    <td class="sub-20">
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
                              "http://www-sdm14/CAisd/pdmweb.exe?OP=SEARCH+SKIPLIST=1+FACTORY=chg+QBE.EQ.chg_ref_num=" . $rdm['Rdm']['numero'],
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

                    <td>
                      <ul style="font-size:9px; margin: 0; padding: 0; font-size: 10px; list-style: none;">
                        <li>
                          <b>CAB</b>
                          <span id="<?php echo "rdm-cab_approval-" . $rdm['Rdm']['id']?>">
                            <?php echo $this->Rdm->getCheck($rdm['Rdm']['cab_approval']); ?>
                          </span>
                        </li>
                        <li>
                          <b>Autorizada</b>
                          <span id="<?php echo "rdm-autorizada-" . $rdm['Rdm']['id']?>">
                            <?php echo $this->Rdm->getCheck($rdm['Rdm']['autorizada']); ?>
                          </span>
                        </li>
                        <li>
                          <b>FARM</b>
                          <span id="<?php echo "rdm-farm-" . $rdm['Rdm']['id']?>">
                            <?php echo $this->Rdm->getCheck($rdm['Rdm']['farm']); ?>
                          </span>
                        </li>
                      <ul>
                    </td>
                    <?php
                      echo $this->Tables->RdmCheckEditable($rdm['Rdm']['id'], "rdms", 'cab_approval');
                      echo $this->Tables->RdmCheckEditable($rdm['Rdm']['id'], "rdms", "autorizada");
                      echo $this->Tables->RdmCheckEditable($rdm['Rdm']['id'], "rdms", "farm");
                    ?>

                    <td><div class="sub-17"><?php echo $rdm['User']['nome']; ?></div></td>
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
        <ul class="list-group">
    			<li class="list-group-item small red">
            * Lista de RDMs limitada em 450 registros.
          </li>
          <li class="list-group-item small red">
            * Você também pode utilizar o Calendário para uma melhor visualização.
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
<?php endif; ?>

<?php
//-- Jeditable
echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');

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
      if(!$conditions)
        echo "$('.filters > div > .inner').toggle();";

      if(sizeof($filtro) > 0)
        echo $this->Filtros->fillForm();;
    ?>

    $('.select2').select2({
      language: "pt-BR",
      theme: "bootstrap"
    });

    <?php if($conditions): ?>
      var  oTable =  $('#dataTables-rdm').dataTable({
          "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
            language: {
              url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
            },
            "columnDefs": [  { "visible": false, "targets": 6 } ],
            "dom": 'TC<"clear">lfrtip',
            "order": [[ 8, "desc" ]],
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
      <?php endif; ?>

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

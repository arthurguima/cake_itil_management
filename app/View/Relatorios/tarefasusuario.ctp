<?php
  $this->Html->addCrumb("Relatórios", '');
  $this->Html->addCrumb("Tarefas", '/relatorios/tarefasusuario');
?>

<div class="col-lg-12 page-header-box">
  <div class="col-lg-12">
    <h3 class="page-header">
      Tarefas do Usuário
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
          <div class="col-lg-12 filters-item">
            <div class="form-group">
              <?php
                echo $this->BootstrapForm->input('user_id', array(
                        'label' => array('text' => 'Usuário: '),
                        'class' => 'select2 form-control',
                        'empty' => 'Usuário'));

                echo $this->BootstrapForm->input('servico_id', array(
                        'label' => array('text' => 'Serviço: '),
                        'class' => 'select2 form-control',
                        'empty' => 'Serviço'));

                $options = array( 2 => 'Aguardando Início', 1 => 'Finalizada', 0 => 'Em andamento');
                echo $this->BootstrapForm->input('check', array(
                            'label' => array('text' => 'Finalizada?:  '),
                            'empty' => 'Status',
                            'options' => $options));
              ?>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="form-group">
              <?php
                echo $this->BootstrapForm->input('dt_inicio', array(
                            'type' => 'text',
                            'label' => array('text' => 'Data Prevista maior/igual a:'),
                            'id' => 'dp ',
                            'value' => $this->params['url']['dt_inicio']));
              ?>
              <?php
                echo $this->BootstrapForm->input('dt_fim', array(
                            'type' => 'text',
                            'label' => array('text' => 'Data Prevista menor/igual a:'),
                            'id' => 'dp ',
                            'value' => $this->params['url']['dt_fim']));
              ?>
            </div>
          </div>
          <?php
            echo $this->BootstrapForm->button("Filtrar <i class='fa fa-search'></i>", array('type' => 'submit', 'class' => 'control-label btn btn-default pull-right'));
            if(sizeof($filtro) > 0) $id = $filtro['Filtro']['id']; else $id = "'null'";
            echo $this->Filtros->btnSave("r_tarefasusuario", $this->Session->read('User.uid'), $id);
            echo $this->BootstrapForm->end();
          ?>
        </div>
      </div>
    </div>
</div>

<?php if($pesquisa): ?>
  <div class="row">
    <div class="col-lg-12">
      <div role="tabpanel" class="tab-pane" id="versoes">
        <div class="error">
          <div class="well">            
            <div class="panel-body">
              <div class="table-responsive">
  							<table class="table table-striped table-bordered table-hover" id="dataTables-subtarefas">
  								<thead>
  									<tr>
  										<th>Servico</th>
  										<th>Atividade</th>
  										<th>Tarefa</th>
  										<th>Prazo</th>
  										<th><span class="editable">Status</span></th>
                      <th>Responsavel</th>
  										<th>Ações</th>
  									</tr>
  								</thead>
  								<tbody>
  									<?php foreach ($subtarefas as $sub): ?>
  										<tr>
  											<td><?php echo $sub['Servico']['sigla'] ?></td>
  											<td>
  												<?php
  													if(isset($sub['Demanda']['clarity_dm_id']))
  														echo $this->Html->link($sub['Demanda']['clarity_dm_id'],array('controller' => 'Demandas', 'action' => 'view', $sub['Demanda']['id']));
  													elseif(isset($sub['Chamado']['numero']))
  														echo $this->Html->link("Chamado: " . $sub['Chamado']['numero'] . "/" . $sub['Chamado']['ano'], array('controller' => 'Chamados', 'action' => 'view', $sub['Chamado']['id']));
  													elseif(isset($sub['Rdm']['numero']))
  														echo $this->Html->link("RDM: " . $sub['Rdm']['numero'] . "/" . $sub['Rdm']['ano'], array('controller' => 'rdms', 'action' => 'view', $sub['Rdm']['id']));
  													elseif(isset($sub['Release']['id']))
  														echo $this->Html->link("Release: " . $sub['Release']['versao'], array('controller' => 'releases', 'action' => 'view', $sub['Release']['id']));
  													else
  														echo " --- ";
  												?>
  											</td>
  											<td><?php echo $sub['Subtarefa']['descricao']; ?></td>
  											<td class="text-center">
                          <?php
                            echo $this->Subtarefas->timeLeftTo($sub['Subtarefa']['created'], $sub['Subtarefa']['dt_prevista'], $sub['Subtarefa']['check'], $sub['Subtarefa']['dt_inicio'], $sub['Subtarefa']['dt_fim']);
                          ?>
  		                  </td>
  											<td id="<?php echo "sub-" . $sub['Subtarefa']['id']?>">
                          <?php
  													echo $this->Subtarefas->status($sub['Subtarefa']['check']);
  												?>
  											</td>
  											<?php
  												echo $this->Tables->SubtarefaStatusEditable($sub['Subtarefa']['id'], "subtarefas");
  											?>
                        <td>
                          <?php echo $sub['User']['nome']; ?>
                        </td>
  											<td>
  												<?php echo $this->Tables->getMenu('Subtarefas', $sub['Subtarefa']['id'],12); ?>
  											</td>
  										</tr>
  									<?php endforeach; ?>
  									<?php unset($sub); ?>
  								</tbody>
  							</table>
  						</div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php else: ?>

  <div class="col-lg-6">
    <div class="error">
      <div class="well">
        <h3 class="page-header">Como Funciona o relatório?</h3>
        <ul>
          <li> É necessário preencher pelo menos o campo <b>'Data Prevista maior/igual a:'</b> para que pesquisa seja feita.</li>
        </ul>
      </div>
    </div>
  </div>

<?php endif; ?>

<?php
//-- Select2 --
echo $this->Html->script('plugins/select2/select2.full.min');
echo $this->Html->css('plugins/select2.min');
echo $this->Html->css('plugins/select2-bootstrap.min');
echo $this->Html->script('plugins/select2/pt-BR');

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');

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
  <?php
    if(sizeof($filtro) > 0){
      $valor =  unserialize($filtro['Filtro']['valor']);
      echo "var filtro_array = " . json_encode($valor). ";";
    }
    echo $this->Filtros->camelCase();
  ?>

  $(document).ready(function() {

    $("[id*='dp']").datetimepicker({
      format: 'dd/mm/yyyy',
      minView: 2,
      autoclose: true,
      todayBtn: true,
      language: 'pt-BR'
    });

    <?php
      if(sizeof($filtro) > 0)
        echo $this->Filtros->fillFormB();
    ?>

    $('.select2').select2({
      language: "pt-BR",
      theme: "bootstrap"
    });

    <?php if($pesquisa): ?>
    var  oTable =  $('#dataTables-subtarefas').dataTable({
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
          language: {
            url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
          },
          "dom": 'TC<"clear">lfrtip',
          "order": [[ 1, "desc" ]],
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
                    "mColumns": [ 0,1,2,3,4,5 ]
                },
                {
                    "sExtends": "print",
                    "sButtonText": "Imprimir",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,5 ]
                },
                {
                    "sExtends": "csv",
                    "sButtonText": "CSV",
                    "sFileName": "Tarefas.csv",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,5 ]
                },
                {
                    "sExtends": "pdf",
                    "sButtonText": "PDF",
                    "sFileName": "Tarefas.pdf",
                    "oSelectorOpts": { filter: 'applied', order: 'current' },
                    "mColumns": [ 0,1,2,3,4,5 ],
                    "sPdfOrientation": "landscape",
                    "sTitle": "Lista de Tarefas",
                    "sPdfMessage": "<?php echo date('d/m/y')?>",
                },
              ]
          }
      });
      var colvis = new $.fn.dataTable.ColVis( oTable );
    <?php endif; ?>
  });
</script>

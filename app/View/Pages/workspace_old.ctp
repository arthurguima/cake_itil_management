<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Bem-vindo, <?php echo $this->Session->read('User.nome'); ?>!</h3>
		</div>
</div>

<div class="row">
<?php if($this->Session->read('User.uid') != 0): ?>
	<div class="col-lg-12  row-nav-tabs">
		<ul class="nav nav-tabs nav-tabs-black nav-tabs-pages" role="tablist">
			<li role="presentation" class="active tab-spaced"><a href="#sses" aria-controls="sses" role="tab" data-toggle="tab" style="background-color: rgba(204, 204, 204, 0.32);">
				SS <span class="badge"><?php echo sizeof($sses) ?></span></a>
			</li>
			<li role="presentation" class="tab-deactivated"><a href="#pes" aria-controls="pes" role="tab" data-toggle="tab" style="background-color: rgba(204, 204, 204, 0.32);">
				PA <span class="badge"><?php echo sizeof($pes) ?></span></a>
			</li>
			<li role="presentation" class="tab-deactivated"><a href="#ords" aria-controls="ords" role="tab" data-toggle="tab" style="background-color: rgba(204, 204, 204, 0.32);">
				OS <span class="badge"><?php echo sizeof($ords) ?></span></a>
			</li>
		</ul>
	</div>

	<div class="tab-content">
		<!-- SSes -->
		<div role="tabpanel" class="tab-pane active" id="sses">
		  <div class="col-lg-12">
		    <div class="panel panel-workspace">
		      <div class="panel-heading">
						<b> Lista de SS</b>
	           <?php
	              if($this->Ldap->autorizado(2)){
	                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
	                array('controller' => 'sses', 'action' => 'add'),
	                array('escape' => false));
	              }
	           ?>
	        </div>
		      <div class="panel-body">
		        <div class="table-responsive">
		          <table class="table table-striped table-bordered table-hover" id="dataTables-ss">
		            <thead>
		              <tr>
		                <th>Servico</th>
		                <th class="hidden-xs hidden-sm"><span class="editable">Prioridade</span></th>
		                <th class="hidden-xs hidden-sm">DM Clarity <i class='fa-expand fa' style="font-size: 15px !important;"></i></th>
		                <th>Número</th>
		                <th>Nome <i class="fa fa-comment-o" style="font-size: 15px !important;"></th>
		                <th>Nome</th>
		                <th>Prazo</th>
		                <th class="hidden-xs hidden-sm"><span class="editable">Status</span></th>
		                <th class="hidden-xs hidden-sm">CheckList <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
		                <th>Ações</th>
		              </tr>
		            </thead>
		            <tbody>
		              <?php foreach ($sses as $ss): ?>
		                <tr>
		                  <td><?php echo $this->Html->link($ss['Servico']['sigla'], array('controller' => 'servicos', 'action' => 'view', $ss['Servico']['id'])); ?></td>
		                  <td class="hidden-xs hidden-sm">
		                    <span style="cursor:pointer;" title="Clique para alterar a prioridade!" id="<?php echo $ss['Ss']['id'];?>"><?php echo $ss['Ss']['prioridade']; ?></span>
		                  </td>
		                  <?php echo $this->Tables->PrioridadeEditable($ss['Ss']['id'], "sses") ?>

		                  <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!">
		                      <?php echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
		                                 $ss['Ss']['clarity_id'] .")'>" . $ss['Ss']['clarity_dm_id'] ."</a></span>" ?>
		                  </td>

		                  <td data-order=<?php echo $ss['Ss']['ano'] . $ss['Ss']['numero']; ?>>
		                    <?php echo $ss['Ss']['numero'] . "/" . $ss['Ss']['ano'] ; ?>
		                  </td>
		                  <td><?php echo $this->Tables->popupBox($ss['Ss']['nome'], $ss['Ss']['observacao']) ?></td>
		                  <td><?php echo $ss['Ss']['nome']; ?></td>

		                  <td class="text-center">
		                    <?php echo $this->Times->timeLeftTo($ss['Ss']['dt_recebimento'], $ss['Ss']['dt_prazo'],
		                             $ss['Ss']['dt_recebimento'] . " - " . $ss['Ss']['dt_prazo'],
		                            ($ss['Ss']['dt_finalizada']));
		                    ?>
		                  </td>

		                  <td class="hidden-xs hidden-sm">
		                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $ss['Ss']['id'] ?>">
		                    <?php echo $ss['Status']['nome']; ?></span>
		                  </td>
		                  <?php echo $this->Tables->SsStatusEditable($ss['Ss']['id']) ?>

		                  <td class="checklist hidden-xs hidden-sm"><?php echo $this->Ss->getCheckList($ss['Ss']['dv'], $ss['Ss']['contagem']) ?></td>
		                  <td>
		                    <?php
		                      echo $this->Tables->getMenu('sses', $ss['Ss']['id'], 14);
		                      echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $ss['Ss']['id'] . ",\"sses\")'>
		                        <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
		                    ?>
		                  </td>
		                </tr>
		              <?php endforeach; ?>
		              <?php unset($ss); ?>

		            </tbody>
		          </table>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- PE -->
		<div role="tabpanel" class="tab-pane" id="pes">
			<div class="col-lg-12">
		    <div class="panel panel-workspace">
		      <div class="panel-heading">
						<b> Lista de PA </b>
					</div>
		      <div class="panel-body">
		        <div class="table-responsive">
		          <table class="table table-striped table-bordered table-hover" id="dataTables-pes">
		            <thead>
		              <tr>
		                <th>Serviço</th>
		                <th>Número da PA <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
		                <th>Número da CE</th>
		                <th>Nome da SS <i class="fa fa-comment-o" style="font-size: 15px !important;"></i></th>
		                <th>Nome da SS</i></th>
		                <th>Validade do PDD</th>
		                <th><span class="editable">Status</span></th>
		                <th>Ações</th>
		              </tr>
		            </thead>
		            <tbody>
		              <?php foreach ($pes as $pe): ?>
		                <tr>
		                  <td><?php echo $pe['Servico']['sigla']; ?></td>
		                  <td data-order=<?php echo $pe['Pe']['ano'] . $pe['Pe']['numero']; ?>>
		                    <?php echo $this->Html->link(($pe['Pe']['numero'] . "/" . $pe['Pe']['ano']), $pe['Pe']['cvs_url']); ?>
		                  </td>
		                  <td><?php echo $pe['Pe']['num_ce']; ?></td>
		                  <td>
		                    <?php
		                      echo $this->Html->link($this->Tables->popupBox($pe['Ss']['nome'],$pe['Ss']['observacao']),
		                           array('controller' => 'sses', 'action' => 'view', $pe['Ss']['id']), array('escape' => false)); ?>
		                  </td>
		                  <td><?php echo $pe['Ss']['nome']; ?></td>
		                  <td data-order=<?php echo $this->Times->CleanDate($pe['Pe']['validade_pdd']); ?>>
		                    <?php
		                      if($pe['Pe']['validade_pdd'] != null){
		                        echo $this->Times->pastDate($pe['Pe']['validade_pdd']);
		                      }
		                    ?>
		                  </td>
		                  <td>
		                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "statuspa-" . $pe['Pe']['id'] ?>">
		                    <?php echo $pe['Status']['nome']; ?></span>
		                  </td>
		                  <?php echo $this->Tables->PeStatusEditable($pe['Pe']['id']) ?>
		                  <td>
		                    <?php
		                      echo $this->Tables->getMenu('pes', $pe['Pe']['id'], 14);
		                      echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $pe['Pe']['id'] . ")'>
		                        <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
		                    ?>
		                  </td>
		                </tr>
		              <?php endforeach; ?>
		              <?php unset($pe); ?>

		            </tbody>
		          </table>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- ORDs -->
		<div role="tabpanel" class="tab-pane" id="ords">
		  <div class="col-lg-12">
		    <div class="panel panel-workspace">
		      <div class="panel-heading"><b> Lista de OS </b></div>
		      <div class="panel-body">
		        <div class="table-responsive">
		          <table class="table table-striped table-bordered table-hover" id="dataTables-ords">
		            <thead>
		              <tr>
		                <th>Serviço</th>
		                <th>Número <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
		                <th>Nome da SS <i class="fa fa-comment-o" style="font-size: 15px !important;"></i></th>
		                <th>Nome da SS</i></th>
		                <th>Prazo</th>
		                <th><span class="editable">Status</span></th>
		                <th>Termos <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
		                <th>Ações</th>
		              </tr>
		            </thead>
		            <tbody>
		              <?php foreach ($ords as $ord): ?>
		                <tr>
		                  <td><?php echo $ord['Servico']['sigla']; ?></td>
		                  <td data-order=<?php echo $ord['Ord']['ano'] . $ord['Ord']['numero']; ?>>
		                    <?php echo $this->Html->link($ord['Ord']['numero'] . "/" . $ord['Ord']['ano'], $ord['Ord']['cvs_url']); ?>
		                  </td>
		                  <td>
		                    <?php
		                      echo $this->Html->link($this->Tables->popupBox($ord['Ss']['nome'],$ord['Ss']['observacao']),
		                           array('controller' => 'sses', 'action' => 'view', $ord['Ss']['id']), array('escape' => false)); ?>
		                  </td>
		                  <td><?php echo $ord['Ss']['nome']; ?></td>
		                  <td class="text-center">
		                    <?php
		                      if($ord['Ord']['dt_ini_pdd'] != null){
		                        echo $this->Times->timeLeftTo($ord['Ord']['dt_ini_pdd'], $ord['Ord']['dt_fim_pdd'],
		                              $ord['Ord']['dt_ini_pdd'] . " - " . $ord['Ord']['dt_fim_pdd'],
		                              ($ord['Ord']['dt_homologacao']));
		                      }
		                    ?>
		                  </td>

		                  <td>
		                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "statusos-" . $ord['Ord']['id'] ?>">
		                    <?php echo $ord['Status']['nome']; ?></span>
		                  </td>
		                  <?php echo $this->Tables->OrdStatusEditable($ord['Ord']['id']) ?>

		                  <td class="checklist">
		                    <?php
		                      echo $this->Ord->getCheckList($ord['Ord']['ths'], $ord['Ord']['trp'], $ord['Ord']['trd']) . "<br />";
		                      if(isset($ord['Ord']['dt_homologacao']))
		                        echo $this->Ord->PrazocheckList($ord['Ord']['dt_homologacao'], $ord['Ord']['trp'], $ord['Ord']['dt_recebimento_termo_prov'],
		                           $ord['Ord']['ths'], $ord['Ord']['dt_recebimento_homo'],
		                           $ord['Ord']['trd'], $ord['Ord']['dt_recebimento_termo']);
		                    ?>
		                  </td>
		                  <td>
		                    <?php
		                      echo $this->Tables->getMenu('ords', $ord['Ord']['id'], 14);
		                      echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $ord['Ord']['id'] . ")'>
		                        <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
		                    ?>
		                  </td>
		                </tr>
		              <?php endforeach; ?>
		              <?php unset($ord); ?>

		            </tbody>
		          </table>
		        </div>
		      </div>
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
<?php else:  ?>
<div class="container">
	<div class="error">
		<div class="well">
			<h3 class="page-header"><i class="fa red fa-user-times"></i> Usuário não encontrado no SGS </h3>
			<br />
			<h4>Tente um dos seguintes procedimentos:</h4>
			<div class="well">
				<ul class="list-unstyled spaced">
					<li>
						<i class="ace-icon fa fa-hand-o-right blue"></i>
						Recarregue a página. Sua sessão pode ter expirado.
					</li>

					<li>
						<i class="ace-icon fa fa-hand-o-right blue"></i>
						Entre em Contato com os administradores do SGS para criar o seu cadastro.
					</li>

				</ul>
				<br />
				<b>Veja o que você está perdendo ao não usar o nosso workspace:</b>
				<?php echo $this->Html->image('workspace.png', array('alt' => 'Visualização do workspace', 'class' => "img-responsive", 'style' => 'margin-top:10px;')); ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

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

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');

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
	$('a[aria-controls="ords"]').on('shown.bs.tab', function (e) {
		if(typeof oTableOrd == 'undefined'){
			oTableOrd =  $('#dataTables-ords').dataTable({
				"lengthMenu": [[25, 15, 50, -1], [25, 15, 50, "Todos"]],
					language: {
						url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
					},
					"columnDefs": [  { "visible": false, "targets": 3 } ],
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
										"mColumns": [ 0,1,3,4,5,6]
								},
								{
										"sExtends": "print",
										"sButtonText": "Imprimir"
								},
								{
										"sExtends": "csv",
										"sButtonText": "CSV",
										"sFileName": "Ordens de Serviço.csv",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"mColumns": [ 0,1,3,4,5,6]
								},
								{
										"sExtends": "pdf",
										"sButtonText": "PDF",
										"sFileName": "Ordens de Serviço.pdf",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"sPdfOrientation": "landscape",
										"mColumns": [ 0,1,3,4,5,6],
										"sTitle": "Listagem de Ordens de Serviço",
										"sPdfMessage": "Extraído em: <?php echo date('d/m/y')?>",
								},
							]
					}
			});
			var colvis = new $.fn.dataTable.ColVis( oTableOrd );
		}
	});

	$('a[aria-controls="pes"]').on('shown.bs.tab', function (e) {
			if(typeof oTablepes == 'undefined'){
				oTablepes = $('#dataTables-pes').dataTable({
				"lengthMenu": [[25, 15, 50, -1], [25, 15, 50, "Todos"]],
					language: {
						url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
					},
					"columnDefs": [  { "visible": false, "targets": 4 } ],
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
										"mColumns": [ 0,1,2,4,5,6 ]
								},
								{
										"sExtends": "print",
										"sButtonText": "Imprimir"
								},
								{
										"sExtends": "csv",
										"sButtonText": "CSV",
										"sFileName": "Propostas de Atendimento.csv",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"mColumns": [ 0,1,2,4,5,6 ]
								},
								{
										"sExtends": "pdf",
										"sButtonText": "PDF",
										"sFileName": "Propostas de Atendimento.pdf",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"sPdfOrientation": "landscape",
										"mColumns": [ 0,1,2,4,5,6 ],
										"sTitle": "Listagem de Propostas de Atendimento",
										"sPdfMessage": "<?php echo date('d/m/y')?>",
								},
							]
					}
			});
			var colvis = new $.fn.dataTable.ColVis( oTablepes );
		}
	});

	$('a[aria-controls="sses"]').on('shown.bs.tab', function (e) {
		if(typeof oTablesses == 'undefined'){
		 	oTablesses =  $('#dataTables-ss').dataTable({
	      "lengthMenu": [[25, 15, 50, -1], [25, 15, 50, "Todos"]],
	        language: {
	          url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
	        },
	        "columnDefs": [  { "visible": false, "targets": 5 } ],
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
	                  "mColumns": [ 0,1,2,3,5,6,7,8 ]
	              },
	              {
	                  "sExtends": "print",
	                  "sButtonText": "Imprimir",
	                  "oSelectorOpts": { filter: 'applied', order: 'current' },
	                  "mColumns": [ 0,1,2,3,5,6,7,8 ]
	              },
	              {
	                  "sExtends": "csv",
	                  "sButtonText": "CSV",
	                  "sFileName": "SS.csv",
	                  "oSelectorOpts": { filter: 'applied', order: 'current' },
	                  "mColumns": [ 0,1,2,3,5,6,7,8 ]
	              },
	              {
	                  "sExtends": "pdf",
	                  "sButtonText": "PDF",
	                  "sFileName": "SS.pdf",
	                  "oSelectorOpts": { filter: 'applied', order: 'current' },
	                  "sPdfOrientation": "landscape",
	                  "mColumns": [ 0,1,2,3,6,7,8 ],
	                  "sTitle": "Listagem de Solicitações de Serviço",
	                  "sPdfMessage": "<?php echo date('d/m/y')?>",
	              },
	            ]
	        }
	    });
	    var colvis = new $.fn.dataTable.ColVis( oTablesses );
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
      });
	});

  function historico(id, controller){
    document.getElementById('historicoFrame').src = "<?php echo(Router::url('/', true). "historicos/popup?");?>" + "controller=" + controller + "&id=" + id;
  }
</script>

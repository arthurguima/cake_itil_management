<div class="row">
		<div class="col-lg-12"><h3 class="page-header">Bem Vindo ao SGD! - <?php echo $this->Ldap->nomeUsuario(); ?></h3></div>
</div>

<div class="row">

	<!-- Serviços Online -->
	<div class="col-lg-3 col-md-12 pull-right col-sm-12 delete-online">
		<div class="panel panel-default">
			<div class="panel-heading">
				<p>
					<h3 class="panel-title">
						<b>Serviços Online:</b>
						<?php echo $this->Html->link('<i class="fa fa-refresh pull-right"></i>', 'javascript:refreshCode();', array('escape' => false)); ?>
						<span style="cursor:pointer;" onclick="javascript:$('div.delete-online').remove();"><i class="fa fa-trash-o pull-right"></i></span>
					</h3>
				</p>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked" id="refresh">
						<div class="col-md-6 col-md-offset-4"><?php echo $this->Html->image('loading.gif', array('alt' => 'Carregando', 'width' => '50%')); ?></div>
				</ul>
			</div>
		</div>
	</div>

	<!-- Estimativa de Disponibildidade -->
	<div class="col-lg-9 col-md-12 col-sm-12 pull-left delete-indis">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<p><h3 class="panel-title"><b><i class="fa fa-clock-o" style="font-size: 20px;"></i> <span>Estimativa de Disponibilidade</b> - Período
					<?php
						if(date("d") < 21){
							$init = "21/" . date("m/Y",strtotime("-1 month"));
							$end = "20/" . date('m/Y');
							echo $init . " a " . $end;
							echo $this->Html->link('<i class="fa-external-link-square fa pull-right"></i>',
									"http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH&FACTORY=in&QBE.EQ.active=1&QBE.IN.affected_service.name=%25MTE%25&QBE.GE.outage_start_time=21%2F" .
									date("m",strtotime("-1 month")) .
									"%2F" . date('Y') ."%2000%3A00%3A00&QBE.LE.outage_start_time=20%2F" . date('m') . "%2F" . date('Y') ."%2023%3A59%3A59",
									array('escape' => false, 'target' => '_blank' ));
						}
						else{
							$init = "21/" . date('m/Y');
							$end = "20/" . date("m/Y",strtotime("+1 month"));
							echo $init . " a " . $end;
							echo $this->Html->link('<i class="fa-external-link-square fa pull-right"></i>',
									"http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH&FACTORY=in&QBE.EQ.active=1&QBE.IN.affected_service.name=%25MTE%25&QBE.GE.outage_start_time=21%2F" .
									date('m') .
									"%2F" . date('Y') ."%2000%3A00%3A00&QBE.LE.outage_start_time=20%2F" . date('m',strtotime("+1 month")) . "%2F" . date('Y') ."%2023%3A59%3A59",
									array('escape' => false, 'target' => '_blank' ));
						}
					?></span>
					<span style="cursor:pointer;" onclick="javascript:$('div.panel-body.indisponibilidades-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
					<span style="cursor:pointer;" onclick="javascript:$('div.delete-indis').remove();"><i class="fa fa-trash-o pull-right"></i></span>
				</h3></p>
			</div>
			<div class="panel-body indisponibilidades-body">
				<ul class="nav nav-tabs nav-tabs-black cliente" role="tablist" id="abasIndi">
						<?php
							$active = true;
							foreach ($clientesindis as $key => $cli){
								if($active == true){
									echo '<li role="presentation" class="active">';
									$active = false;
								}else{
									echo '<li role="presentation">';
								}
								echo '<a href="#' . $key .'" aria-controls="' . $key .'" role="tab" data-toggle="tab">' . $key .'</a></li>';
							}unset($cli);
						?>
				</ul>
				<div class="tab-content">
					<?php
						$active = true;
						foreach ($clientesindis as $key => $cli){
							if($active == true){
								echo "<div role='tabpanel' class='tab-pane active' id='" . $key . "'>";
								$active = false;
							}else{
								echo "<div role='tabpanel' class='tab-pane' id='" . $key . "'>";
							}
							foreach ($cli as $servico){
									echo $this->Disponibilidade->indisponibilidades($servico,$init,$end);
							}unset($servico);
							echo "</div>";
						}unset($cli);
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- RDMs --> <?php //debug($rdmsmes);?>
	<div class="col-lg-9  col-md-12 col-sm-12 pull-left delete-rdm">
		<div class="panel panel-danger ">
			<div class="panel-heading">
				<p>
					<h3 class="panel-title">
						<b><i class="fa fa-pie-chart" style="font-size: 20px;"></i> Requisões de Mudança
							<span style="cursor:pointer;" onclick="javascript:$('div.panel-body.rdms-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
							<span style="cursor:pointer;" onclick="javascript:$('div.delete-rdm').remove();"><i class="fa fa-trash-o pull-right"></i></span>
						</b>
					</h3>
				</p>
			</div>
			<div class="panel-body rdms-body">
				<ul class="nav nav-tabs nav-tabs-black cliente" role="tablist">
					<?php $active = true; foreach ($rdmsano as $key => $cliente): ?>
						<?php
							if($active == true){
								echo '<li role="presentation" class="active"><a href="#' . $key . 'rdm" role="tab" data-toggle="tab">' . $key . '</a></li>';
								$active = false;
							}else{
								echo '<li role="presentation"><a href="#' . $key . 'rdm" role="tab" data-toggle="tab">' . $key . '</a></li>';
							}
						?>
					<?php endforeach; ?>
				</ul>
				<div class="tab-content">
					<?php
						$active = true;
						foreach ($rdmsano as $key1 => $cliente):
					?>
							<div role="tabpanel" class="tab-pane <?php echo $active ? "active" : ""; ?>" id="<?php echo $key1; ?>rdm">
								<?php
									//Ambiente
									echo $this->Rdm->rdmgraph($cliente['Ambiente'], "Ambientes alterados em " . date('Y') , $key1, 'anoamb', $cliente['Total']);
									if(isset($rdmsmes[$key1]))
										echo $this->Rdm->rdmgraph($rdmsmes[$key1]['Ambiente'], "Ambientes alterados no mês " . date('m/Y') , $key1, 'mesamb', $rdmsmes[$key1]['Total']);
									//Sucesso
									echo $this->Rdm->rdmgraph($cliente['Sucesso'], "Execução das RDMs em " . date('Y') , $key1, 'anosuc', $cliente['Total']);
									if(isset($rdmsmes[$key1]))
										echo $this->Rdm->rdmgraph($rdmsmes[$key1]['Sucesso'], "Execução das RDMs no mês " . date('m/Y') , $key1, 'messuc', $rdmsmes[$key1]['Total']);
									//Servico
									echo $this->Rdm->rdmgraph($cliente['Servico'], "RDMs por serviço em " . date('Y') , $key1, 'anoserv', $cliente['Total']);
									if(isset($rdmsmes[$key1]))
										echo $this->Rdm->rdmgraph($rdmsmes[$key1]['Servico'], "RDMs por serviço no mês " . date('m/Y') , $key1, 'messerv', $rdmsmes[$key1]['Total']);
									//Tipo
									//echo $this->Rdm->rdmgraph($cliente['Tipo'], "RDMs por tipo em " . date('Y') , $key1, 'ano', $cliente['Total']);
									//if(isset($rdmsmes[$key1]))
									//echo $this->Rdm->rdmgraph($rdmsmes[$key1]['Tipo'], "RDMs por tipo no mês " . date('m/Y') , $key1, 'mes', $rdmsmes[$key1]['Total']);

									//Sucesso durante o ano
									echo $this->Rdm->rdmSucessoTimegraph($rdmsano[$key1]['Mensal']['Sucesso'], $key1);
								?>
							</div>
					<?php if($active == true) $active = false; endforeach; ?>
				</div>
			</div>
		</div>
	</div>

	<!-- Sses -->
	<div class="col-lg-9  col-md-12 col-sm-12 pull-left delete-dem">
	  <div class="panel panel-info">
	    <div class="panel-heading">
	      <p>
	        <h3 class="panel-title">
	          <b><i class="fa fa-pie-chart" style="font-size: 20px;"></i> SS
	            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.sses-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
	            <span style="cursor:pointer;" onclick="javascript:$('div.delete-dem').remove();"><i class="fa fa-trash-o pull-right"></i></span>
	          </b>
	        </h3>
	      </p>
	    </div>
	    <div class="panel-body sses-body">
	      <ul class="nav nav-tabs nav-tabs-black cliente" role="tablist">
	        <?php $active = true; foreach ($cliensses as $key1 => $sses): ?>
	          <?php
	            if($active == true){
	              echo '<li role="presentation" class="active"><a href="#' . $key1 . 'ss" role="tab" data-toggle="tab">' . $key1 . '</a></li>';
	              $active = false;
	            }else{
	              echo '<li role="presentation"><a href="#' . $key1 . 'ss" role="tab" data-toggle="tab">' . $key1 . '</a></li>';
	            }
	          ?>
	        <?php endforeach; ?>
	      </ul>
	      <div class="tab-content">
	        <?php $active = true; foreach ($cliensses as $key1 => $sses):
	            if($active == true){
	              echo '<div role="tabpanel" class="col-lg-12 tab-pane active" id="' . $key1 . 'ss">';
	              $active = false;
	            }else{
	              echo '<div role="tabpanel" class="col-lg-12 tab-pane" id="' . $key1 . 'ss">';
	            }?>
	            <ul class="nav nav-tabs nav-tabs-black" role="tablist">
	              <li role="presentation" class="active"><a href="#geralss<?php echo $key1; ?>" role="tab" data-toggle="tab">Visão Geral</a></li>
	              <li role="presentation"><a href="#statusss<?php echo $key1; ?>" role="tab" data-toggle="tab">Status</a></li>
	              <li role="presentation"><a href="#atrasosss<?php echo $key1; ?>" role="tab" data-toggle="tab">Atrasos (em dias)</a></li>
	            </ul>

	            <div class="tab-content">
	              <div role="tabpanel" class="tab-pane active" id="geralss<?php echo $key1; ?>">
	                <?php
										echo $this->Ss->ssesGeral($sses,$key1);
										echo $this->Ss->ssTimegraph($clienssessano[$key1], $key1);
									?>
	              </div>
	              <div role="tabpanel" class="tab-pane" id="statusss<?php echo $key1; ?>">
	                <?php
	                  foreach ($sses as $key => $value){
	                    echo $this->Ss->ssesStatus($sses[$key], $key);
	                  }
	                ?>
	              </div>
	              <div role="tabpanel" class="tab-pane" id="atrasosss<?php echo $key1; ?>">
	                <?php
	                  foreach ($sses as $key => $value){
	                    echo $this->Ss->ssesAtrasos($sses[$key], $key);
	                  }
	                ?>
	              </div>
	            </div>
	          </div>
	        <?php endforeach; ?>
	      </div>
	    </div>
	    <ul class="list-group">
	      <li class="list-group-item small">*Não são mostradas aqui as SS cujo processo já foi finalizado</li>
				<li class="list-group-item small">*São consideradas SS entregues aquelas cujas OS possuem data de Homologação</li>
	    </ul>
	  </div>
	</div>

	<!-- Demandas Internas -->
	<div class="col-lg-9  col-md-12 col-sm-12 pull-left delete-dem">
		<div class="panel panel-primary ">
			<div class="panel-heading">
				<p>
					<h3 class="panel-title">
						<b><i class="fa fa-pie-chart" style="font-size: 20px;"></i> Demandas Internas
							<span style="cursor:pointer;" onclick="javascript:$('div.panel-body.demandas-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
							<span style="cursor:pointer;" onclick="javascript:$('div.delete-dem').remove();"><i class="fa fa-trash-o pull-right"></i></span>
						</b>
					</h3>
				</p>
			</div>
			<div class="panel-body demandas-body">
				<ul class="nav nav-tabs nav-tabs-black cliente" role="tablist">
					<?php $active = true; foreach ($cliendemandas as $key1 => $demandas): ?>
						<?php
							if($active == true){
								echo '<li role="presentation" class="active"><a href="#' . $key1 . 'dem" role="tab" data-toggle="tab">' . $key1 . '</a></li>';
								$active = false;
							}else{
								echo '<li role="presentation"><a href="#' . $key1 . 'dem" role="tab" data-toggle="tab">' . $key1 . '</a></li>';
							}
						?>
					<?php endforeach; ?>
				</ul>
				<div class="tab-content">
					<?php $active = true; foreach ($cliendemandas as $key1 => $demandas):
							if($active == true){
								echo '<div role="tabpanel" class="col-lg-12 tab-pane active" id="' . $key1 . 'dem">';
								$active = false;
							}else{
								echo '<div role="tabpanel" class="col-lg-12 tab-pane" id="' . $key1 . 'dem">';
							}?>
							<ul class="nav nav-tabs nav-tabs-black" role="tablist">
								<li role="presentation" class="active"><a href="#geral<?php echo $key1; ?>" role="tab" data-toggle="tab">Visão Geral</a></li>
							  <li role="presentation"><a href="#status<?php echo $key1; ?>" role="tab" data-toggle="tab">Status</a></li>
							  <li role="presentation"><a href="#tipos<?php echo $key1; ?>" role="tab" data-toggle="tab">Tipos</a></li>
								<li role="presentation"><a href="#atrasos<?php echo $key1; ?>" role="tab" data-toggle="tab">Atrasos (em dias)</a></li>
								<li role="presentation"><a href="#tipos_status<?php echo $key1; ?>" role="tab" data-toggle="tab">TiposXStatus</a></li>
							</ul>

							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="geral<?php echo $key1; ?>">
									<?php echo $this->Demanda->demandasGeral($demandas,$key1); ?>
								</div>
							  <div role="tabpanel" class="tab-pane" id="status<?php echo $key1; ?>">
									<?php
										foreach ($demandas as $key => $value){
											echo $this->Demanda->demandasStatus($demandas[$key], $key);
										}
									?>
								</div>
							  <div role="tabpanel" class="tab-pane" id="tipos<?php echo $key1; ?>">
									<?php
										foreach ($demandas as $key => $value){
											echo $this->Demanda->demandasTipos($demandas[$key], $key);
									 	}unset($demanda);
									?>
								</div>
								<div role="tabpanel" class="tab-pane" id="atrasos<?php echo $key1; ?>">
									<?php
										foreach ($demandas as $key => $value){
											echo $this->Demanda->demandasAtrasos($demandas[$key], $key);
										}
									?>
								</div>
								<div role="tabpanel" class="tab-pane" id="tipos_status<?php echo $key1; ?>">
									<?php
										foreach ($demandas as $key => $value){
											echo $this->Demanda->demandasStatusTipos($demandas[$key], $key);
										}
										unset($demanda);
									?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<ul class="list-group">
    		<li class="list-group-item small">*Não são mostradas aqui as demandas internas cujo processo já foi finalizado</li>
  		</ul>
		</div>
	</div>

	<!-- Chamados -->
	<div class="col-lg-9  col-md-12 col-sm-12 pull-left delete-cham">
		<div class="panel panel-success">
			<div class="panel-heading">
				<p>
					<h3 class="panel-title">
						<b><i class="fa fa-pie-chart" style="font-size: 20px;"></i> Chamados
							<span style="cursor:pointer;" onclick="javascript:$('div.panel-body.chamados-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
							<span style="cursor:pointer;" onclick="javascript:$('div.delete-cham').remove();"><i class="fa fa-trash-o pull-right"></i></span>
						</b>
					</h3>
				</p>
			</div>
			<div class="panel-body chamados-body">
				<ul class="nav nav-tabs nav-tabs-black cliente" role="tablist">
					<?php $active = true; foreach ($clienchamados as $cliente => $cham): ?>
						<?php
							if($active == true){
								echo '<li role="presentation" class="active"><a href="#' . $cliente . 'cham" role="tab" data-toggle="tab">' . $cliente . '</a></li>';
								$active = false;
							}else{
								echo '<li role="presentation"><a href="#' . $cliente . 'cham" role="tab" data-toggle="tab">' . $cliente . '</a></li>';
							}
						?>
					<?php endforeach; ?>
				</ul>
				<div class="tab-content">
					<?php $active = true; foreach ($clienchamados as $cliente => $chamados):
							if($active == true){
								echo '<div role="tabpanel" class="col-lg-12 tab-pane active" id="' . $cliente . 'cham">';
								$active = false;
							}else{
								echo '<div role="tabpanel" class="col-lg-12 tab-pane" id="' . $cliente . 'cham">';
							}
					?>
						<ul class="nav nav-tabs nav-tabs-black" role="tablist">
							<li role="presentation" class="active"><a href="#geral_status<?php echo $cliente; ?>" role="tab" data-toggle="tab">Visão Geral</a></li>
							<li role="presentation"><a href="#cham_status<?php echo $cliente; ?>" role="tab" data-toggle="tab">Status</a></li>
							<li role="presentation"><a href="#cham_tipos<?php echo $cliente; ?>" role="tab" data-toggle="tab">Tipos</a></li>
							<li role="presentation"><a href="#cham_tipos_status<?php echo $cliente; ?>" role="tab" data-toggle="tab">TiposXStatus</a></li>
						</ul>

						<div class="tab-content">
							<div role="tabpanel" class="tab-pane active" id="geral_status<?php echo $cliente; ?>">
								<?php echo $this->Chamado->chamadosGeral($chamados,$cliente); ?>
							</div>
							<div role="tabpanel" class="tab-pane" id="cham_status<?php echo $cliente; ?>">
								<?php
									foreach ($chamados as $key => $value){
										echo $this->Chamado->chamadosStatus($chamados[$key], $key);
									}unset($chamado);
								?>
							</div>
							<div role="tabpanel" class="tab-pane" id="cham_tipos<?php echo $cliente; ?>">
								<?php
									foreach ($chamados as $key => $value){
										echo $this->Chamado->chamadosTipos($chamados[$key], $key);
									}unset($chamado);
								?>
							</div>
							<div role="tabpanel" class="tab-pane" id="cham_tipos_status<?php echo $cliente; ?>">
								<?php
								 	foreach ($chamados as $key => $value){
										echo $this->Chamado->chamadosStatusTipos($chamados[$key], $key);
									}unset($chamado);
								?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<ul class="list-group">
			<li class="list-group-item small">*Não são mostrados aqui os chamados cujo processo já foi finalizado</li>
		</ul>
	</div>
</div>

<?php
 	// Circliful
 	echo $this->Html->script('plugins/circliful/js/jquery.circliful.js');
 	echo $this->Html->css('plugins/jquery.circliful.css');

 	// Piety
  echo $this->Html->script('plugins/peity/jquery.peity.min.js');

	// CanvasJs
	echo $this->Html->script('plugins/canvasjs/jquery.canvasjs.min.js');
?>

<script>
	function refreshCode(){
		$.ajax({
			url: "servicos/ajax",
			cache: false,
			success: function(html){
				$("#refresh").html(html);
			}
		})
	}

	/*
	* Servico: ID
	* Sigla: String
	*/
	function refreshContainers(servico, sigla){
		$.ajax({
			url: "servicos/containersonline/" + servico,
			cache: false,
			success: function(html){
				$("#containers_" + sigla).html(html);
			}
		})
	}

	$(document).ready(function() {
		setInterval(function(){ refreshCode(); }, 170000);
		setInterval(function(){ $('.get-containers').click(); }, 185000);
		refreshCode();

		$('#myStat').circliful();
	});

  $('#abasIndi a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
  })
</script>

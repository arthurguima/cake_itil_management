<div class="row">
		<div class="col-lg-12"><h3 class="page-header">Bem Vindo ao SGD! - <?php echo $this->Ldap->nomeUsuario(); ?></h3></div>
</div>

<div class="row">

	<div class="col-lg-3 col-md-12 pull-right col-sm-12 delete-online">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<p>
					<h3 class="panel-title">
						Serviços Online:
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
		<div class="panel panel-default panel-info">
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
							foreach ($clientes as $key => $cli){
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
						foreach ($clientes as $key => $cli){
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

	<!-- Demandas Internas -->
	<div class="col-lg-9  col-md-12 col-sm-12 pull-left delete-dem">
		<div class="panel panel-default ">
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
				<ul class="nav nav-tabs nav-tabs-black" role="tablist">
				  <li role="presentation" class="active"><a href="#status" role="tab" data-toggle="tab">Status</a></li>
				  <li role="presentation"><a href="#tipos" role="tab" data-toggle="tab">Tipos</a></li>
					<li role="presentation"><a href="#tipos_status" role="tab" data-toggle="tab">TiposXStatus</a></li>
				</ul>

				<div class="tab-content">
				  <div role="tabpanel" class="tab-pane active" id="status">
						<?php foreach ($demandas as $key => $value): ?>
							<?php echo $this->Demanda->demandasStatus($demandas[$key], $key)?>
						<?php endforeach; ?>
						<?php unset($demanda);?>
					</div>
				  <div role="tabpanel" class="tab-pane" id="tipos">
						<?php foreach ($demandas as $key => $value): ?>
							<?php echo $this->Demanda->demandasTipos($demandas[$key], $key)?>
						<?php endforeach; ?>
						<?php unset($demanda);?>
					</div>
					<div role="tabpanel" class="tab-pane" id="tipos_status">
						<?php foreach ($demandas as $key => $value): ?>
							<?php echo $this->Demanda->demandasStatusTipos($demandas[$key], $key)?>
						<?php endforeach; ?>
						<?php unset($demanda);?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Chamados -->
	<div class="col-lg-9  col-md-12 col-sm-12 pull-left delete-cham">
		<div class="panel panel-warning">
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
				<ul class="nav nav-tabs nav-tabs-black" role="tablist">
					<li role="presentation" class="active"><a href="#cham_status" role="tab" data-toggle="tab">Status</a></li>
					<li role="presentation"><a href="#cham_tipos" role="tab" data-toggle="tab">Tipos</a></li>
					<li role="presentation"><a href="#cham_tipos_status" role="tab" data-toggle="tab">TiposXStatus</a></li>
				</ul>

				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="cham_status">
						<?php foreach ($chamados as $key => $value): ?>
							<?php echo $this->Chamado->chamadosStatus($chamados[$key], $key)?>
						<?php endforeach; ?>
						<?php unset($chamado);?>
					</div>
					<div role="tabpanel" class="tab-pane" id="cham_tipos">
						<?php foreach ($chamados as $key => $value): ?>
							<?php echo $this->Chamado->chamadosTipos($chamados[$key], $key)?>
						<?php endforeach; ?>
						<?php unset($chamado);?>
					</div>
					<div role="tabpanel" class="tab-pane" id="cham_tipos_status">
						<?php foreach ($chamados as $key => $value): ?>
							<?php echo $this->Chamado->chamadosStatusTipos($chamados[$key], $key)?>
						<?php endforeach; ?>
						<?php unset($chamado);?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
 // Circliful
 echo $this->Html->script('plugins/circliful/js/jquery.circliful.js');
 echo $this->Html->css('plugins/jquery.circliful.css');

 // Piety
  echo $this->Html->script('plugins/peity/jquery.peity.min.js');
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

	$(document).ready(function() {
		setInterval(function(){ refreshCode(); }, 50000);
		refreshCode();

		$('#myStat').circliful();
	});

  $('#abasIndi a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
  })
</script>

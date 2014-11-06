<div class="row">
		<div class="col-lg-12"><h3 class="page-header">Bem Vindo ao SGD! - <?php echo $this->Ldap->nomeUsuario(); ?></h3></div>
</div>

<div class="row">

	<div class="col-lg-3 col-md-12 pull-right col-sm-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<p>
					<h3 class="panel-title">
						Serviços Online:
						<?php echo $this->Html->link('<i class="fa fa-refresh pull-right"></i>', 'javascript:refreshCode();', array('escape' => false)); ?>
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

	<div class="col-lg-9 col-md-12 col-sm-12 pull-left">
		<div class="panel panel-default panel-info">
			<div class="panel-heading">
				<p><h3 class="panel-title"><b><i class="fa fa-clock-o" style="font-size: 20px;"></i> <span>Disponibilidade</b> - Período
					<?php
						if(date("d") < 20){
							echo "20/" . date("m/Y",strtotime("-1 month")) . " a 20/" . date('m/Y');
						}
						else{
							echo "20/" . date('m/Y') . " a 20/" . date("m/Y",strtotime("+1 month"));
						}
					?></span>
					<span style="cursor:pointer;" onclick="javascript:$('div.panel-body.indisponibilidades-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
				</h3></p>
			</div>
			<div class="panel-body indisponibilidades-body">
				<div class="tab-content">
						<?php foreach ($servicos as $servico): ?>
							<?php echo $this->Disponibilidade->indisponibilidades($servico)?>
						<?php endforeach; ?>
						<?php unset($servico);?>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-9  col-md-12 col-sm-12 pull-left">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<p>
					<h3 class="panel-title">
						<b><i class="fa fa-pie-chart" style="font-size: 20px;"></i> Demandas Internas
							<span style="cursor:pointer;" onclick="javascript:$('div.panel-body.demandas-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
						</b>
					</h3>
				</p>
			</div>
			<div class="panel-body demandas-body">
				<ul class="nav nav-tabs nav-tabs-black" role="tablist">
				  <li role="presentation" class="active"><a href="#status" role="tab" data-toggle="tab">Status</a></li>
				  <li role="presentation"><a href="#tipos" role="tab" data-toggle="tab">Tipos</a></li>
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
</script>

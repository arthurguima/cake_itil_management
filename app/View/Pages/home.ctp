<div class="row">
		<div class="col-lg-12"><h3 class="page-header">Bem Vindo ao SGD!</h3></div>
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

	<div class="col-lg-9 pull-left">
		<div class="panel panel-default panel-info">
			<div class="panel-heading">
				<p><h3 class="panel-title"><b>Indisponibilidades - Período
					<?php
						if(date("d") < 20){
							echo "20/" . date("m/Y",strtotime("-1 month")) . " a 20/" . date('m/Y');
						}
						else{
							echo "20/" . date('m/Y') . " a 20/" . date("m/Y",strtotime("+1 month"));
						}
					?>
				</b></p>
			</div>
			<div class="panel-body">
				<div class="tab-content">
						<?php foreach ($servicos as $servico): ?>
							<?php echo $this->Disponibilidade->indisponibilidades($servico)?>
						<?php endforeach; ?>
						<?php unset($servico);?>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-9 pull-left">
		<div class="panel panel-default ">
			<div class="panel-heading">
				<p><h3 class="panel-title"><b>Demandas</b></p>
			</div>
			<div class="panel-body">
				<?php foreach ($demandas as $key => $value): ?>
					<?php echo $this->Demanda->demandas($demandas[$key], $key)?>
				<?php endforeach; ?>
				<?php unset($demanda);?>
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

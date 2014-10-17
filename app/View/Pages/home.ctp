<div class="row">
		<div class="col-lg-12"><h3 class="page-header">Bem Vindo ao SGD!</h3></div>
</div>

<div class="row">

	<div class="col-md-3 pull-right">
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
		<h3><?php echo __d('cake_dev', 'Notas:'); ?></h3>
		<div class="well">
			Esse é um novo mundo de gestão da DITE!<br/><br/> Agora você pode:<br/><br/>
			<ul>
				<li>Registrar Indisponibilidades dos Sistemas.</li>
				<li>Controlar os contratos de cada cliente, seus itens e aditivos.</li>
				<li>Controlar as áreas de cada cliente e seus serviços.</li>
				<li>Registrar as demandas de cada serviço.</li>
				<li>Registrar todo o conhecimento para as operações diárias no DITE.</li>
			</ul>
		</div>

		<div class="panel panel-default panel-info">
			<div class="panel-heading">
				<p><h3 class="panel-title">Disponibilidade Mensal - <b>20/<?php echo date("m/Y",strtotime("-1 month")) . " a 20/" . date('m/Y'); ?></b></p>
			</div>
			<div class="panel-body">
				<?php foreach ($servicos as $servico): ?>
					<?php echo $this->Disponibilidade->indisponibilidades($servico)?>
				<?php endforeach; ?>
				<?php unset($servico);?>
			</div>
		</div>
	</div>
</div>

<?php
 echo $this->Html->script('plugins/circliful/js/jquery.circliful.js');
 echo $this->Html->css('plugins/jquery.circliful.css');
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

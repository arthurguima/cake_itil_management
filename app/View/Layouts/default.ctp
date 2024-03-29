<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<title><?php echo $title_for_layout; ?> </title>
	<link rel="shortcut icon" sizes="16x16 32x32 48x48" type="image/png" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAB50lEQVQ4T6XTTUgbQRQH8P8s66oYbCIKimIo7cEvSjFIkIKiIOLBg0Ib7EUQikiroXrwVF2h4MclNN4EWzEoRtGDKIjgoZQee2kMfpAqYmlB6kc07ppsdp+sNMGPjUo7xzfzfjNv3gzDfw52Pb/4uSgA6Sb/TOfBfewbAECswOHeAhBgIA+nJc35Z16HEmEGAFDgcA8D9OZvkszAFojgSTMnL30baVUuY3GgbKgsmxTKFEg4CQZqn6iyed5g1wMCFjli42vT7SsAozhgG7Dl88T7AKQTMYT8DdCiKYmvgeBan3Z2XinB3m9vATCqZ8m7dkT2HyUC/iiCUPzD07Z3AZAILpKZUUiq+qw9bO35rqbmRo9zcLpVZQgwoGnN65zSJy8AyW1pYqAxAEKQeDTLVhxpAo5XG0GqcB1ZWPc662PBeAmnHx7YOMZmAVi/qCa8O8uFtFMO5fDhZSAY5VlJYKLj5w1AD5y4TVk8eP1o1X3hHCzvF0HarogDBLRseJ2fDNsYC5IIPpxheR8krrtZeowd3wuQyoOAlQ1vR43euluB2KQ0bHn5VUn72LXpSI4c5UU0DoWbk2/1F3plGL7E2IqQy/z01V7lZ9/vUtfqWK9o1JJbAT1hcLAur1u2/4Ioav8E3PUjzwHhtqwRScFa2AAAAABJRU5ErkJggg==">
	<?php
		//echo $this->Html->meta('icon','img/favicon.png',array('type' => 'icon'));
		/* JS */
		//-- jQuery Version 1.11.0 --
		echo $this->Html->script('jquery-1.11.0.js');
		//-- Bootstrap Core JavaScript --
		echo $this->Html->script('bootstrap.min.js');
		//-- Metis Menu Plugin JavaScript -->
		echo $this->Html->script('plugins/metisMenu/metisMenu.min.js');
		echo $this->Html->script('sb-admin-2.js');


		/* CSS */
		//-- Bootstrap Core CSS --
		echo $this->Html->css('bootstrap.min.css');
		//-- MetisMenu CSS --
		echo $this->Html->css('plugins/metisMenu/metisMenu.min.css');
		//-- Timeline CSS --
		//echo $this->Html->css('plugins/timeline.css');
		//-- Custom Fonts
		echo $this->Html->css('fontawesome/web-fonts-with-css/css/fontawesome-all.css');
		//-- Custom admin CSS --
		echo $this->Html->css('sb-admin-2.css');
	?>
</head>

<body>
	<div id="wrapper">
		<!-- Início Sidebar -->
		<i id="bars-side-menu" class="fa fa-bars center hide-sidebar hidden-xs" style="display: none; cursor:pointer;" onclick="javascript:sidebarClick();"></i>
		<div class="navbar-default sidebar" role="navigation">
			<div class="navbar-brand hidden-xs hiden-sm">
				<div class="row">
					<div id="sgs-brand">
						<div class="col-lg-2"><i class="fa fa-bars center hide-sidebar hidden-xs" style="cursor:pointer;" onclick="javascript:sidebarClick();"></i></div>
						<div class="col-lg-10"><span class="sgd">SGS</span></div>
					</div>
				</div>
				<div id="user">
					<div id="user-side" style="background-image: url('http://www-sicaprod/mdc4web_arqs/FOTOSFunc/f00000000<?php echo $this->Session->read('User.matricula');  ?>.jpg')"></div>
					<span class="user-side-name">Bem-vindo, <?php echo $this->Session->read('User.nome'); ?>!</span>
				</div>
			</div>
			<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
							<!--li class="sidebar-search"> Busca </li -->
							<li>
									<a href="#"><i class="fa fa-home fa-fw"></i> Workspace <span class="fa arrow"></span></a>
									<ul class="nav nav-second-level">
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Planilhas", Router::url('/', true) . "index.php", array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Kanban", Router::url('/', true) . "kanban", array('escape' => false)); ?></li>
									</ul>
							</li>
							<li><!-- Calendário -->
									<a href="#"><i class="fa fa-calendar fa-fw"></i> Calendários <span class="fa arrow"></span></a>
									<ul class="nav nav-second-level">
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Previsão das Demandas", '/calendarios/show/11?', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> RDMs", '/calendarios/show/2?', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Indisponibilidades", '/calendarios/show/13?', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Chamados", '/calendarios/show/23?', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Minhas Tarefas", '/calendarios/show/17?', array('escape' => false)); ?></li>
									</ul>
							</li>
							<li> <!-- Gestão do serviço -->
									<a href="#"><i class="fas fa-wrench fa-fw"></i> Gestão do Serviço <span class="fa arrow"></span></a>
									<ul class="nav nav-second-level">
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Chamados", '/chamados', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Chamados com Demandas", '/chamados/demandas', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Mudança", '/rdms', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Demandas", '/demandas', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Lista de Prioridades", '/relatorios/prioridades', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Releases", '/releases', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Disponibilidade", '/indisponibilidades', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Indicadores de Contratos", '/indicadores', array('escape' => false)); ?></li>
									</ul>
							</li>
							<li> <!-- Relatórios -->
									<a href="#"><i class="far fa-chart-bar fa-fw"></i> Relatórios <span class="fa arrow"></span></a>
									<ul class="nav nav-second-level">
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Dashboard", Router::url('/', true) . "dashboard", array('escape' => false)); ?></li>
										<li>
											<a href="#"><i class='fa fa-angle-double-right'></i> Disponibilidade <span class="fa arrow"></span></a>
											<ul class="nav nav-third-level collapse">
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Disponibilidade/Serviço", '/relatorios/indisponibilidades', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Disponibilidade Geral", '/relatorios/indis_total', array('escape' => false)); ?></li>
											</ul>
										</li>
										<li>
											<a href="#"><i class='fa fa-angle-double-right'></i> Demandas Internas <span class="fa arrow"></span></a>
											<ul class="nav nav-third-level collapse">
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Demandas não Finalizadas", '/relatorios/demandas', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Demandas não Finalizadas por cliente", '/relatorios/demandas_cliente', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Demandas Atrasadas", '/relatorios/dematrasadas', array('escape' => false)); ?></li>
											</ul>
										</li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Releases", '/relatorios/releases', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Tarefas", '/relatorios/tarefasusuario', array('escape' => false)); ?></li>
									</ul>
							</li>
							<li> <!-- Admin -->
									<a href="#"><i class="fas fa-cogs fa-fw"></i> Admin <span class="fa arrow"></span></a>
									<ul class="nav nav-second-level">
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Áreas", '/areas', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Clientes", '/clientes', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Contratos", '/contratos', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Dependências", '/dependencias', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Motivos para Indisponibilidade", '/motivos', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Tipos de Chamados", '/chamadotipos', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Tipos de RDM", '/rdmtipos', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Tipos de Demandas", '/demandatipos', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Grupos de Tarefas", '/grupotarefas', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Usuários", '/users', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Serviços", '/servicos', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Status", '/status', array('escape' => false)); ?></li>
									</ul>
							</li>
							<li>
								<a href="#"><i class="fa fa-user-secret fa-fw"></i> Sobre <span class="fa arrow"></span></a>
								<ul class="notes hidden-xs hidden-sm" style="top: 90%;">
									Sistema de gestão de Serviço - V 3.5
									<br /> <?php echo $this->Html->link("Mais Informações", '/pages/about'); ?>
									<br /> <span style="margin-left: 13px;">arthur.doliveira@dataprev.gov.br</span>
									<br />
								</ul>
							</li>
					</ul>
			</div>
				<span class="notes hidden-xs hidden-sm">
					<br /><br /><a href="/painel.php" style="padding-left: 38px;"><i class="fa fa-reply"></i> Retornar ao APPS</a>
				</span>
		</div>
		<!-- Fim sidebar -->
		<div id="page-wrapper">
			<span class="breadcrumb pull-right">
				<b><?php echo $this->Html->getCrumbs(' / ', array('text' => "<i class='fa fa-home'></i> Home", 'url' => Router::url('/', true) . "index.php", 'escape' => false)); ?></b>
			</span>
			<div style='clear:both'></div>
			<div class='row'>
				<!--nocache-->
				<?php echo $this->Session->flash(); ?>
				<!--/nocache-->
			</div>
			<?php echo $this->fetch('content'); ?>
		</div>
		<!-- hr style="margin-top:50px;" --><?php  //echo $this->element('sql_dump'); ?>
	</div>
	<script>
		$(function() {setTimeout(function(){$('.alert').toggle();}, 4200);});
	</script>
</body>
</html>

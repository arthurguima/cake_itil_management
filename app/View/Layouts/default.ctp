<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<title><?php echo $title_for_layout; ?> </title>
	<?php
		echo $this->Html->meta('icon');
		/* JS */
		//-- jQuery Version 1.11.0 --
		echo $this->Html->script('jquery-1.11.0.js');
		//-- Bootstrap Core JavaScript --
		echo $this->Html->script('bootstrap.min.js');
		//-- Metis Menu Plugin JavaScript -->
		echo $this->Html->script('plugins/metisMenu/metisMenu.min.js');
		echo $this->Html->script('sb-admin-2.js');
		//-- Sidebar
		echo $this->Html->script('sidebar.js');

		/* CSS */
		//-- Bootstrap Core CSS --
		echo $this->Html->css('bootstrap.min.css');
		//-- MetisMenu CSS --
		echo $this->Html->css('plugins/metisMenu/metisMenu.min.css');
		//-- Timeline CSS --
		//echo $this->Html->css('plugins/timeline.css');
		//-- Custom Fonts
		echo $this->Html->css('font-awesome-4.2.0/css/font-awesome.min.css');
		//-- Custom admin CSS --
		echo $this->Html->css('sb-admin-2.css');
	?>
</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<!-- Header -->
			<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand"> <!-- TODO Alterar -->
							<?php echo $this->Html->image("logo-icon.svg", array('height' => '50px', 'class' => 'hidden-xs hidden-sm')); ?>
						 	<span>SGD - Serviço de Gestão da DITE</small>
					</a>
			</div>
			<!-- Fim Header -->

			<!-- Início Sidebar -->
			<div class="navbar-default sidebar" role="navigation">
					<div class="sidebar-nav navbar-collapse">
							<ul class="nav" id="side-menu">
									<!--li class="sidebar-search"> Busca </li -->
									<li>
										  <?php echo $this->Html->link('<i class="fa fa-home fa-fw"></i> Dashboard',
																							Router::url('/', true) . "index.php", array('escape' => false)); ?>
									</li>
									<li><!-- Calendário -->
											<a href="#"><i class="fa fa-calendar fa-fw"></i> Calendários <span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Previsões de Término", '/calendarios/show/1155', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> RDMs", '/calendarios/show/2', array('escape' => false)); ?></li>
											</ul>
									</li>
									<li> <!-- Negócio -->
											<a href="#"><i class="fa fa-briefcase fa-fw"></i> Negócio <span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> SS", '/sses', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> PA", '/pes', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> OS", '/ords', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Demandas Internas", '/demandas', array('escape' => false)); ?></li>
											</ul>
									</li>
									<li> <!-- Gestão do serviço -->
											<a href="#"><i class="fa fa-wrench fa-fw"></i> Gestão do Serviço <span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Chamados", '/chamados', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Chamados com Demandas", '/chamados/demandas', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Mudança", '/rdms', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Disponibilidade", '/indisponibilidades', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Indicadores", '/indicadores', array('escape' => false)); ?></li>
											</ul>
									</li>
									<li> <!-- Relatórios -->
											<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Relatórios <span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
												<li>
													<a href="#"><i class='fa fa-angle-double-right'></i> Disponibilidade <span class="fa arrow"></span></a>
													<ul class="nav nav-third-level collapse">
														<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Disponibilidade/Serviço", '/relatorios/indisponibilidades', array('escape' => false)); ?></li>
														<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Disponibilidade Geral", '/relatorios/indis_total', array('escape' => false)); ?></li>
													</ul>
												</li>
												<li>
													<a href="#"><i class='fa fa-angle-double-right'></i> Ss <span class="fa arrow"></span></a>
													<ul class="nav nav-third-level collapse">
														<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Gestão de Ideias", '/relatorios/gsses', array('escape' => false)); ?></li>
													</ul>
												</li>
												<li>
													<a href="#"><i class='fa fa-angle-double-right'></i> Demandas Internas <span class="fa arrow"></span></a>
													<ul class="nav nav-third-level collapse">
														<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Demandas não Finalizadas", '/relatorios/demandas', array('escape' => false)); ?></li>
														<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Demandas Atrasadas", '/relatorios/dematrasadas', array('escape' => false)); ?></li>
													</ul>
												</li>
												<li>
													<li>
														<a href="#"><i class='fa fa-angle-double-right'></i> (Em Teste) <span class="fa arrow"></span></a>
														<ul class="nav nav-third-level collapse">
															<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Contrato", '/relatorios/contratos', array('escape' => false)); ?></li>
															<!--li><?php //echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Serviços (Em Breve)", '/relatorios/servicos', array('escape' => false)); ?></li -->
														</ul>
													</li>
												</li>
											</ul>
									</li>
									<li> <!-- Base de Conhecimenton -->
											<a href="#"><i class="fa fa-institution fa-fw"></i> Base de Conhecimento <span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Sistemas Internos", '/internos', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Procedimentos", '/procedimentos', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Mapeamento DTP", '/responsabilidades', array('escape' => false)); ?></li>
											</ul>
									</li>
									<li> <!-- Admin -->
											<a href="#"><i class="fa fa-gears fa-fw"></i> Admin <span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Áreas", '/areas', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Clientes", '/clientes', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Contratos", '/contratos', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Dependências", '/dependencias', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Motivos para Indisponibilidade", '/motivos', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Tipos de Chamados", '/chamadotipos', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Tipos de RDM", '/rdmtipos', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Tipos de Demandas", '/demandatipos', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Usuários", '/users', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Serviços", '/servicos', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Status", '/status', array('escape' => false)); ?></li>
											</ul>
									</li>
								</ul>
								<i class="fa fa-caret-left hide-sidebar hidden-xs" style="cursor:pointer;" onclick="javascript:sidebarClick();"></i>
					</div>
					<span class="notes hidden-xs hidden-sm">
						Sistema de gestão da DITE - Versão 2.0
						<br /> <?php echo $this->Html->link("Mais Informações", '/pages/about'); ?>
						<br /><br /><a href="/painel.php" style="padding-left: 52px;"><i class="fa fa-reply"></i> Retornar ao APPS</a>
					</span>
			</div>
			<!-- Fim sidebar -->
		</nav>
		<div id="page-wrapper">
			<span class="breadcrumb pull-right">
				<b><?php echo $this->Html->getCrumbs(' > ', array('text' => "<i class='fa fa-home'></i> Home", 'url' => Router::url('/', true) . "index.php", 'escape' => false)); ?></b>
			</span>
			<div style='clear:both'></div>
			<div class='row'><!--nocache--><?php echo $this->Session->flash(); ?><!--/nocache--></div>
			<?php echo $this->fetch('content'); ?>
		</div>
		<!--div id="footer">
		</div>
	</div>
	<hr style="margin-top:50px;" /--><?php // echo $this->element('sql_dump'); ?>
</body>
</html>

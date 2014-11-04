<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<title> SGD - <?php echo $title_for_layout; ?> </title>
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
									<li><a href="#"><i class="fa fa-calendar fa-fw"></i> Calendário (em breve)<span class="fa arrow"></span></a></li>
									<li> <!-- SS -->
											<a href="#"><i class="fa fa-comments-o fa-fw"></i> SS (em breve)<span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
													<li><a href="#"><i class="fa fa-angle-double-right"></i> Incluir</a></li>
													<li><a href="#"><i class="fa fa-angle-double-right"></i> Consultar</a></li>
											</ul>
									</li>
									<li> <!-- PE -->
											<a href="#"><i class="fa fa-briefcase fa-fw"></i> PE (em breve)<span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
													<li><a href="#"><i class="fa fa-angle-double-right"></i> Incluir</a></li>
													<li><a href="#"><i class="fa fa-angle-double-right"></i> Consultar</a></li>
											</ul>
									</li>
									<li> <!-- OS -->
											<a href="#"><i class="fa fa-bell fa-fw"></i> OS (em breve)<span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
													<li><a href="#"><i class="fa fa-angle-double-right"></i> Incluir</a></li>
													<li><a href="#"><i class="fa fa-angle-double-right"></i> Consultar</a></li>
											</ul>
									</li>
									<li> <!-- Sustentação -->
											<a href="#"><i class="fa fa-wrench fa-fw"></i> Sustentação<span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
													<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Controle de Disponibilidade", '/indisponibilidades', array('escape' => false)); ?></li>
													<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Demandas Internas", '/demandas', array('escape' => false)); ?></li>
											</ul>
									</li>
									<li> <!-- Relatórios -->
											<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Relatórios (em breve)<span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
													<li><a href="#">1</a></li>
													<li><a href="#">2</a></li>
											</ul>
									</li>
									<li> <!-- Base de Conhecimenton -->
											<a href="#"><i class="fa fa-institution fa-fw"></i> Base de Conhecimento<span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
													<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Sistemas Internos", '/internos', array('escape' => false)); ?></li>
													<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Procedimentos", '/procedimentos', array('escape' => false)); ?></li>
													<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Mapeamento DTP", '/responsabilidades', array('escape' => false)); ?></li>
											</ul>
									</li>
									<li> <!-- Admin -->
											<a href="#"><i class="fa fa-gears fa-fw"></i> Admin<span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
													<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Áreas", '/areas', array('escape' => false)); ?></li>
													<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Clientes", '/clientes', array('escape' => false)); ?></li>
													<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Contratos", '/contratos', array('escape' => false)); ?></li>
													<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Serviços", '/servicos', array('escape' => false)); ?></li>
													<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Dependências", '/dependencias', array('escape' => false)); ?></li>
													<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Motivos para Indisponibilidade", '/motivos', array('escape' => false)); ?></li>
													<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Tipos de Demandas", '/demandatipos', array('escape' => false)); ?></li>
													<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Status", '/status', array('escape' => false)); ?></li>
													<!--li><a href="#">Termos</a></li -->
											</ul>
									</li>
								</ul>
								<i class="fa fa-caret-left hide-sidebar hidden-xs" style="cursor:pointer;" onclick="javascript:sidebarHide();"></i>
					</div>
					<span class="notes hidden-xs hidden-sm">Sistema de gestão da DITE - Versão 1.2 <br /> <?php echo $this->Html->link("Mais Informações", '/pages/about'); ?></span>
			</div>
			<!-- Fim sidebar -->
		</nav>
		<div id="page-wrapper">
			<span class="breadcrumb pull-right"><b><?php echo $this->Html->getCrumbs(' > ', array('text' => 'Home', 'url' => Router::url('/', true) . "index.php")); ?></b></span>
			<div style='clear:both'></div>
			<div class='row'><?php echo $this->Session->flash(); ?></div>
			<?php echo $this->fetch('content'); ?>
		</div>
		<!--div id="footer">
		</div>
	</div>
	<hr style="margin-top:50px;" /--><?php //echo $this->element('sql_dump'); ?>
</body>
</html>

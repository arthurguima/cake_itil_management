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
		echo $this->Html->css('font-awesome-4.6.3/css/font-awesome.min.css');
		//-- Custom admin CSS --
		echo $this->Html->css('sb-admin-2.css');
	?>
</head>

<body>
	<div id="wrapper">
		<!-- Início Sidebar -->
		<div class="navbar-default sidebar" role="navigation">
			<div class="navbar-brand hidden-xs hiden-sm">
				<a> <!-- TODO Alterar -->
						<?php echo $this->Html->image("logo-icon.svg", array('height' => '45px', 'class' => 'hidden-xs hidden-sm')); ?>
				</a>
				<span class="sgd">SGS - Sistema de Gestão de Serviço</span>
			</div>
			<div class="sidebar-nav navbar-collapse">
					<ul class="nav" id="side-menu">
							<!--li class="sidebar-search"> Busca </li -->
							<li>
									<?php echo $this->Html->link('<i class="fa fa-home fa-fw"></i> Workspace',
																					Router::url('/', true) . "index.php", array('escape' => false)); ?>
							</li>
							<li>
									<?php echo $this->Html->link("<i class='fa fa-folder fa-fw'></i> Dashboard",
																					Router::url('/', true) . "dashboard", array('escape' => false)); ?>
							</li>
							<li><!-- Calendário -->
									<a href="#"><i class="fa fa-calendar fa-fw"></i> Calendários <span class="fa arrow"></span></a>
									<ul class="nav nav-second-level">
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Previsão das Demandas", '/calendarios/show/11', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> RDMs", '/calendarios/show/2', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Indisponibilidades", '/calendarios/show/13', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Chamados", '/calendarios/show/23', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Minhas Tarefas", '/calendarios/show/17', array('escape' => false)); ?></li>
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
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Demandas", '/demandas', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Releases", '/releases', array('escape' => false)); ?></li>
										<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Lista de Prioridades", '/relatorios/prioridades', array('escape' => false)); ?></li>
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
							<li>
								<a href="#"><i class="fa fa-exclamation-circle fa-fw"></i> Funções Descontinuadas <span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
											<?php echo $this->Html->link('<i class="fa fa-home fa-fw"></i> Workspace',
																							Router::url('/', true) . "workspace_old", array('escape' => false)); ?>
									</li>
									<li><!-- Calendário -->
											<a href="#"><i class="fa fa-calendar fa-fw"></i> Calendários <span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Previsões de Término", '/calendarios/show/1155', array('escape' => false)); ?></li>
											</ul>
									</li>
									<li> <!-- Negócio -->
											<a href="#"><i class="fa fa-briefcase fa-fw"></i> Negócio <span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> SS", '/sses', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> PA", '/pes', array('escape' => false)); ?></li>
												<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> OS", '/ords', array('escape' => false)); ?></li>
											</ul>
									</li>
									<li> <!-- Relatórios -->
											<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Relatórios <span class="fa arrow"></span></a>
											<ul class="nav nav-second-level">
												<li>
													<a href="#"><i class='fa fa-angle-double-right'></i> Ss <span class="fa arrow"></span></a>
													<ul class="nav nav-third-level collapse">
														<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Gestão de Ideias", '/relatorios/gsses', array('escape' => false)); ?></li>
													</ul>
												</li>
												<li>
													<li>
														<a href="#"><i class='fa fa-angle-double-right'></i> Contrato <span class="fa arrow"></span></a>
														<ul class="nav nav-third-level collapse">
															<li><?php echo $this->Html->link("<i class='fa fa-angle-double-right'></i> Consumo", '/relatorios/contratos', array('escape' => false)); ?></li>
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
								</ul>
							<li>
					</ul>
						<i class="fa fa-caret-left hide-sidebar hidden-xs" style="cursor:pointer;" onclick="javascript:sidebarClick();"></i>
			</div>
			<span class="notes hidden-xs hidden-sm">
				Sistema de gestão de Serviço - V 2.8
				<br /> <?php echo $this->Html->link("Mais Informações", '/pages/about'); ?>
				<br /> <span style="margin-left: 13px;">arthur.doliveira@dataprev.gov.br</span>
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
	<script>$(function() {setTimeout(function(){$('.alert').toggle();}, 3800);});</script>
</body>
</html>

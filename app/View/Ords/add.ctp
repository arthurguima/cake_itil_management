<?php
	$this->Html->addCrumb('OS', '/ords');
	$this->Html->addCrumb("Nova OS", "");
?>
<div class="row">
	<div class="col-lg-12"><h3 class="page-header">Nova OS</h3></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<?php echo $this->BootstrapForm->create('Ord'); ?>
		<div class="col-lg-6">
			<?php
				if(!strcmp($this->params['url']['controller'],'sses')){
					echo $this->BootstrapForm->hidden('ss_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
					echo $this->BootstrapForm->hidden('servico_id', array('value' => $this->params['url']['servico'], 'type'=> "hidden"));
				}

				/*echo $this->BootstrapForm->input('nome', array(
										'label' => array('text' => 'Nome: ')));*/

				echo $this->BootstrapForm->input('numero', array(
										'label' => array('text' => 'Número: ')));

				echo $this->BootstrapForm->input('ano', array(
									'label' => array('text' => 'Ano: '),
									'type' => 'text',
									'id' => 'dpdecade',
									'value' => date('Y')));

				echo $this->BootstrapForm->input('cvs_url', array(
										'label' => array('text' => 'Url: ')));

				/*echo $this->BootstrapForm->input('pf', array(
										'label' => array('text' => 'Volume Final: ')));*/

				echo $this->BootstrapForm->input('responsavel', array(
															'label' => array('text' => 'Responsável: '),
															'value' => $this->Ldap->nomeUsuario()));

				echo $this->BootstrapForm->input('pe_id', array(
										'label' => array('text' => 'PA: ')));

				echo $this->BootstrapForm->input('dt_recebimento_termo_prov', array(
								'label' => array('text' => 'Data Prevista do Termo de Recebimento Provisório: '),
								'type' => 'text',
								'id' => 'dp'));

				echo $this->BootstrapForm->input('trp', array(
								'label' => array('text' => 'TRP (Link): ')));

				echo $this->BootstrapForm->input('dt_recebimento_homo', array(
									'label' => array('text' => 'Data Prevista do Termo de Homologação: '),
									'type' => 'text',
									'id' => 'dp'));

				echo $this->BootstrapForm->input('ths', array(
								'label' => array('text' => 'TH (Link): ')));

				echo $this->BootstrapForm->input('trd', array(
								'label' => array('text' => 'TRD (Link): ')));

				echo $this->BootstrapForm->input('dt_recebimento_termo', array(
									'label' => array('text' => 'Data Prevista do Termo de Recebimento: '),
									'type' => 'text',
									'id' => 'dp'));

			?>
		</div>
		<div class="col-lg-6">
			<?php
				echo $this->BootstrapForm->input('dt_emissao', array(
									'label' => array('text' => 'Data de Emissão: '),
									'type' => 'text',
									'id' => 'dp'));

				echo $this->BootstrapForm->input('dt_recebimento', array(
									'label' => array('text' => 'Data de Recebimento: '),
									'type' => 'text',
									'id' => 'dp'));

				echo $this->BootstrapForm->input('dt_deploy_homologacao', array(
									'label' => array('text' => 'Deploy Homologação: '),
									'type' => 'text',
									'id' => 'dp'));

				echo $this->BootstrapForm->input('dt_deploy_producao', array(
									'label' => array('text' => 'Deploy Produção: '),
									'type' => 'text',
									'id' => 'dp'));

				echo $this->BootstrapForm->input('dt_homologacao', array(
									'label' => array('text' => 'Data de Homologação: '),
									'type' => 'text',
									'id' => 'dp'));

				echo $this->BootstrapForm->input('status_id', array(
										'label' => array('text' => 'Status: ')));

				echo $this->BootstrapForm->input('dt_ini_pdd', array(
									'label' => array('text' => 'Data de Início da OS: '),
									'type' => 'text',
									'id' => 'dp'));

				echo $this->BootstrapForm->input('dt_fim_pdd', array(
									'label' => array('text' => 'Data de prevista para a Homologação: '),
									'type' => 'text',
									'id' => 'dp'));
			?>
		</div>
	</div>
	<div class="form-footer col-lg-12 col-md-6 pull-right">
		<?php
			echo $this->BootstrapForm->submit('Salvar');
			echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-lg-3 col-md-6'));
			echo $this->Form->end();
		?>
	</div>
	</div>
</div>

<script>

	$(document).ready(function() {
		$("[id*='dpdecade']").datetimepicker({
			format: "yyyy",
				startView: "decade",
				minView: "decade",
				maxView: "decade",
				viewSelect: "decade",
				autoclose: true,
				language: 'pt-BR'
		});

		$("[id*='dp']").datetimepicker({
			format: "dd/mm/yyyy",
				minView: 2,
				autoclose: true,
				todayBtn: true,
				language: 'pt-BR'
		});
	});
</script>

<?php
	//-- TimePicker --
	echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
	echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
	echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
?>

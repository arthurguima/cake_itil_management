<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header">Bem-vindo, <?php echo $this->Session->read('User.nome'); ?>!</h3>
		</div>
</div>

<div class="row">
<?php if($this->Session->read('User.uid') != 0): ?>
	<div class="col-lg-12  row-nav-tabs">
		<ul class="nav nav-tabs nav-tabs-black nav-tabs-pages" role="tablist">
		  <li role="presentation" <?php if($this->Session->read('User.workspace') == 1 || $this->Session->read('User.workspace') == 0) echo 'class="active"'; ?>><a href="#demandas" aria-controls="demandas" role="tab" data-toggle="tab">
				Demandas <span class="badge"><?php echo sizeof($demandas) ?></span></a>
			</li>
			<li role="presentation" <?php if($this->Session->read('User.workspace') == 2) echo 'class="active"'; ?>><a href="#subtarefas" aria-controls="subtarefas" role="tab" data-toggle="tab">
				Tarefas <span class="badge"><?php echo sizeof($subtarefas) ?></span></a>
			</li>
		  <li role="presentation" <?php if($this->Session->read('User.workspace') == 3) echo 'class="active"'; ?>><a href="#rdms" aria-controls="rdms" role="tab" data-toggle="tab">
				RDMs <span class="badge"><?php echo sizeof($rdms) ?></span></a>
			</li>
		  <li role="presentation" <?php if($this->Session->read('User.workspace') == 4) echo 'class="active"'; ?>><a href="#chamados" aria-controls="chamados" role="tab" data-toggle="tab">
				Chamados <span class="badge"><?php echo sizeof($chamados) ?></span></a>
			</li>
			<li role="presentation" <?php if($this->Session->read('User.workspace') == 5) echo 'class="active"'; ?>><a href="#indisponibilidades" aria-controls="indisponibilidades" role="tab" data-toggle="tab">
				Indisponibilidades <span class="badge"><?php echo sizeof($indisponibilidades) ?></span></a>
			</li>
		</ul>
	</div>

	<div class="tab-content">
		<!-- RDMs -->
		<div role="tabpanel" class="tab-pane <?php if($this->Session->read('User.workspace') == 3) echo "active"; ?>" id="rdms">
		  <div class="col-lg-12">
		    <div class="panel panel-workspace">
		      <div class="panel-heading">
						<b>RDMs</b>
						<?php
							if($this->Ldap->autorizado(2)){
								echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
								array('controller' => 'rdms', 'action' => 'add'),
								array('style' => 'color: #fff; font-size: 16px;','escape' => false));
							}
						?>
					</div>
		      <div class="panel-body">
		        <div class="table-responsive">
		          <table class="table table-striped table-bordered table-hover" id="dataTables-rdm">
		            <thead>
		              <tr>
		                <th>Servico</th>
		                <th>Versão</th>
		                <th>Ambiente</th>
		                <th>Tipo</th>
		                <th>Concluída?</th>
		                <th>Nome <i class="fa fa-comment-o" style="font-size: 15px !important;"></th>
		                <th>Nome</th>
		                <th>Número  <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
		                <th>Data Prevista</th>
		                <th>Execução</th>
										<th>CheckList</th>
		                <th>Ações</th>
		              </tr>
		            </thead>
		            <tbody>
		              <?php foreach ($rdms as $rdm): ?>
		                <tr>
		                  <td><?php echo $this->Html->link($rdm['Servico']['sigla'], array('controller' => 'servicos', 'action' => 'view', $rdm['Servico']['id'])); ?></td>
		                  <td ><div class="sub-17" style="font-size: 10px;"><?php echo $rdm['Rdm']['versao']; ?></div></td>
		                  <td><?php echo $this->Rdm->getAmbiente($rdm['Rdm']['ambiente']); ?></td>
		                  <td><div style="font-size: 10px;"><?php echo $this->Tables->popupBox($rdm['RdmTipo']['nome'],$rdm['RdmTipo']['nome']); ?></div></td>
		                  <td><?php echo $this->Rdm->sucesso($rdm['Rdm']['sucesso'], $rdm['Rdm']['dt_executada']); ?></a></td>
		                  <td class="sub-20">
		                    <?php
		                      echo $this->Tables->popupBox(
		                        $this->Html->link($rdm['Rdm']['nome'], array('controller' => 'rdms', 'action' => 'view', $rdm['Rdm']['id'])),
		                        $rdm['Rdm']['observacao']
		                      );
		                    ?>
		                  </td>
		                  <td><?php echo $rdm['Rdm']['nome']; ?></td>
		                  <td>
		                    <?php
		                      echo $this->Html->link($rdm['Rdm']['numero'],
		                            "http://www-sdm14/CAisd/pdmweb.exe?OP=SEARCH+SKIPLIST=1+FACTORY=chg+QBE.EQ.chg_ref_num=" . $rdm['Rdm']['numero'],
		                            array('target' => '_blank'));
		                    ?>
		                  </td>
		                  <td data-order=<?php echo $this->Times->CleanDate($rdm['Rdm']['dt_prevista']); ?>>
		                    <?php echo $this->Times->pastDate($rdm['Rdm']['dt_prevista']); ?>
		                  </td>
		                  <td>
		                    <?php
		                      //TODO: refatorar essa lógica
		                      if($rdm['Rdm']['sucesso'] == 2)
		                        echo $this->Rdm->sucesso($rdm['Rdm']['sucesso'], $rdm['Rdm']['dt_executada']);
		                      else
		                        echo (($rdm['Rdm']['dt_executada'] == null) ? " " : $this->Times->pastDate($rdm['Rdm']['dt_executada']));
		                    ?>
		                  </td>
											<td >
												<ul style="font-size:9px; margin: 0; padding: 0; font-size: 10px; list-style: none;">
													<li>
														<b>CAB</b>
		                        <span id="<?php echo "rdm-cab_approval-" . $rdm['Rdm']['id']?>">
		                          <?php echo $this->Rdm->getCheck($rdm['Rdm']['cab_approval']); ?>
		                        </span>
													</li>
													<li>
				                    <b>Autorizada</b>
				                    <span id="<?php echo "rdm-autorizada-" . $rdm['Rdm']['id']?>">
				                      <?php echo $this->Rdm->getCheck($rdm['Rdm']['autorizada']); ?>
				                    </span>
													</li>
													<li>
				                    <b>FARM</b>
				                    <span id="<?php echo "rdm-farm-" . $rdm['Rdm']['id']?>">
				                      <?php echo $this->Rdm->getCheck($rdm['Rdm']['farm']); ?>
				                    </span>
													</li>
												</ul>
		                  </td>
		                  <?php
												echo $this->Tables->RdmCheckEditable($rdm['Rdm']['id'], "rdms", 'cab_approval');
		                    echo $this->Tables->RdmCheckEditable($rdm['Rdm']['id'], "rdms", "autorizada");
		                    echo $this->Tables->RdmCheckEditable($rdm['Rdm']['id'], "rdms", "farm");
		                  ?>
		                  <td>
		                    <?php
		                      echo $this->Tables->getMenu('rdms', $rdm['Rdm']['id'], 14);
		                      echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $rdm['Rdm']['id'] . ",\"rdms\")'>
		                        <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
		                    ?>
		                  </td>
		                </tr>
		              <?php endforeach; ?>
		              <?php unset($rdm); ?>

		            </tbody>
		          </table>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Chamados -->
		<div role="tabpanel" class="tab-pane <?php if($this->Session->read('User.workspace') == 4) echo "active"; ?>" id="chamados">
		  <div class="col-lg-12">
		    <div class="panel panel-workspace">
		      <div class="panel-heading">
						<b> Lista de Chamados </b>
						<?php
							if($this->Ldap->autorizado(2)){
								echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
								array('controller' => 'chamados', 'action' => 'add'),
								array('style' => 'color: #3c763d; font-size: 16px;','escape' => false));
							}
						?>
					</div>
		      <div class="panel-body">
		        <div class="table-responsive">
		          <table class="table table-striped table-bordered table-hover" id="dataTables-chamado">
		            <thead>
		              <tr>
		                <th>Número <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
		                <th>Nome <i class="fa fa-comment-o" style="font-size: 15px !important;"></th>
		                <th>Tipo</th>
		                <th>Serviço</th>
		                <th>Aberto?</th>
		                <th>Pai?</th>
		                <th><span class="editable">Status</span></th>
										<th>Previsão</th>
		                <th></th>
		              </tr>
		            </thead>
		            <tbody>
		              <?php foreach ($chamados as $chamado): ?>
		                <tr>
		                  <td data-order=<?php echo $chamado['Chamado']['ano'] . $chamado['Chamado']['numero']; ?>>
		                    <?php
		                      echo $this->Html->link($chamado['Chamado']['numero'] . "/". $chamado['Chamado']['ano'],
		                      "http://www-sdm14/CAisd/pdmweb.exe?OP=SEARCH+FACTORY=in+SKIPLIST=1+QBE.IN.ref_num=" . $chamado['Chamado']['numero'] . "%25",
		                      array('target' => '_blank'));
		                    ?>
		                  </td>
		                  <td><?php echo $this->Tables->popupBox($chamado['Chamado']['nome'],$chamado['Chamado']['nome']); ?></td>
		                  <td><?php echo $chamado['ChamadoTipo']['nome']; ?></td>
		                  <td><?php echo $chamado['Servico']['nome']; ?></td>
		                  <td><?php echo $this->Times->yesOrNo($chamado['Chamado']['aberto'])?></td>
		                  <td><?php echo $this->Times->yesOrNo($chamado['Chamado']['pai'])?></td>
		                  <td>
		                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $chamado['Chamado']['id'] ?>"><?php echo $chamado['Status']['nome']; ?></span>
		                  </td>
		                  <?php echo $this->Tables->ChamadoStatusEditable($chamado['Chamado']['id']) ?>
											<td>
												<?php
														if($chamado['Status']['fim'] == null)
															echo $this->Times->timeLeftTo($chamado['Chamado']['created'], $chamado['Chamado']['dt_prev_resolv'],
																	$chamado['Chamado']['created'] . " - " . $chamado['Chamado']['dt_prev_resolv'], null);
														else {
															echo $this->Times->timeLeftTo($chamado['Chamado']['created'], $chamado['Chamado']['dt_prev_resolv'],
																	$chamado['Chamado']['created'] . " - " . $chamado['Chamado']['dt_prev_resolv'], $chamado['Chamado']['dt_resolv']);
														}
												?>
		                  </td>
		                  <td>
		                    <?php
		                      echo $this->Tables->getMenu('chamados', $chamado['Chamado']['id'], 10);
		                      if($this->Ldap->autorizado(2)){
		                        echo $this->Html->link(" <i class='fa fa-pencil'></i>",
		                                  array('controller' => 'chamados', 'action' => 'edit', $chamado['Chamado']['id'], '?' => array('controller' => '', 'action' => 'workspace' )),
		                                  array('escape' => false));
		                      }
		                      echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $chamado['Chamado']['id'] . ",\"chamados\")'>
		                        <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
		                    ?>
		                  </td>
		                </tr>
		              <?php endforeach; ?>
		              <?php unset($chamado); ?>
		            </tbody>
		          </table>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Indisponibilidades -->
		<div role="tabpanel" class="tab-pane <?php if($this->Session->read('User.workspace') == 5) echo "active"; ?>" id="indisponibilidades">
		  <div class="col-lg-12">
		    <div class="panel panel-workspace">
		      <div class="panel-heading">
		        <b>Indisponibilidades</b>
		        <?php
		          if($this->Ldap->autorizado(2)){
		            echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
		            array('controller' => 'indisponibilidades', 'action' => 'add'),
		            array('style' => 'color: #fff; font-size: 16px;','escape' => false));
		          }
		        ?>
		      </div>
		      <div class="panel-body">
		        <div class="table-responsive">
		          <table class="table table-striped table-bordered table-hover" id="dataTables-indisponibilidade">
		            <thead>
		              <tr>
		                <th>Serviço</th>
		                <th>Nº Evento   <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
		                <th>Nº Incidente   <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
		                <th>Início</th>
		        				<th>Motivo/Ambiente</th>
		                <th>Observação</th>
		                <th>Observação</th>
		        				<th><span class="editable">Status</span></th>
		                <th>Ações</th>
		              </tr>
		            </thead>
		            <tbody>
		              <?php foreach ($indisponibilidades as $indisponibilidade): ?>
		                <tr>
		                  <td class="area-list">
		                    <?php
		                        foreach($indisponibilidade['Servico'] as $servico):
		                          echo $this->Html->link($servico['sigla'] . "  ",
		                          array('controller' => 'servicos', 'action' => 'view', $servico['id']));
		                        endforeach;
		                    ?>
		                  </td>
		                  <td>
		                    <?php
		                      echo $this->Html->link($indisponibilidade['Indisponibilidade']['num_evento'],
		                            "http://www-sdm14/CAisd/pdmweb.exe?OP=SEARCH+FACTORY=in+SKIPLIST=1+QBE.IN.ref_num=" . $indisponibilidade['Indisponibilidade']['num_evento'] . "%25",
		                            array('target' => '_blank'));
		                    ?>
		                  </td>
		                  <td>
		                    <?php
		                      echo $this->Html->link($indisponibilidade['Indisponibilidade']['num_incidente'],
		                            "http://www-sdm14/CAisd/pdmweb.exe?OP=SEARCH+FACTORY=in+SKIPLIST=1+QBE.IN.ref_num=" . $indisponibilidade['Indisponibilidade']['num_incidente'] . "%25",
		                            array('target' => '_blank'));
		                    ?>
		                  </td>
		        				  <td data-order=<?php echo $this->Time->format('Ymd', $indisponibilidade['Indisponibilidade']['dt_inicio']); ?>>
		                    <?php echo $this->Time->format('d/m/Y H:i', $indisponibilidade['Indisponibilidade']['dt_inicio']); ?>
		                  </td>
		        				  <td>
		                    <?php echo $indisponibilidade['Motivo']['nome']; ?><br />
		                    <?php echo $this->Rdm->getAmbiente($indisponibilidade['Motivo']['ambiente']); ?>
		                  </td>
		                  <td><?php echo $this->Tables->popupBox($indisponibilidade['Indisponibilidade']['observacao']) ?></td>
		                  <td><?php echo $indisponibilidade['Indisponibilidade']['observacao']; ?></td>

		                  <td id="<?php echo $indisponibilidade['Indisponibilidade']['id']?>">
		                    <?php
		                      if($indisponibilidade['Indisponibilidade']['dt_fim'] == null):
		                        echo "<span class='label label-success'>Aberto</span>";
		                      else:
		                        echo "<span class='label label-default'>Fechado</span>";
		                      endif;
		                    ?>
		                  </td>
		                  <?php
		                    if($indisponibilidade['Indisponibilidade']['dt_fim'] == null)
		                      echo $this->Tables->StatusEditable($indisponibilidade['Indisponibilidade']['id'], "indisponibilidades");
		                  ?>
		                  <td>
												<?php
													echo $this->Tables->getMenu('Indisponibilidades', $indisponibilidade['Indisponibilidade']['id'], 14);
													echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $indisponibilidade['Indisponibilidade']['id'] . ",\"indisponibilidades\")'>
		                        <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
												?>
											</td>
		                </tr>
		              <?php endforeach; ?>
		              <?php unset($indisponibilidade); ?>
		            </tbody>
		          </table>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Demadas -->
	  <div role="tabpanel" class="tab-pane <?php if($this->Session->read('User.workspace') == 1 || $this->Session->read('User.workspace') == 0) echo "active"; ?>" id="demandas">
	    <div class="col-lg-12">
	      <div class="panel panel-workspace">
	        <div class="panel-heading">
						<b> Demandas </b>
						<?php
							if($this->Ldap->autorizado(2)){
								echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
								array('controller' => 'demandas', 'action' => 'add'),
								array('style' => 'color: #000; font-size: 16px;','escape' => false));
							}
						?>
					</div>
	        <div class="panel-body">
	          <div class="table-responsive">
	            <table class="table table-striped table-bordered table-hover" id="dataTables-demanda">
	              <thead>
	                <tr>
	                  <th>Serviço</th>
	                  <th class="hidden-xs hidden-sm"><span class="editable">Prioridade</span></th>
	                  <th class="hidden-xs hidden-sm">Clarity DM <i class='fa-expand fa' style="font-size: 15px !important;"></i></th>
	                  <th class="hidden-xs hidden-sm">Mantis <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
	                  <th>Título <i class="fa fa-comment-o" style="font-size: 15px !important;"></i></th>
	                  <th>Nome</th>

	  				        <th>Tipo da Demanda</th>
	                  <th>Prazo</th>
	                  <th><span class="editable">Status</span></th>
	                  <th>Solicitada pelo Cliente?</th>
	                  <th></th>
	                </tr>
	              </thead>
	              <tbody>
	                <?php foreach ($demandas as $demanda): ?>
	                  <tr>
	                    <td><?php echo $this->Html->link($demanda['Servico']['sigla'], array('controller' => 'servicos', 'action' => 'view', $demanda['Servico']['id'])); ?></td>
	                    <td class="hidden-xs hidden-sm">
	                      <span style="cursor:pointer;" title="Clique para alterar a prioridade!" id="<?php echo $demanda['Demanda']['id']?>"><?php echo $demanda['Demanda']['prioridade']; ?></span>
	                    </td>
	                    <?php echo $this->Tables->PrioridadeEditable($demanda['Demanda']['id'], "demandas") ?>
	                    <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!">
	                      <?php
	                        echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
	                              $demanda['Demanda']['clarity_id'] .")'>" . $demanda['Demanda']['clarity_dm_id'] ."</a></span>"
	                      ?>
	                    </td>
	                    <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Mantis!">
	                      <?php echo $this->Html->link($demanda['Demanda']['mantis_id'],"http://www-testes/view.php?id=" . $demanda['Demanda']['mantis_id'], array('target' => '_blank')); ?>
	                    </td>
	                    <td><?php echo $this->Tables->popupBox($demanda['Demanda']['nome'], $demanda['Demanda']['descricao']) ?></td>
	                    <td><?php echo $demanda['Demanda']['nome']; ?></td>
	  				          <td style="max-width: 110px;"><div class="tipo-demanda"><?php echo $demanda['DemandaTipo']['nome']; ?></div></td>

	                    <td class="text-center">
	                      <?php echo $this->Times->timeLeftTo($demanda['Demanda']['data_cadastro'], $demanda['Demanda']['dt_prevista'],
	                               $demanda['Demanda']['data_cadastro'] . " - " . $demanda['Demanda']['dt_prevista'],
	                              ($demanda['Demanda']['data_homologacao']));
	                      ?>
	                    </td>
	                    <td>
	                      <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $demanda['Demanda']['id'] ?>">
	                        <?php echo $demanda['Status']['nome']; ?>
	                      </span>
	                    </td>
	                    <?php echo $this->Tables->DemandaStatusEditable($demanda['Demanda']['id'], "demandas") ?>
	                    <td><?php echo $this->Times->yesOrNo($demanda['Demanda']['origem_cliente']); ?></td>
	                    <td>
	                      <?php
	                        echo $this->Tables->getMenu('demandas', $demanda['Demanda']['id'], 14);
	                        echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $demanda['Demanda']['id'] . ",\"demandas\")'>
	                          <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
	                      ?>
	                    </td>
	                  </tr>
	                <?php endforeach; ?>
	                <?php unset($demanda); ?>
	              </tbody>
	            </table>
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>

		<!-- Subtarefas de Demanda -->
		<div role="tabpanel" class="tab-pane <?php if($this->Session->read('User.workspace') == 2) echo "active"; ?>" id="subtarefas">
			<div class="col-lg-12">
				<div class="panel panel-workspace">
					<div class="panel-heading">
						<b> Tarefas </b>
						<?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'subtarefas', 'action' => 'add'),
                array('escape' => false));
              }
            ?>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dataTables-subtarefas">
								<thead>
									<tr>
										<th>Servico</th>
										<th>Atividade</th>
										<th>Tarefa</th>
										<th>Prazo</th>
										<th><span class="editable">Finalizar</span></th>
										<th>Ações</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($subtarefas as $sub): ?>
										<tr>
											<td><?php echo $sub['Servico']['sigla'] ?></td>
											<td>
												<?php
													if(isset($sub['Demanda']['clarity_dm_id']))
														echo $this->Html->link($sub['Demanda']['clarity_dm_id'],array('controller' => 'Demandas', 'action' => 'view', $sub['Demanda']['id']));
													elseif(isset($sub['Chamado']['numero']))
														echo $this->Html->link("Chamado: " . $sub['Chamado']['numero'] . "/" . $sub['Chamado']['ano'], array('controller' => 'Chamados', 'action' => 'view', $sub['Chamado']['id']));
													elseif(isset($sub['Rdm']['numero']))
														echo $this->Html->link("RDM: " . $sub['Rdm']['numero'] . "/" . $sub['Rdm']['ano'], array('controller' => 'rdms', 'action' => 'view', $sub['Rdm']['id']));
													elseif(isset($sub['Release']['id']))
														echo $this->Html->link("Release: " . $sub['Release']['versao'], array('controller' => 'releases', 'action' => 'view', $sub['Release']['id']));
													else
														echo " --- ";
												?>
											</td>
											<td><?php echo $sub['Subtarefa']['descricao']; ?></td>
											<td class="text-center">
		                    <?php echo $this->Times->timeLeftTo($sub['Subtarefa']['created'], $sub['Subtarefa']['dt_prevista'],
		                             date("d/m/Y", strtotime($sub['Subtarefa']['created'])) . " - " . $sub['Subtarefa']['dt_prevista'],null);
		                    ?>
		                  </td>
											<td id="<?php echo "sub-" . $sub['Subtarefa']['id']?>">
												<?php
													if($sub['Subtarefa']['check'] == 0):
														echo "<span class='label label-success'>Em andamento</span>";
													else:
														echo "<span class='label label-default'>Finalizada</span>";
													endif;
												?>
											</td>
											<?php
												echo $this->Tables->SubtarefaStatusEditable($sub['Subtarefa']['id'], "subtarefas");
											?>
											<td>
												<?php echo $this->Tables->getMenu('Subtarefas', $sub['Subtarefa']['id'],12); ?>
											</td>
										</tr>
									<?php endforeach; ?>
									<?php unset($sub); ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>
        <div class="modal-body" id="modal-body">
        </div>
      </div>
    </div>
  </div>
  <iframe id="demandaFrame" style="display:none;" name='demanda' width='100%' height='720px' frameborder='0'></iframe>

  <div class="modal fade" id="Historico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        </div>
        <div class="modal-body" id="modal-body">
          <iframe id="historicoFrame" name='demanda' width='100%' height='720px' frameborder='0'></iframe>
        </div>
      </div>
    </div>
  </div>
<?php else:  ?>
<div class="container">
	<div class="error">
		<div class="well">
			<h3 class="page-header"><i class="fa red fa-user-times"></i> Usuário não encontrado no SGS </h3>
			<br />
			<h4>Tente um dos seguintes procedimentos:</h4>
			<div class="well">
				<ul class="list-unstyled spaced">
					<li>
						<i class="ace-icon fa fa-hand-o-right blue"></i>
						Recarregue a página. Sua sessão pode ter expirado.
					</li>

					<li>
						<i class="ace-icon fa fa-hand-o-right blue"></i>
						Entre em Contato com os administradores do SGS para criar o seu cadastro.
					</li>

				</ul>
				<br />
				<b>Veja o que você está perdendo ao não usar o nosso workspace:</b>
				<?php echo $this->Html->image('workspace.png', array('alt' => 'Visualização do workspace', 'class' => "img-responsive", 'style' => 'margin-top:10px;')); ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php
  //-- ClarityID
  echo $this->Html->script('getIdClarity.js');

  //-- DataTables JavaScript --
  echo $this->Html->script('plugins/dataTables/media/js/jquery.dataTables.js');
  echo $this->Html->script('plugins/dataTables/dataTables.bootstrap.js');
  echo $this->Html->css('plugins/dataTables.bootstrap.css');
    //-- DataTables --> TableTools
    echo $this->Html->script('plugins/dataTables/extensions/TableTools/js/dataTables.tableTools.min.js');
    echo $this->Html->css('plugins/dataTablesExtensions/TableTools/css/dataTables.tableTools.min.css');
    //-- DataTables --> Responsive
    echo $this->Html->script('plugins/dataTables/extensions/Responsive/js/dataTables.responsive.min.js');
    echo $this->Html->css('plugins/dataTablesExtensions/Responsive/css/dataTables.responsive.css');
    //-- DataTables --> ColVis
      echo $this->Html->script('plugins/dataTables/extensions/ColVis/js/dataTables.colVis.min.js');
      echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colVis.min.css');
      echo $this->Html->css('plugins/dataTablesExtensions/ColVis/css/dataTables.colvis.jqueryui.css');

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');

  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');

  //Select2
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->css('plugins/select2-bootstrap');
?>

<script>
	$('a[aria-controls="demandas"]').on('shown.bs.tab', function (e) {
		if(typeof oTable == 'undefined'){
			<?php if($this->Session->read('User.workspace') != 1) $this->Workspace->dataTable(1); ?>
		}
	});

	$('a[aria-controls="subtarefas"]').on('shown.bs.tab', function (e) {
		if(typeof oTablesubtarefa == 'undefined'){
			<?php $this->Workspace->dataTable(2); ?>
		}
	});

	$('a[aria-controls="rdms"]').on('shown.bs.tab', function (e) {
		if(typeof oTableRdm == 'undefined'){
			<?php $this->Workspace->dataTable(3); ?>
		}
	});

	$('a[aria-controls="chamados"]').on('shown.bs.tab', function (e) {
		if(typeof oTablechamado == 'undefined'){
			<?php $this->Workspace->dataTable(4); ?>
		}
	});

	$('a[aria-controls="indisponibilidades"]').on('shown.bs.tab', function (e) {
		if(typeof oTableIndis == 'undefined'){
		 		<?php $this->Workspace->dataTable(5); ?>
		}
	});

  $(document).ready(function() {

		<?php $this->Workspace->dataTable($this->Session->read('User.workspace')); ?>

		  $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'right', html: 'true'});

      $("[id*='filterDt']").datetimepicker({
        format: "yyyy-mm-dd",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
      });

      $('#myModal').on('shown.bs.modal', function (e) {
        document.getElementById('modal-body').appendChild(
            document.getElementById('demandaFrame')
        );
        document.getElementById('demandaFrame').style.display = "block";
      });
	});

  function historico(id, controller){
    document.getElementById('historicoFrame').src = "<?php echo(Router::url('/', true). "historicos/popup?");?>" + "controller=" + controller + "&id=" + id;
  }
</script>

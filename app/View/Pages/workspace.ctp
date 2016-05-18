<div class="row">
		<div class="col-lg-12"><h3 class="page-header">Bem Vindo ao SGD! - <?php echo $this->Session->read('User.nome'); ?></h3></div>
		<?php if($this->Session->read('User.uid') != 0): ?>
			<div class="col-lg-12"><h6>Tarefas sob a sua responsabilidade:</h6></div>
		<?php endif;?>
</div>

<div class="row">
<?php if($this->Session->read('User.uid') != 0): ?>
	<div class="col-lg-12">
		<ul class="nav nav-tabs nav-tabs-black nav-tabs-pages" role="tablist">
			<li role="presentation"><a href="#sses" aria-controls="sses" role="tab" data-toggle="tab">
				SS <span class="badge"><?php echo sizeof($sses) ?></span></a>
			</li>
			<li role="presentation"><a href="#pes" aria-controls="pes" role="tab" data-toggle="tab">
				PA <span class="badge"><?php echo sizeof($pes) ?></span></a>
			</li>
			<li role="presentation"><a href="#ords" aria-controls="ords" role="tab" data-toggle="tab">
				OS <span class="badge"><?php echo sizeof($ords) ?></span></a>
			</li>
		  <li role="presentation" class="active"><a href="#demandas" aria-controls="demandas" role="tab" data-toggle="tab">
				Demandas Internas <span class="badge"><?php echo sizeof($demandas) ?></span></a>
			</li>
			<li role="presentation"><a href="#subtarefas" aria-controls="subtarefas" role="tab" data-toggle="tab">
				Tarefas <span class="badge"><?php echo sizeof($subtarefas) ?></span></a>
			</li>
		  <li role="presentation"><a href="#rdms" aria-controls="rdms" role="tab" data-toggle="tab">
				RDMs <span class="badge"><?php echo sizeof($rdms) ?></span></a>
			</li>
		  <li role="presentation"><a href="#chamados" aria-controls="chamados" role="tab" data-toggle="tab">
				Chamados <span class="badge"><?php echo sizeof($chamados) ?></span></a>
			</li>
			<li role="presentation"><a href="#indisponibilidades" aria-controls="indisponibilidades" role="tab" data-toggle="tab">
				Indisponibilidades <span class="badge"><?php echo sizeof($indisponibilidades) ?></span></a>
			</li>
		</ul>
	</div>

	<div class="tab-content">
		<!-- SSes -->
		<div role="tabpanel" class="tab-pane" id="sses">
		  <div class="col-lg-12">
		    <div class="panel panel-primary">
		      <div class="panel-heading">
						<b> Lista de SS sob sua responsabilidade</b>
	           <?php
	              if($this->Ldap->autorizado(2)){
	                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
	                array('controller' => 'sses', 'action' => 'add'),
	                array('style' => 'color: #fff; font-size: 16px;','escape' => false));
	              }
	           ?>
	        </div>
		      <div class="panel-body">
		        <div class="table-responsive">
		          <table class="table table-striped table-bordered table-hover" id="dataTables-ss">
		            <thead>
		              <tr>
		                <th>Servico</th>
		                <th class="hidden-xs hidden-sm"><span class="editable">Prioridade</span></th>
		                <th class="hidden-xs hidden-sm">DM Clarity <i class='fa-expand fa' style="font-size: 15px !important;"></i></th>
		                <th>Número</th>
		                <th>Nome <i class="fa fa-comment-o" style="font-size: 15px !important;"></th>
		                <th>Nome</th>
		                <th>Prazo</th>
		                <th class="hidden-xs hidden-sm"><span class="editable">Status</span></th>
		                <th class="hidden-xs hidden-sm">CheckList <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
		                <th>Ações</th>
		              </tr>
		            </thead>
		            <tbody>
		              <?php foreach ($sses as $ss): ?>
		                <tr>
		                  <td><?php echo $this->Html->link($ss['Servico']['sigla'], array('controller' => 'servicos', 'action' => 'view', $ss['Servico']['id'])); ?></td>
		                  <td class="hidden-xs hidden-sm">
		                    <span style="cursor:pointer;" title="Clique para alterar a prioridade!" id="<?php echo $ss['Ss']['id'];?>"><?php echo $ss['Ss']['prioridade']; ?></span>
		                  </td>
		                  <?php echo $this->Tables->PrioridadeEditable($ss['Ss']['id'], "sses") ?>

		                  <td class="hidden-xs hidden-sm" style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!">
		                      <?php echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
		                                 $ss['Ss']['clarity_id'] .")'>" . $ss['Ss']['clarity_dm_id'] ."</a></span>" ?>
		                  </td>

		                  <td data-order=<?php echo $ss['Ss']['ano'] . $ss['Ss']['numero']; ?>>
		                    <?php echo $ss['Ss']['numero'] . "/" . $ss['Ss']['ano'] ; ?>
		                  </td>
		                  <td><?php echo $this->Tables->popupBox($ss['Ss']['nome'], $ss['Ss']['observacao']) ?></td>
		                  <td><?php echo $ss['Ss']['nome']; ?></td>

		                  <td class="text-center">
		                    <?php echo $this->Times->timeLeftTo($ss['Ss']['dt_recebimento'], $ss['Ss']['dt_prazo'],
		                             $ss['Ss']['dt_recebimento'] . " - " . $ss['Ss']['dt_prazo'],
		                            ($ss['Ss']['dt_finalizada']));
		                    ?>
		                  </td>

		                  <td class="hidden-xs hidden-sm">
		                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $ss['Ss']['id'] ?>">
		                    <?php echo $ss['Status']['nome']; ?></span>
		                  </td>
		                  <?php echo $this->Tables->SsStatusEditable($ss['Ss']['id']) ?>

		                  <td class="checklist hidden-xs hidden-sm"><?php echo $this->Ss->getCheckList($ss['Ss']['dv'], $ss['Ss']['contagem']) ?></td>
		                  <td>
		                    <?php
		                      echo $this->Tables->getMenu('sses', $ss['Ss']['id'], 14);
		                      echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $ss['Ss']['id'] . ",\"sses\")'>
		                        <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
		                    ?>
		                  </td>
		                </tr>
		              <?php endforeach; ?>
		              <?php unset($ss); ?>

		            </tbody>
		          </table>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- PE -->
		<div role="tabpanel" class="tab-pane" id="pes">
			<div class="col-lg-12">
		    <div class="panel panel-info">
		      <div class="panel-heading">
						<b> Lista de PA </b>
					</div>
		      <div class="panel-body">
		        <div class="table-responsive">
		          <table class="table table-striped table-bordered table-hover" id="dataTables-pes">
		            <thead>
		              <tr>
		                <th>Serviço</th>
		                <th>Número da PA <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
		                <th>Número da CE</th>
		                <th>Nome da SS <i class="fa fa-comment-o" style="font-size: 15px !important;"></i></th>
		                <th>Nome da SS</i></th>
		                <th>Validade do PDD</th>
		                <th><span class="editable">Status</span></th>
		                <th>Ações</th>
		              </tr>
		            </thead>
		            <tbody>
		              <?php foreach ($pes as $pe): ?>
		                <tr>
		                  <td><?php echo $pe['Servico']['sigla']; ?></td>
		                  <td data-order=<?php echo $pe['Pe']['ano'] . $pe['Pe']['numero']; ?>>
		                    <?php echo $this->Html->link(($pe['Pe']['numero'] . "/" . $pe['Pe']['ano']), $pe['Pe']['cvs_url']); ?>
		                  </td>
		                  <td><?php echo $pe['Pe']['num_ce']; ?></td>
		                  <td>
		                    <?php
		                      echo $this->Html->link($this->Tables->popupBox($pe['Ss']['nome'],$pe['Ss']['observacao']),
		                           array('controller' => 'sses', 'action' => 'view', $pe['Ss']['id']), array('escape' => false)); ?>
		                  </td>
		                  <td><?php echo $pe['Ss']['nome']; ?></td>
		                  <td data-order=<?php echo $this->Times->CleanDate($pe['Pe']['validade_pdd']); ?>>
		                    <?php
		                      if($pe['Pe']['validade_pdd'] != null){
		                        echo $this->Times->pastDate($pe['Pe']['validade_pdd']);
		                      }
		                    ?>
		                  </td>
		                  <td>
		                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "statuspa-" . $pe['Pe']['id'] ?>">
		                    <?php echo $pe['Status']['nome']; ?></span>
		                  </td>
		                  <?php echo $this->Tables->PeStatusEditable($pe['Pe']['id']) ?>
		                  <td>
		                    <?php
		                      echo $this->Tables->getMenu('pes', $pe['Pe']['id'], 14);
		                      echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $pe['Pe']['id'] . ")'>
		                        <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
		                    ?>
		                  </td>
		                </tr>
		              <?php endforeach; ?>
		              <?php unset($pe); ?>

		            </tbody>
		          </table>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- ORDs -->
		<div role="tabpanel" class="tab-pane" id="ords">
		  <div class="col-lg-12">
		    <div class="panel panel-warning">
		      <div class="panel-heading"><b> Lista de OS </b></div>
		      <div class="panel-body">
		        <div class="table-responsive">
		          <table class="table table-striped table-bordered table-hover" id="dataTables-ords">
		            <thead>
		              <tr>
		                <th>Serviço</th>
		                <th>Número <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
		                <th>Nome da SS <i class="fa fa-comment-o" style="font-size: 15px !important;"></i></th>
		                <th>Nome da SS</i></th>
		                <th>Prazo</th>
		                <th><span class="editable">Status</span></th>
		                <th>Termos <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
		                <th>Ações</th>
		              </tr>
		            </thead>
		            <tbody>
		              <?php foreach ($ords as $ord): ?>
		                <tr>
		                  <td><?php echo $ord['Servico']['sigla']; ?></td>
		                  <td data-order=<?php echo $ord['Ord']['ano'] . $ord['Ord']['numero']; ?>>
		                    <?php echo $this->Html->link($ord['Ord']['numero'] . "/" . $ord['Ord']['ano'], $ord['Ord']['cvs_url']); ?>
		                  </td>
		                  <td>
		                    <?php
		                      echo $this->Html->link($this->Tables->popupBox($ord['Ss']['nome'],$ord['Ss']['observacao']),
		                           array('controller' => 'sses', 'action' => 'view', $ord['Ss']['id']), array('escape' => false)); ?>
		                  </td>
		                  <td><?php echo $ord['Ss']['nome']; ?></td>
		                  <td class="text-center">
		                    <?php
		                      if($ord['Ord']['dt_ini_pdd'] != null){
		                        echo $this->Times->timeLeftTo($ord['Ord']['dt_ini_pdd'], $ord['Ord']['dt_fim_pdd'],
		                              $ord['Ord']['dt_ini_pdd'] . " - " . $ord['Ord']['dt_fim_pdd'],
		                              ($ord['Ord']['dt_homologacao']));
		                      }
		                    ?>
		                  </td>

		                  <td>
		                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "statusos-" . $ord['Ord']['id'] ?>">
		                    <?php echo $ord['Status']['nome']; ?></span>
		                  </td>
		                  <?php echo $this->Tables->OrdStatusEditable($ord['Ord']['id']) ?>

		                  <td class="checklist">
		                    <?php
		                      echo $this->Ord->getCheckList($ord['Ord']['ths'], $ord['Ord']['trp'], $ord['Ord']['trd']) . "<br />";
		                      if(isset($ord['Ord']['dt_homologacao']))
		                        echo $this->Ord->PrazocheckList($ord['Ord']['dt_homologacao'], $ord['Ord']['trp'], $ord['Ord']['dt_recebimento_termo_prov'],
		                           $ord['Ord']['ths'], $ord['Ord']['dt_recebimento_homo'],
		                           $ord['Ord']['trd'], $ord['Ord']['dt_recebimento_termo']);
		                    ?>
		                  </td>
		                  <td>
		                    <?php
		                      echo $this->Tables->getMenu('ords', $ord['Ord']['id'], 14);
		                      echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $ord['Ord']['id'] . ")'>
		                        <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
		                    ?>
		                  </td>
		                </tr>
		              <?php endforeach; ?>
		              <?php unset($ord); ?>

		            </tbody>
		          </table>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- RDMs -->
		<div role="tabpanel" class="tab-pane" id="rdms">
		  <div class="col-lg-12">
		    <div class="panel panel-danger">
		      <div class="panel-heading">
						<b>RDMs sob a sua responsabilidade</b>
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
		                            "http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH+SKIPLIST=1+FACTORY=chg+QBE.EQ.chg_ref_num=" . $rdm['Rdm']['numero'],
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
											<td>
		                    <b>Autorizada</b>
		                    <span id="<?php echo "rdm-autorizada-" . $rdm['Rdm']['id']?>">
		                      <?php echo $this->Rdm->getCheck($rdm['Rdm']['autorizada']); ?>
		                    </span>
		                    <b>FARM</b>
		                    <span id="<?php echo "rdm-farm-" . $rdm['Rdm']['id']?>">
		                      <?php echo $this->Rdm->getCheck($rdm['Rdm']['farm']); ?>
		                    </span>
		                  </td>
		                  <?php
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
		<div role="tabpanel" class="tab-pane" id="chamados">
		  <div class="col-lg-12">
		    <div class="panel panel-success">
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
		                <th></th>
		              </tr>
		            </thead>
		            <tbody>
		              <?php foreach ($chamados as $chamado): ?>
		                <tr>
		                  <td data-order=<?php echo $chamado['Chamado']['ano'] . $chamado['Chamado']['numero']; ?>>
		                    <?php
		                      echo $this->Html->link($chamado['Chamado']['numero'] . "/". $chamado['Chamado']['ano'],
		                      "http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH+FACTORY=in+SKIPLIST=1+QBE.IN.ref_num=" . $chamado['Chamado']['numero'] . "%25",
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
		<div role="tabpanel" class="tab-pane" id="indisponibilidades">
		  <div class="col-lg-12">
		    <div class="panel panel-purple">
		      <div class="panel-heading">
		        <b>Indisponibilidades sob a sua responsabilidade</b>
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
		                            "http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH+FACTORY=in+SKIPLIST=1+QBE.IN.ref_num=" . $indisponibilidade['Indisponibilidade']['num_evento'] . "%25",
		                            array('target' => '_blank'));
		                    ?>
		                  </td>
		                  <td>
		                    <?php
		                      echo $this->Html->link($indisponibilidade['Indisponibilidade']['num_incidente'],
		                            "http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH+FACTORY=in+SKIPLIST=1+QBE.IN.ref_num=" . $indisponibilidade['Indisponibilidade']['num_incidente'] . "%25",
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
		                  <td><?php echo $this->Tables->getMenu('Indisponibilidades', $indisponibilidade['Indisponibilidade']['id'], 14); ?></td>
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

		<!-- Demadas Internas -->
	  <div role="tabpanel" class="tab-pane active" id="demandas">
	    <div class="col-lg-12">
	      <div class="panel panel-default">
	        <div class="panel-heading">
						<b> Demandas internas sob a sua responsabilidade </b>
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
		<div role="tabpanel" class="tab-pane" id="subtarefas">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<b> Tarefas de Demandas internas sob a sua responsabilidade </b>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="dataTables-subtarefas">
								<thead>
									<tr>
										<th>Demanda/Servico</th>
										<th>Tarefa</th>
										<th>Prazo</th>
										<th><span class="editable">Finalizar</span></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($subtarefas as $sub): ?>
										<tr>
											<td><?php echo $this->Html->link($sub['Demanda']['clarity_dm_id']." / ".$sub['Demanda']['Servico']['sigla'],
		                       array('controller' => 'Demandas', 'action' => 'view', $sub['Demanda']['id'])); ?></td>
											<td><?php echo $sub['Subtarefa']['descricao']; ?></td>
											<td class="text-center">
		                    <?php echo $this->Times->timeLeftTo($sub['Subtarefa']['created'], $sub['Subtarefa']['dt_prevista'],
		                             $sub['Subtarefa']['created'] . " - " . $sub['Subtarefa']['dt_prevista'],null);
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

	<div class="error">
		<div class="well">
			<h3 class="page-header"><i class="fa red fa-user-times"></i> Usuário não encontrado no SGD </h3>
			<br />
			<b>Tente um dos seguintes procedimentos:</b>
			<div class="well">
				<ul class="list-unstyled spaced">
					<li>
						<i class="ace-icon fa fa-hand-o-right blue"></i>
						Recarregue a página. Sua sessão pode ter expirado.
					</li>

					<li>
						<i class="ace-icon fa fa-hand-o-right blue"></i>
						Entre em Contato com os administradores do SGD para criar o seu cadastro.
					</li>

				</ul>
			</div>
		</div>
	</div>
<?php endif; ?>
</div>

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
	$('a[aria-controls="ords"]').on('shown.bs.tab', function (e) {
		if(typeof oTableOrd == 'undefined'){
			oTableOrd =  $('#dataTables-ords').dataTable({
				"lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "Todos"]],
					language: {
						url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
					},
					"columnDefs": [  { "visible": false, "targets": 3 } ],
					"dom": 'TC<"clear">lfrtip',
					"colVis": {
						"buttonText": "Esconder Colunas"
					},
					"tableTools": {
							"sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
							"aButtons": [
								{
										"sExtends": "copy",
										"sButtonText": "Copiar",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"mColumns": [ 0,1,3,4,5,6]
								},
								{
										"sExtends": "print",
										"sButtonText": "Imprimir"
								},
								{
										"sExtends": "csv",
										"sButtonText": "CSV",
										"sFileName": "Ordens de Serviço.csv",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"mColumns": [ 0,1,3,4,5,6]
								},
								{
										"sExtends": "pdf",
										"sButtonText": "PDF",
										"sFileName": "Ordens de Serviço.pdf",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"sPdfOrientation": "landscape",
										"mColumns": [ 0,1,3,4,5,6],
										"sTitle": "Listagem de Ordens de Serviço",
										"sPdfMessage": "Extraído em: <?php echo date('d/m/y')?>",
								},
							]
					}
			});
			var colvis = new $.fn.dataTable.ColVis( oTableOrd );
		}
	});

	$('a[aria-controls="rdms"]').on('shown.bs.tab', function (e) {
		if(typeof oTableRdm == 'undefined'){
			oTableRdm =  $('#dataTables-rdm').dataTable({
					"lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "Todos"]],
						language: {
							url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
						},
						"columnDefs": [  { "visible": false, "targets": 6 } ],
						"dom": 'TC<"clear">lfrtip',
						"order": [[ 8, "desc" ]],
						"colVis": {
							"buttonText": "Esconder Colunas"
						},
						"tableTools": {
								"sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
								"aButtons": [
									{
											"sExtends": "copy",
											"sButtonText": "Copiar",
											"oSelectorOpts": { filter: 'applied', order: 'current' },
											"mColumns": [ 0,1,2,3,4,6,7,8,9 ]
									},
									{
											"sExtends": "print",
											"sButtonText": "Imprimir",
											"oSelectorOpts": { filter: 'applied', order: 'current' },
											"mColumns": [ 0,1,2,3,4,6,7,8,9 ]
									},
									{
											"sExtends": "csv",
											"sButtonText": "CSV",
											"sFileName": "RDM.csv",
											"oSelectorOpts": { filter: 'applied', order: 'current' },
											"mColumns": [ 0,1,2,3,4,6,7,8,9 ]
									},
									{
											"sExtends": "pdf",
											"sButtonText": "PDF",
											"sFileName": "RDM.pdf",
											"oSelectorOpts": { filter: 'applied', order: 'current' },
											"mColumns": [ 0,1,2,3,4,7,8,9 ],
											"sPdfOrientation": "landscape",
											"sTitle": "Requisições de Mudança",
											"sPdfMessage": "<?php echo date('d/m/y')?>",
									},
								]
						}
				});
				var colvis = new $.fn.dataTable.ColVis( oTableRdm );
			}
	});

	$('a[aria-controls="pes"]').on('shown.bs.tab', function (e) {
			if(typeof oTablepes == 'undefined'){
				oTablepes = $('#dataTables-pes').dataTable({
				"lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "Todos"]],
					language: {
						url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
					},
					"columnDefs": [  { "visible": false, "targets": 4 } ],
					"dom": 'TC<"clear">lfrtip',
					"colVis": {
						"buttonText": "Esconder Colunas"
					},
					"tableTools": {
							"sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
							"aButtons": [
								{
										"sExtends": "copy",
										"sButtonText": "Copiar",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"mColumns": [ 0,1,2,4,5,6 ]
								},
								{
										"sExtends": "print",
										"sButtonText": "Imprimir"
								},
								{
										"sExtends": "csv",
										"sButtonText": "CSV",
										"sFileName": "Propostas de Atendimento.csv",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"mColumns": [ 0,1,2,4,5,6 ]
								},
								{
										"sExtends": "pdf",
										"sButtonText": "PDF",
										"sFileName": "Propostas de Atendimento.pdf",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"sPdfOrientation": "landscape",
										"mColumns": [ 0,1,2,4,5,6 ],
										"sTitle": "Listagem de Propostas de Atendimento",
										"sPdfMessage": "<?php echo date('d/m/y')?>",
								},
							]
					}
			});
			var colvis = new $.fn.dataTable.ColVis( oTablepes );
		}
	});

	$('a[aria-controls="sses"]').on('shown.bs.tab', function (e) {
		if(typeof oTablesses == 'undefined'){
		 	oTablesses =  $('#dataTables-ss').dataTable({
	      "lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "Todos"]],
	        language: {
	          url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
	        },
	        "columnDefs": [  { "visible": false, "targets": 5 } ],
	        "dom": 'TC<"clear">lfrtip',
	        "colVis": {
	          "buttonText": "Esconder Colunas"
	        },
	        "tableTools": {
	            "sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
	            "aButtons": [
	              {
	                  "sExtends": "copy",
	                  "sButtonText": "Copiar",
	                  "oSelectorOpts": { filter: 'applied', order: 'current' },
	                  "mColumns": [ 0,1,2,3,5,6,7,8 ]
	              },
	              {
	                  "sExtends": "print",
	                  "sButtonText": "Imprimir",
	                  "oSelectorOpts": { filter: 'applied', order: 'current' },
	                  "mColumns": [ 0,1,2,3,5,6,7,8 ]
	              },
	              {
	                  "sExtends": "csv",
	                  "sButtonText": "CSV",
	                  "sFileName": "SS.csv",
	                  "oSelectorOpts": { filter: 'applied', order: 'current' },
	                  "mColumns": [ 0,1,2,3,5,6,7,8 ]
	              },
	              {
	                  "sExtends": "pdf",
	                  "sButtonText": "PDF",
	                  "sFileName": "SS.pdf",
	                  "oSelectorOpts": { filter: 'applied', order: 'current' },
	                  "sPdfOrientation": "landscape",
	                  "mColumns": [ 0,1,2,3,6,7,8 ],
	                  "sTitle": "Listagem de Solicitações de Serviço",
	                  "sPdfMessage": "<?php echo date('d/m/y')?>",
	              },
	            ]
	        }
	    });
	    var colvis = new $.fn.dataTable.ColVis( oTablesses );
		}
	});

	$('a[aria-controls="indisponibilidades"]').on('shown.bs.tab', function (e) {
		if(typeof oTableIndis == 'undefined'){
		 		oTableIndis =  $('#dataTables-indisponibilidade').dataTable({
				"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "Todos"]],
					language: {
						url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
					},
				//  responsive: true,
					"columnDefs": [  { "visible": false, "targets": 7 } ],
					"dom": 'TC<"clear">lfrtip',
					"colVis": {
						"buttonText": "Esconder Colunas"
					},
					"tableTools": {
							"sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
							"aButtons": [
								{
										"sExtends": "copy",
										"sButtonText": "Copiar",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"mColumns": [ 0,1,2,3,4,5,7,8 ]
								},
								{
										"sExtends": "print",
										"sButtonText": "Imprimir",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"mColumns": [ 0,1,2,3,4,5,7,8 ]
								},
								{
										"sExtends": "csv",
										"sButtonText": "CSV",
										"sFileName": "Indisponibilidades.csv",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"mColumns": [ 0,1,2,3,4,5,7,8 ]
								},
								{
										"sExtends": "pdf",
										"sButtonText": "PDF",
										"sFileName": "Indisponibilidades.pdf",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"mColumns": [ 0,1,2,3,4,5,7,8 ],
										"sPdfOrientation": "landscape",
										"sTitle": "Controle de Disponibilidade",
										"sPdfMessage": "Extraído em: <?php echo date('d/m/y')?>",
								},
							]
					}
			});
			var colvis = new $.fn.dataTable.ColVis( oTableoTableIndis );
		}
	});

	$('a[aria-controls="chamados"]').on('shown.bs.tab', function (e) {
		if(typeof oTablechamado == 'undefined'){
			oTablechamado = $('#dataTables-chamado').dataTable({
	        "lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "Todos"]],
	        language: {
	          url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
	        },
	        "dom": 'TC<"clear">lfrtip',
	        "colVis": {
	          "buttonText": "Esconder Colunas"
	        },
	        "tableTools": {
	            "sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
	            "aButtons": [
	              {
	                  "sExtends": "copy",
	                  "sButtonText": "Copiar",
	                  "oSelectorOpts": { filter: 'applied', order: 'current' },
	                  "mColumns": [ 0,1,2,3,4,5,6 ]
	              },
	              {
	                  "sExtends": "print",
	                  "sButtonText": "Imprimir",
	                  "oSelectorOpts": { filter: 'applied', order: 'current' },
	                  "mColumns": [ 0,1,2,3,4,5,6 ]
	              },
	              {
	                  "sExtends": "csv",
	                  "sButtonText": "CSV",
	                  "sFileName": "Chamados.csv",
	                  "oSelectorOpts": { filter: 'applied', order: 'current' },
	                  "mColumns": [ 0,1,2,3,4,5,6 ]
	              },
	              {
	                  "sExtends": "pdf",
	                  "sButtonText": "PDF",
	                  "sFileName": "Chamados.pdf",
	                  "oSelectorOpts": { filter: 'applied', order: 'current' },
	                  "sPdfOrientation": "landscape",
	                  "mColumns": [ 0,1,2,3,4,5,6 ],
	                  "sTitle": "Listagem de Chamados",
	                  "sPdfMessage": "Extraído em: <?php echo date('d/m/y')?>"
	              },
	            ]
	        }
	    });
	    var colvis = new $.fn.dataTable.ColVis( oTablechamado );
		}
	});

	$('a[aria-controls="subtarefas"]').on('shown.bs.tab', function (e) {
		if(typeof oTablesubtarefa == 'undefined'){
			oTablesubtarefa =  $('#dataTables-subtarefas').dataTable({
					"lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "Todos"]],
						language: {
							url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
						},
				});
			}
	});

  $(document).ready(function() {
		var oTable = $('#dataTables-demanda').dataTable({
					"lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "Todos"]],
					language: {
						url: '<?php echo Router::url('/', true);?>/js/plugins/dataTables/media/locale/Portuguese-Brasil.json'
					},
					"columnDefs": [  { "visible": false, "targets": 5 } ],
					//"dom": 'T<"clear">lfrtip',
					"dom": 'TC<"clear">lfrtip',
					"colVis": {
						"buttonText": "Esconder Colunas"
					},
					"tableTools": {
							"sSwfPath": "<?php echo Router::url('/', true);?>/js/plugins/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
							"aButtons": [
								{
										"sExtends": "copy",
										"sButtonText": "Copiar",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"mColumns": [ 0,1,2,3,5,6,7,8, ]
								},
								{
										"sExtends": "print",
										"sButtonText": "Imprimir",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"mColumns": [ 0,1,2,3,5,6,7,8, ]
								},
								{
										"sExtends": "csv",
										"sButtonText": "CSV",
										"sFileName": "Demandas.csv",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"mColumns": [ 0,1,2,3,5,6,7,8, ]
								},
								{
										"sExtends": "pdf",
										"sButtonText": "PDF",
										"sFileName": "Demandas.pdf",
										"oSelectorOpts": { filter: 'applied', order: 'current' },
										"sPdfOrientation": "landscape",
										"mColumns": [ 0,1,2,3,6,7,8 ],
										"sTitle": "Listagem de Demandas Internas",
										"sPdfMessage": "Extraído em: <?php echo date('d/m/y')?>"
								},
							]
					}
			});
			var colvis = new $.fn.dataTable.ColVis( oTable );

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

<?php
  $this->Html->addCrumb('Chamados', '');
  $this->Html->addCrumb($chamado['Chamado']['numero'] . "/" . $chamado['Chamado']['ano'], array('controller' => 'chamados', $chamado['Chamado']['id']));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Chamado: <?php echo $chamado['Chamado']['nome'] . " - " . $chamado['Servico']['nome']; ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">
            <b>Informações</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                  array('controller' => 'chamados', 'action' => 'edit', $chamado['Chamado']['id'], '?' => array('controller' => 'chamados', 'id' =>  $chamado['Chamado']['id'], 'action' => 'view' )),
                  array('escape' => false));
              }
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Nome: </b><?php echo $chamado['Chamado']['nome']; ?></a></li>
          <li><a><b>Número: </b><?php echo $chamado['Chamado']['numero'] . "/". $chamado['Chamado']['ano']; ?></a></li>
          <li><a><b>Tipo: </b><?php echo $chamado['ChamadoTipo']['nome']; ?></a></li>
          <li><a><b>Status: </b><?php echo $chamado['Status']['nome']; ?></a></li>
          <li>
            <a><b>Previsão de Atendimento: </b>
            <?php echo $this->Times->timeLeftTo($chamado['Chamado']['created'], $chamado['Chamado']['dt_prev_resolv'],
                $chamado['Chamado']['created'] . " - " . $chamado['Chamado']['dt_prev_resolv'], $chamado['Chamado']['dt_resolv']);
            ?>
            </a>
          </li>
          <li><a><b>Responsável: </b><?php echo $chamado['User']['nome']; ?></a></li>
          <li><a><b>Serviço: </b><?php echo $chamado['Servico']['nome']; ?></a></li>
          <li><a><b>Aberto?: </b><?php echo $this->Times->yesOrNo($chamado['Chamado']['aberto'])?></a></li>
          <li><a><b>Pai?: </b><?php echo $this->Times->yesOrNo($chamado['Chamado']['pai'])?></a></li>
          <?php if(isset($chamado['Demanda']['id'])): ?>
              <li>
                <a href=<?php echo Router::url('/', true) . 'demandas/view/' . $chamado['Demanda']['id']; ?>>
                <b>Demanda: </b><?php echo $chamado['Demanda']['nome'] . " <i class='fa-external-link-square fa' style='font-size: 15px !important;'></i>" ; ?></a>
              </li>
          <?php endif; ?>
          <li><a><b>Observação: </b><?php echo $chamado['Chamado']['observacao']; ?></a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="panel panel-default panel-default">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Rdms
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.rdm-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body rdm-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-demandas">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Número</th>
                <th>Concluída?</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($chamado['Rdm'] as $rdm): ?>
                <tr>
                  <td><?php echo $rdm['nome']; ?></td>
                  <td>  <?php
                      echo $this->Html->link($rdm['numero'],
                            "http://www-sdm14/CAisd/pdmweb.exe?OP=SEARCH+SKIPLIST=1+FACTORY=chg+QBE.EQ.chg_ref_num=" . $rdm['numero'],
                            array('target' => '_blank'));
                    ?>
                  </td>
                  <td><?php echo $this->Rdm->sucesso($rdm['sucesso'], $rdm['dt_executada']); ?></a></td>
                  <td><?php echo $this->Tables->getMenu('rdms', $rdm['id'], 6); ?></td>
                </tr>
              <?php endforeach; ?>
            <?php unset($rdm); ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="panel panel-danger">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Histórico</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'historicos', 'action' => 'add','?' => array('controller' => 'chamados', 'id' =>  $chamado['Chamado']['id'], 'action' => 'view' )),
                array('escape' => false));
              }
            ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.historico-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body historico-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Analista</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($chamado['Historico'] as $hist): ?>
                  <tr>
                    <td><?php echo $hist['data']; ?></td>
                    <td><?php echo $this->Historicos->findLinks($hist['descricao']); ?></td>
                    <td><?php echo $hist['analista']; ?></td>
                    <td>
                       <?php
                        if($this->Ldap->autorizado(2)){

                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'historicos', 'action' => 'edit', $hist['id'], '?' => array('controller' => 'chamados', 'id' =>  $chamado['Chamado']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'historicos', 'action' => 'delete', $hist['id'], '?' => array('controller' => 'chamados', 'id' => $chamado['Chamado']['id'], 'action' => 'view' )),
                                array('escape' => false), "O registro será excluído, você tem certeza dessa ação?");
                        }
                       ?>
                     </td>
                  </tr>
              <?php endforeach; ?>
              <?php unset($hist); ?>
          </tbody>
          </table>
      </div>
      </div>
    </div>
  </div>

  <div class="col-lg-8 pull-right">
    <div class="panel panel-purple">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Tarefas</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'subtarefas', 'action' => 'add','?' => array('servico' => $chamado['Servico']['id'], 'controller' => 'chamados', 'id' =>  $chamado['Chamado']['id'], 'action' => 'view' )),
                array('escape' => false));
              }
            ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.subtarefa-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body subtarefa-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Data prevista</th>
                <th>Tarefa</th>
                <th>Responsável</th>
                <th><span class="editable">Status</span></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($chamado['Subtarefa'] as $sub): ?>
                  <tr>
                    <td class="text-center">
                      <?php
                        echo $this->Subtarefas->timeLeftTo($sub['created'], $sub['dt_prevista'], $sub['check'], $sub['dt_inicio'], $sub['dt_fim']);
                      ?>
                    </td>
                    <td><?php echo $sub['descricao']; ?></td>
                    <td><?php echo $sub['User']['nome']; ?></td>
                    <td id="<?php echo "sub-" . $sub['id']?>">
                      <?php
                        echo $this->Subtarefas->status($sub['check']);
                      ?>
                    </td>
                    <?php
                      echo $this->Tables->SubtarefaStatusEditable($sub['id'], "subtarefas");
                    ?>
                    <td>
                       <?php
                         if($this->Ldap->autorizado(2)){
                            echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                  array('controller' => 'subtarefas', 'action' => 'edit', $sub['id'], '?' => array('controller' => 'chamados', 'id' =>  $chamado['Chamado']['id'], 'action' => 'view' )),
                                  array('escape' => false));
                            echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                  array('controller' => 'subtarefas', 'action' => 'delete', $sub['id'], '?' => array('controller' => 'chamados', 'id' => $chamado['Chamado']['id'], 'action' => 'view' )),
                                  array('escape' => false), "Você tem certeza");
                         }
                       ?>
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

  <div class="col-md-12">
    <?php
    echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2'));
    echo $this->Html->script('getSDMInfoChamados.js');
    ?>
  </div>

</div>

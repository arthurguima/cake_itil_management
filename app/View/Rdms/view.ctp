<?php
  $this->Html->addCrumb('Rdms', '/rdms');
  $this->Html->addCrumb($rdm['Rdm']['numero'] . "/" . $rdm['Rdm']['ano'], array('controller' => 'rdms', 'action' => 'view', $rdm['Rdm']['id']));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">RDM: <?php echo $rdm['Rdm']['nome'] . " - " . $rdm['Servico']['nome']; ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Informações
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                  array('controller' => 'Rdms', 'action' => 'edit', $rdm['Rdm']['id']),
                  array('escape' => false));
              }
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Nome: </b><?php echo $rdm['Rdm']['nome']; ?></a></li>
          <li>
            <?php
              echo $this->Html->link("<b>Número: </b>" . $rdm['Rdm']['numero'] . " <i class='fa-external-link-square fa'></i>",
                    "http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH+SKIPLIST=1+FACTORY=chg+QBE.EQ.chg_ref_num=" . $rdm['Rdm']['numero'],
                    array('escape' => false , 'target' => '_blank'));
            ?>
          </li>
          <li><a><b>Serviço: </b><?php echo $rdm['Servico']['nome']; ?></a></li>
          <li><a><b>Ambiente: </b><?php echo $this->Rdm->getAmbiente($rdm['Rdm']['ambiente']); ?></a></li>
          <li><a><b>Versão: </b><?php echo $rdm['Rdm']['versao']; ?></a></li>
          <li><a><b>Solicitante: </b><?php echo $rdm['Rdm']['solicitante']; ?></a></li>
          <li><a><b>Responsável: </b><?php echo $rdm['User']['nome']; ?></a></li>
          <li><a><b>Data Prevista: </b><?php echo $this->Times->pastDate($rdm['Rdm']['dt_prevista']); ?></a></li>
          <li><a><b>Data de Execução: </b><?php echo $rdm['Rdm']['dt_executada']; ?></a></li>
          <li><a><b>Tipo: </b><?php echo $rdm['RdmTipo']['nome']; ?></a></li>
          <li><a><b>Concluída?: </b><?php echo $this->Rdm->sucesso($rdm['Rdm']['sucesso'], $rdm['Rdm']['dt_executada']); ?></a></li>
          <li><a style="overflow: auto;"><b>Observação: </b><?php echo $rdm['Rdm']['observacao']; ?></a></li>
          <li><?php echo $this->Html->link("<b>Release: </b>" . $rdm['Release']['versao'], array('controller' => 'releases', 'action' => 'view', $rdm['Release']['id']), array('escape' => false)); ?></li>
          <li class="checklist">
            <a>
              <b>CAB</b>
              <span id="<?php echo "rdm-cab_approval-" . $rdm['Rdm']['id']?>">
                <?php echo $this->Rdm->getCheck($rdm['Rdm']['cab_approval']); ?>
              </span>
            </a>
            <a>
              <b>Autorizada</b>
              <span id="<?php echo "rdm-autorizada-" . $rdm['Rdm']['id']?>">
                <?php echo $this->Rdm->getCheck($rdm['Rdm']['autorizada']); ?>
              </span>
            </a>
            <a>
              <b>FARM</b>
              <span id="<?php echo "rdm-farm-" . $rdm['Rdm']['id']?>">
                <?php echo $this->Rdm->getCheck($rdm['Rdm']['farm']); ?>
              </span>
            </a>
          </li>
        <ul>
      </div>
    </div>
  </div>


  <div class="col-lg-8">
    <div class="panel panel-default panel-default">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Demandas
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.demandas-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body demandas-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-demandas">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Clarity ID <i class='fa-expand fa' style="font-size: 15px !important;"></th>
                <th>Prazo</th>
                <th><span class="editable">Status</span></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($rdm['Demanda'] as $dem): ?>
                <tr>
                  <td><?php echo $dem['nome']; ?></td>
                  <td style="cursor:pointer;" title="Clique para abrir a demanda no Clarity!">
                      <?php echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                                 $dem['clarity_id'] .")'>" . $dem['clarity_dm_id'] ."</a></span>" ?>
                  </td>
                  <td>
                    <?php echo $this->Times->timeLeftTo($dem['data_cadastro'], $dem['dt_prevista'],
                           $dem['data_cadastro'] . " - " . $dem['dt_prevista'],
                          ($dem['data_homologacao']));
                    ?>
                  </td>
                  <td>
                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $dem['id'] ?>"><?php echo $dem['Status']['nome']; ?></span>
                  </td>
                  <?php echo $this->Tables->DemandaStatusEditable($dem['id'], "demandas") ?>
                  <td><?php echo $this->Tables->getMenu('demandas', $dem['id'], 2); ?></td>
                </tr>
              <?php endforeach; ?>
            <?php unset($area); ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="panel panel-success">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Chamados
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.chamados-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body chamados-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-chamados">
            <thead>
              <tr>
                <th>Número <i class='fa-external-link-square fa' style="font-size: 15px !important;"></th>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Aberto?</th>
                <th>Pai?</th>
                <th><span class="editable">Status</span></th>
                <th class="hidden-xs hidden-sm">Responsável</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($rdm['Chamado'] as $chamado): ?>
                <tr>
                  <td data-order=<?php echo $chamado['ano'] . $chamado['numero']; ?>>
                    <?php
                      echo $this->Html->link($chamado['numero'] . "/". $chamado['ano'],
                      "http://www-sdm/CAisd/pdmweb.exe?OP=SEARCH+FACTORY=in+SKIPLIST=1+QBE.IN.ref_num=" . $chamado['numero'] . "%25",
                      array('target' => '_blank'));
                    ?>
                  </td>
                  <td><?php echo $chamado['nome']; ?></td>
                  <td><?php echo $chamado['ChamadoTipo']['nome']; ?></td>
                  <td><?php echo $this->Times->yesOrNo($chamado['aberto'])?></td>
                  <td><?php echo $this->Times->yesOrNo($chamado['pai'])?></td>
                  <td>
                    <span style="cursor:pointer;" title="Clique para alterar o status!" id="<?php echo "status-" . $chamado['id'] ?>"><?php echo $chamado['Status']['nome']; ?></span>
                  </td>
                  <?php echo $this->Tables->ChamadoStatusEditable($chamado['id']) ?>
                  <td class="hidden-xs hidden-sm"><div class="sub-17"><?php echo $chamado['User']['nome']; ?></div></td>
                  <td>
                    <?php
                      echo $this->Tables->getMenu('chamados', $chamado['id'], 10);
                      if($this->Ldap->autorizado(2)){
                        echo $this->Html->link(" <i class='fa fa-pencil'></i>",
                                  array('controller' => 'chamados', 'action' => 'edit', $chamado['id'], '?' => array('controller' => 'chamados', 'action' => 'index' )),
                                  array('escape' => false));
                      }
                      echo "<a id='viewHistorico' data-toggle='modal' data-target='#Historico' onclick='javascript:historico(" . $chamado['id'] . ")'>
                        <i class='fa fa-history' style='margin-left: 5px;' title='Visualizar histórico'></i></a></span>";
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php unset($area); ?>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6 pull-right">
    <div class="panel panel-danger">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Histórico</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'historicos', 'action' => 'add','?' => array('controller' => 'rdms', 'id' =>  $rdm['Rdm']['id'], 'action' => 'view' )),
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
              <?php foreach($rdm['Historico'] as $hist): ?>
                  <tr>
                    <td><?php echo $hist['data']; ?></td>
                    <td><?php echo $this->Historicos->findLinks($hist['descricao']); ?></td>
                    <td><?php echo $hist['analista']; ?></td>
                    <td>
                       <?php
                        if($this->Ldap->autorizado(2)){
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'historicos', 'action' => 'edit', $hist['id'], '?' => array('controller' => 'rdms', 'id' =>  $rdm['Rdm']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'historicos', 'action' => 'delete', $hist['id'], '?' => array('controller' => 'rdms', 'id' => $rdm['Rdm']['id'], 'action' => 'view' )),
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

  <div class="col-lg-6 pull-right">
    <div class="panel panel-purple">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Tarefas</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'subtarefas', 'action' => 'add','?' => array('servico' => $rdm['Servico']['id'], 'controller' => 'rdms', 'id' =>  $rdm['Rdm']['id'], 'action' => 'view' )),
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
              <?php foreach($rdm['Subtarefa'] as $sub): ?>
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
                                  array('controller' => 'subtarefas', 'action' => 'edit', $sub['id'], '?' => array('controller' => 'rdms', 'id' =>  $rdm['Rdm']['id'], 'action' => 'view' )),
                                  array('escape' => false));
                            echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                  array('controller' => 'subtarefas', 'action' => 'delete', $sub['id'], '?' => array('controller' => 'rdms', 'id' => $rdm['Rdm']['id'], 'action' => 'view' )),
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
    <?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>
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

<?php
  //-- ClarityID
  echo $this->Html->script('getIdClarity.js');

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');

  //-- ClarityID
  echo $this->Html->script('getSDMInfo.js');

  //-- Jeditable
  echo $this->Html->script('plugins/jeditable/jquery.jeditable.js');
?>

<?php
  echo $this->Tables->RdmCheckEditable($rdm['Rdm']['id'], "rdms", "cab_approval");
  echo $this->Tables->RdmCheckEditable($rdm['Rdm']['id'], "rdms", "autorizada");
  echo $this->Tables->RdmCheckEditable($rdm['Rdm']['id'], "rdms", "farm");
?>

<script>
  $(document).ready(function() {
    $('#myModal').on('shown.bs.modal', function (e) {
      document.getElementById('modal-body').appendChild(
          document.getElementById('demandaFrame')
      );
      document.getElementById('demandaFrame').style.display = "block";
      //document.getElementById('demandaFrame').style.height = "720px";
    });
    getSDMInfoOnView('<?php echo $rdm['numero']?>', 'Rdms');
  });

  function historico(id){
    document.getElementById('historicoFrame').src = "<?php echo(Router::url('/', true). "historicos/popup?controller=chamados&id=");?>" + id;
  }
</script>

<?php
  $this->Html->addCrumb('Demandas', '/demandas');
  $this->Html->addCrumb($demanda['Demanda']['id'], array('controller' => 'demandas', 'action' => 'view', $demanda['Demanda']['id']));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Demanda: <?php echo $demanda['Demanda']['clarity_dm_id'] ." - " . $demanda['Servico']['sigla'] ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-5">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Informações Gerais</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                  array('controller' => 'demandas', 'action' => 'edit', $demanda['Demanda']['id']),
                  array('escape' => false));
              }
            ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.info-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body info-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Nome: </b><?php echo $demanda['Demanda']['nome']; ?></a></li>
          <li>
            <?php echo "<a id='viewClarity' data-toggle='modal' data-target='#myModal' onclick='javascript:indexClarity(" .
                     $demanda['Demanda']['clarity_id'] .")'><b>Clarity DM: </b>" . $demanda['Demanda']['clarity_dm_id']  .
                     "<i class='fa-expand fa' style='cursor:pointer; float:right;' title='Clique aqui para testar a integração da demanda com o sistema Clarity!'></i></a></span>" ?>
          </li>
          <li><a><b>Mantis: </b><?php echo $demanda['Demanda']['mantis_id']; ?></a></li>
          <li>
            <a>
              <b>Prazo: </b>
              <?php echo $this->Times->timeLeftTo($demanda['Demanda']['data_cadastro'], $demanda['Demanda']['dt_prevista'],
                      $demanda['Demanda']['data_cadastro'] . " - " .  $demanda['Demanda']['dt_prevista'],
                      ($demanda['Demanda']['data_homologacao']));
              ?>
            </a>
          </li>
          <li>
            <a><b>Data Prevista: </b>
              <?php
                  if($demanda['Demanda']['dt_prevista'] != null){
                    echo $this->Times->pastdate($demanda['Demanda']['dt_prevista']);
                  }
              ?>
            </a>
          </li>
          <li>
            <a>
              <b>Data de homologação: </b>
              <?php
                if ($demanda['Demanda']['data_homologacao'] != null):
                  echo $this->Times->pastdate($demanda['Demanda']['data_homologacao']);
                endif;
              ?>
            </a>
          </li>
          <li><a><b>Serviço: </b> <?php echo $demanda['Servico']['sigla']; ?></a></li>
          <li><a><b>Tipo: </b><?php echo $demanda['DemandaTipo']['nome']; ?></a></li>
          <li><a><b>Responsável: </b><?php echo $demanda['User']['nome']; ?></a></li>
          <li><a><b>Solicitada pelo Cliente: </b><?php echo $this->Times->yesOrNo($demanda['Demanda']['origem_cliente']); ?></a></li>
          <li><a><b>Executor: </b><?php echo $demanda['Demanda']['executor']; ?></a></li>

          <?php if(isset($demanda['Ss'][0])):
            foreach($demanda['Ss'] as $ss): ?>
              <li>
                <a href=<?php echo Router::url('/', true) . 'sses/view/' . $ss['id']; ?>>
                <b>SS: </b><?php echo $ss['nome'] . " <i class='fa-external-link-square fa' style='font-size: 15px !important;'></i>" ; ?></a>
              </li>
          <?php endforeach; endif; ?>

          <li><a><b>Descrição: </b><?php echo $demanda['Demanda']['descricao']; ?></a></li>
          <li><a><b>Status: </b><?php echo $demanda['Status']['nome']; ?></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="panel panel-success">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Clarity (Web Service)</b>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.clarity-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body clarity-body">
        <ul id="clarity">
          <div class="col-md-6 col-md-offset-4 load"><?php echo $this->Html->image('loading.gif', array('alt' => 'Carregando', 'width' => '30%')); ?></div>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-7">
    <div class="panel panel-default panel-info">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Chamados</b>
            <?php
              if($this->Ldap->autorizado(2)){
               echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'chamados', 'action' => 'add','?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view',
                                                                                 'servico' => $demanda['Demanda']['servico_id'] )),
                array('escape' => false));
              }
            ?>
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.chamados-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span>
          </h3>
        </p>
      </div>
      <div class="panel-body chamados-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Número</th>
                <th>Nome</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($demanda['Chamado'] as $chamado): ?>
                  <tr>
                    <td><?php echo $chamado['nome']; ?></td>
                    <td><?php echo $chamado['numero']; ?></td>
                    <td>
                       <?php
                          echo $this->Html->link("<i class='fa fa-search-plus'></i>",
                             array('controller' => 'chamados', 'action' => 'view', $chamado['id'], '?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
                             array('escape' => false));
                        if($this->Ldap->autorizado(2)){
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'chamados', 'action' => 'edit', $chamado['id'], '?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'chamados', 'action' => 'delete', $chamado['id'], '?' => array('controller' => 'demandas', 'id' => $demanda['Demanda']['id'], 'action' => 'view' )),
                                array('escape' => false), "O registro será excluído, você tem certeza dessa ação?");
                        }
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

  <div class="col-lg-7">
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
              <?php foreach($demanda['Rdm'] as $rdm): ?>
                <tr>
                  <td><?php echo $rdm['nome']; ?></td>
                  <td><?php echo $rdm['numero']; ?></td>
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

  <div class="col-lg-12">
    <div class="panel panel-danger">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Histórico</b>
            <?php
              if($this->Ldap->autorizado(2)){
                echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
                array('controller' => 'historicos', 'action' => 'add','?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
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
              <?php foreach($demanda['Historico'] as $hist): ?>
                  <tr>
                    <td><?php echo $hist['data']; ?></td>
                    <td><?php echo $this->Historicos->findLinks($hist['descricao']); ?></td>
                    <td><?php echo $hist['analista']; ?></td>
                    <td>
                       <?php
                         if($this->Ldap->autorizado(2)){
                            echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                  array('controller' => 'historicos', 'action' => 'edit', $hist['id'], '?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
                                  array('escape' => false));
                            echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                  array('controller' => 'historicos', 'action' => 'delete', $hist['id'], '?' => array('controller' => 'demandas', 'id' => $demanda['Demanda']['id'], 'action' => 'view' )),
                                  array('escape' => false), "Você tem certeza");
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


<?php
  //-- ClarityID
  echo $this->Html->script('getIdClarity.js');

  //-- ClarityInfo
  echo $this->Html->script('getClarityInfo.js');
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

    getClarityInfoOnView('<?php echo $demanda['Demanda']['clarity_dm_id']?>', 'demandas');
  });
</script>

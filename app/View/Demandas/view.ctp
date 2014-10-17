<?php
  $this->Html->addCrumb('Demandas', '/demandas');
  $this->Html->addCrumb($demanda['Demanda']['id'], array('controller' => 'demandas', 'action' => 'view', $demanda['Demanda']['id']));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Demanda: <?php echo "DM: " . $demanda['Demanda']['clarity_dm_id'] ." - " . $demanda['Servico']['sigla'] ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-3">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Informações Gerais</b>
            <?php
              echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                array('controller' => 'demandas', 'action' => 'edit', $demanda['Demanda']['id']),
                array('escape' => false));
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Clarity DM: </b><?php echo $demanda['Demanda']['clarity_dm_id']; ?></a></li>
          <li><a><b>Mantis: </b><?php echo $demanda['Demanda']['mantis_id']; ?></a></li>
          <li><a>
            <b>Prazo: </b>
            <?php
              if($demanda['Demanda']['dt_prevista'] != null):
                echo $this->Times->timeLeftTo(
                  $demanda['Demanda']['data_cadastro'],
                  $demanda['Demanda']['dt_prevista'],
                  $this->Time->format('d/m/Y', $demanda['Demanda']['data_cadastro']) . " - " . $this->Time->format('d/m/Y', $demanda['Demanda']['dt_prevista']),
                  ($demanda['Demanda']['data_homologacao'] == null));
              endif;
            ?></a>
          </li>
          <li>
            <a>
              <b>Data de homologação: </b>
              <?php
                if ($demanda['Demanda']['data_homologacao'] != null):
                  echo $demanda['Demanda']['data_homologacao'];
                endif;
              ?>
            </a>
          </li>
          <li><a><b>Serviço: </b> <?php echo $demanda['Servico']['sigla']; ?></a></li>
          <li><a><b>Tipo: </b><?php echo $demanda['DemandaTipo']['nome']; ?></a></li>
          <li><a><b>Criador: </b><?php echo $demanda['Demanda']['criador']; ?></a></li>
          <li><a><b>Executor: </b><?php echo $demanda['Demanda']['executor']; ?></a></li>
          <li><a><b>Descrição: </b><?php echo $demanda['Demanda']['descricao']; ?></a></li>
          <li><a><b>Status: </b><?php echo $demanda['Status']['nome']; ?></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="panel panel-danger panel-info">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Histórico</b>
          <?php echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
            array('controller' => 'historicos', 'action' => 'add','?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
            array('escape' => false)); ?></h3>
        </p>
      </div>
      <div class="panel-body">
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
                    <td><?php echo $hist['descricao']; ?></td>
                    <td><?php echo $hist['analista']; ?></td>
                    <td>
                       <?php
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'historicos', 'action' => 'edit', $hist['id'], '?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'historicos', 'action' => 'delete', $hist['id'], '?' => array('controller' => 'demandas', 'id' => $demanda['Demanda']['id'], 'action' => 'view' )),
                                array('escape' => false), "Você tem certeza");
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

  <div class="col-lg-3">
    <div class="panel panel-default panel-info">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Chamados</b>
          <?php echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
            array('controller' => 'chamados', 'action' => 'add','?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
            array('escape' => false)); ?></h3>
        </p>
      </div>
      <div class="panel-body">
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
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'chamados', 'action' => 'edit', $chamado['id'], '?' => array('controller' => 'demandas', 'id' =>  $demanda['Demanda']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'chamados', 'action' => 'delete', $chamado['id'], '?' => array('controller' => 'demandas', 'id' => $demanda['Demanda']['id'], 'action' => 'view' )),
                                array('escape' => false), "Você tem certeza");
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

<?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>

<?php
  $this->Html->addCrumb('Rdms', '/rdms');
  $this->Html->addCrumb($rdm['Rdm']['numero'], array('controller' => 'rdms', 'action' => 'view', $rdm['Rdm']['id']));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">RDM: <?php echo $rdm['Rdm']['nome']; ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Informações
          <?php
            echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
              array('controller' => 'Rdms', 'action' => 'edit', $rdm['Rdm']['id']),
              array('escape' => false));
          ?></h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Nome: </b><?php echo $rdm['Rdm']['nome']; ?></a></li>
          <li><a><b>Número: </b><?php echo $rdm['Rdm']['numero']; ?></a></li>
          <li><a><b>Data Prevista: </b><?php echo $this->Times->pastDate($rdm['Rdm']['dt_prevista']); ?></a></li>
          <li><a><b>Data de Execução: </b><?php echo $rdm['Rdm']['dt_executada']; ?></a></li>
          <li><a><b>Tipo: </b><?php echo $rdm['RdmTipo']['nome']; ?></a></li>
          <li><a><b>Executada com Sucesso?: </b><?php echo $this->Rdm->sucesso($rdm['Rdm']['dt_executada'], $rdm['Rdm']['dt_executada']); ?></a></li>
        <ul>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="panel panel-default panel-default">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Demandas
            <span style="cursor:pointer;" onclick="javascript:$('div.panel-body.demandas-body').toggle();"><i class="fa fa-eye-slash pull-right"></i></span
          </h3>
        </p>
      </div>
      <div class="panel-body demandas-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-demandas">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Clarity ID:</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($rdm['Demanda'] as $dem): ?>
                <tr>
                  <td><?php echo $dem['nome']; ?></td>
                  <td><?php echo $dem['clarity_dm_id']; ?></td>
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

  <div class="col-lg-12">
    <div class="panel panel-danger panel-info">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title"><b>Histórico</b>
            <?php echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
              array('controller' => 'historicos', 'action' => 'add','?' => array('controller' => 'rdms', 'id' =>  $rdm['Rdm']['id'], 'action' => 'view' )),
              array('escape' => false)); ?>
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
                    <td><?php echo $hist['descricao']; ?></td>
                    <td><?php echo $hist['analista']; ?></td>
                    <td>
                       <?php
                          echo $this->Html->link("<i class='fa fa-pencil'></i>",
                                array('controller' => 'historicos', 'action' => 'edit', $hist['id'], '?' => array('controller' => 'demandas', 'id' =>  $rdm['Rdm']['id'], 'action' => 'view' )),
                                array('escape' => false));
                          echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                                array('controller' => 'historicos', 'action' => 'delete', $hist['id'], '?' => array('controller' => 'demandas', 'id' => $rdm['Rdm']['id'], 'action' => 'view' )),
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
</div>

<div class="col-md-12">
  <?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>
</dvi>

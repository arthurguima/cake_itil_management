<?php
  $this->Html->addCrumb('Serviços', '/servicos');
  $this->Html->addCrumb($Servico['Servico']['sigla'], array('controller' => 'servicos', 'action' => 'view', $Servico['Servico']['id']));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Serviço: <?php echo $Servico['Servico']['sigla']; echo " - "; echo $Servico['Servico']['nome']; ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Informações
          <?php
            echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
              array('controller' => 'Servicos', 'action' => 'edit', $Servico['Servico']['id']),
              array('escape' => false));
          ?></h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Nome: </b><?php echo $Servico['Servico']['nome']; ?></a></li>
          <li><a><b>Sigla: </b><?php echo $Servico['Servico']['sigla']; ?></a></li>
          <li><a><b>Tecnologia: </b><?php echo $Servico['Servico']['tecnologia']; ?></a></li>
		  <li><a><b>URL: </b><?php echo $Servico['Servico']['url']; ?></a></li>
          <li><a><b>Status: </b><?php echo $this->Times->active($Servico['Servico']['status'])?></td></a></li>
        <ul>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="panel panel-default panel-info">
      <div class="panel-heading"> <p><h3 class="panel-title">Áreas</h3></p></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Sigla</th>
                <th>Nome</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($Servico['Area'] as $area): ?>
                <tr>
                  <td>
                    <?php echo $this->Html->link($area['sigla'],
                              array('controller' => 'areas', 'action' => 'view', $area['id']) ); ?>
                  </td>
                  <td><?php echo $area['nome']; ?></td>
                  <td>
                     <?php
                        echo $this->Html->link("<i class='fa fa-pencil'></i>",
                              array('controller' => 'areas', 'action' => 'edit', $area['id'], '?' => array('controller' => 'servicos', 'action' => 'view', 'id' => $Servico['Servico']['id'] )),
                              array('escape' => false));
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

  <div class="col-lg-4">
    <div class="panel panel-default panel-danger">
      <div class="panel-heading"> <p><h3 class="panel-title">Dependências</h3></p></div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Nome</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($Servico['Dependencia'] as $dep): ?>
                <tr>
                  <td>
                    <?php echo $dep['nome']; ?>
                  </td>
                  <td>
                     <?php
                        echo $this->Html->link("<i class='fa fa-pencil'></i>",
                              array('controller' => 'dependencias', 'action' => 'edit', $dep['id'], '?' => array('controller' => 'servicos', 'action' => 'view', 'id' => $Servico['Servico']['id'] )),
                              array('escape' => false));
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

<?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>

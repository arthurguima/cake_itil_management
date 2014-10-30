<?php
  $this->Html->addCrumb('Contratos', '/contratos');
  $this->Html->addCrumb($contrato['Contrato']['numero'], array('controller' => 'contratos', 'action' => 'view', $contrato['Contrato']['id']));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Contrato: nº<?php echo $contrato['Contrato']['numero']; ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Informações Gerais
            <?php
              echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
                array('controller' => 'contratos', 'action' => 'edit', $contrato['Contrato']['id']),
                array('escape' => false));
            ?>
          </h3>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Número:</b><?php echo $contrato['Contrato']['numero']; ?></a></li>
          <li><a><b>Data de Início: </b><?php echo  $this->Time->format('d/m/Y', $contrato['Contrato']['data_ini']); ?></a></li>
          <li><a><b>Data de Fim: </b><?php echo $this->Times->pastDate($contrato['Contrato']['data_fim']) ?></a></li>
          <li><a><b>Status: </b><?php echo $this->Times->active($contrato['Contrato']['status'])?></a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="panel panel-default panel-default">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Aditivos
          <?php echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
            array('controller' => 'aditivos', 'action' => 'add','?' => array('contrato' =>  $contrato['Contrato']['id'], 'action' => 'view' )),
            array('escape' => false)); ?></h3>
        </p>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-aditivo">
            <thead>
              <tr>
                <th>Data Início</th>
                <th>Data Fim</th>

                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($contrato['Aditivo'] as $aditivo): ?>
                <tr>
                  <td><?php echo $this->Time->format('d/m/Y', $aditivo['dt_inicio']); ?></td>
                  <td><?php echo $this->Times->pastDate($aditivo['dt_fim']); ?></td>

                  <td>
                     <?php
                        echo $this->Html->link("<i class='fa fa-pencil'></i>",
                              array('controller' => 'aditivos', 'action' => 'edit', $aditivo['id'], '?' => array('action' => 'view','contrato' =>  $contrato['Contrato']['id'])),
                              array('escape' => false));

                        echo $this->Html->link("<i class='fa fa-search-plus ' style='margin-left: 5px;''></i>",
                              array('controller' => 'aditivos', 'action' => 'view', $aditivo['id'], '?' => array('action' => 'view','contrato' =>  $contrato['Contrato']['id'])),
                              array('escape' => false));

                        echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                              array('controller' => 'aditivos', 'action' => 'delete', $aditivo['id']),
                              array('escape' => false), "Você tem certeza");
                     ?>
                   </td>
                </tr>
              <?php endforeach; ?>
              <?php unset($aditivo); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default panel-danger">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Itens de Contrato
          <?php echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
            array('controller' => 'items', 'action' => 'add','?' => array('controller' => 'contratos', 'id' =>  $contrato['Contrato']['id'], 'action' => 'view' )),
            array('escape' => false)); ?></h3>
        </p>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Volume</th>
                <th>Métrica</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($contrato['Item'] as $item): ?>
                <tr>
                  <td><?php echo $item['nome']; ?></td>
                  <td><?php echo $item['volume']; ?></td>
                  <td><?php echo $item['metrica']; ?></td>
                  <td>
                     <?php
                        echo $this->Html->link("<i class='fa fa-pencil'></i>",
                              array('controller' => 'items', 'action' => 'edit', $item['id'], '?' => array('controller' => 'contratos', 'id' =>  $contrato['Contrato']['id'], 'action' => 'view' )),
                              array('escape' => false));
                        echo $this->Form->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                              array('controller' => 'items', 'action' => 'delete', $item['id'], '?' => array('controller' => 'contratos', 'id' =>  $contrato['Contrato']['id'], 'action' => 'view' )),
                              array('escape' => false), "Você tem certeza");
                     ?>
                   </td>
                </tr>
              <?php endforeach; ?>
              <?php unset($item); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-3')); ?>

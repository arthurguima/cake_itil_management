<?php
  $this->Html->addCrumb('Contratos', '/contratos');
  $this->Html->addCrumb($Item['Contrato']['numero'], array('controller' => 'contratos', 'action' => 'view', $Item['Contrato']['id']));
  $this->Html->addCrumb('Itens de contrato', '');
  $this->Html->addCrumb($Item['Item']['id'], array('controller' => 'items', 'action' => 'edit', $Item['Item']['id']));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Item: <?php echo $Item['Item']['id']; ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-2">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <p>
          <b>Informações</b>
          <?php
            echo $this->Html->link("<i class='fa fa-edit pull-right'></i>",
              array('controller' => 'Items', 'action' => 'edit', $Item['Item']['id']),
              array('escape' => false));
          ?>
        </p>
      </div>
      <div class="panel-body">
        <ul class="nav nav-pills nav-stacked">
          <li><a><b>Nome:</b><?php echo $Item['Item']['nome']; ?></a></li>
          <li><a><b>Métrica</b><?php echo $Item['Item']['métrica']; ?></a></li>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-2')); ?>

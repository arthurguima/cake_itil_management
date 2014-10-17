<?php
  $this->Html->addCrumb('Tipos de Demandas', '/demandatipos');
  $this->Html->addCrumb("Nova", array('controller' => 'demandatipos', 'action' => 'add'));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Novo Tipo de Demanda</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('DemandaTipo');

     echo $this->BootstrapForm->input('nome', array(
                'label' => array('text' => 'Nome: ')));

    ?>
    <div class="form-footer col-lg-10 pull-right">
      <?php
        echo $this->BootstrapForm->submit('Salvar');
        echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-3'));
        echo $this->Form->end();
      ?>
    </div>
  </div>
</div>

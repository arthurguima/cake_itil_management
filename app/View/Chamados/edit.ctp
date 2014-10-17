<?php
  $this->Html->addCrumb('Demandas', '/demandas');
  $this->Html->addCrumb("id:" . $this->params['url']['id'], array('controller' => 'demandas', 'action' => 'view', $this->params['url']['id']));
  $this->Html->addCrumb('Chamado', ' ');
  $this->Html->addCrumb("Editar", ' ');
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Editar Chamado</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Chamado');

     echo $this->BootstrapForm->input('nome', array(
        'label' => array('text' => 'Nome: ')));

     echo $this->BootstrapForm->input('numero', array(
        'label' => array('text' => 'Número: ')));

      echo $this->BootstrapForm->input('id');
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

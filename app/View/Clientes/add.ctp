<?php
  $this->Html->addCrumb('Clientes', '/clientes');
  $this->Html->addCrumb("Novo", '');
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">Novo Cliente</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Cliente');

     echo $this->BootstrapForm->input('nome', array(
        'label' => array('text' => 'Nome: ')));

     echo $this->BootstrapForm->input('sigla', array(
        'label' => array('text' => 'Sigla: ')));

     echo $this->BootstrapForm->input('dt_ini_disponibilidade', array(
      'label' => array('text' => 'Início do Cálculo de ANS (dia): ')));
    ?>
      <div class="form-footer col-lg-10 col-md-6 pull-right">
        <?php
          echo $this->BootstrapForm->submit('Salvar');
          echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-lg-3 col-md-6'));
          echo $this->Form->end();
        ?>
      </div>
  </div>
</div>

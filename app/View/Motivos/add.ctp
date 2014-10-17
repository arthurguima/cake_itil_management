<?php
  $this->Html->addCrumb('Motivos', '/motivos');
  $this->Html->addCrumb("Novo", array('controller' => 'motivos', 'action' => 'add'));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Novo Motivo de Indisponibilidade</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Motivo');

      echo $this->BootstrapForm->input('nome', array(
                'label' => array('text' => 'Nome')));

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

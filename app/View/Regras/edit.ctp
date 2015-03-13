<?php
  $this->Html->addCrumb('Contratos', '/contratos');
  $this->Html->addCrumb('Regras de ANS', "");
  $this->Html->addCrumb("Nova", '');
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Editar Regra de ANS</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Regra');

      echo $this->BootstrapForm->input('servico_id', array(
                  'label' => array('text' => 'Serviço')));

      echo $this->BootstrapForm->input('nome', array(
                  'label' => array('text' => 'Nome')));

      echo $this->BootstrapForm->input('modelo', array(
                  'label' => array('text' => 'Volume'),
                  'type' => 'textarea'));

      echo $this->BootstrapForm->input('observacao', array(
                  'label' => array('text' => 'Observação: '),
                  'type' => 'textarea'));

      echo $this->BootstrapForm->input('id');
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

<?php
  echo $this->TinyMCE->inicialize();
?>

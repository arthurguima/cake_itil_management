<?php
  $this->Html->addCrumb('Mapeamento DTP', '/responsabilidades');
  $this->Html->addCrumb("Editar", "");
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Editar Mapeamento</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Responsabilidade');

      echo $this->BootstrapForm->input('processo', array(
                  'label' => array('text' => 'Nome do Processo: ')));

      echo $this->BootstrapForm->input('responsavel', array(
                 'label' => array('text' => 'Responsável: ')));

      echo $this->BootstrapForm->input('area', array(
                  'label' => array('text' => 'Área: ')));

      echo $this->BootstrapForm->input('ramal', array(
                  'label' => array('text' => 'Ramal: ')));

      echo $this->BootstrapForm->input('email', array(
                  'label' => array('text' => 'Email: ')));

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

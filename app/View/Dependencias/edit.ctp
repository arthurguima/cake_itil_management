<?php
  $this->Html->addCrumb('Dependências', '/dependencias');
  $this->Html->addCrumb('Editar', array('controller' => 'dependencias', 'action' => 'edit', $this->data['Dependencia']['id']));
?>

<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Editar Dependência</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Dependencia');

      echo $this->BootstrapForm->input('nome', array(
                  'label' => array('text' => 'Nome:')));

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

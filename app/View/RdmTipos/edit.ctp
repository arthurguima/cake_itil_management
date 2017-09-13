<?php
  $this->Html->addCrumb('Tipos de RDMs', '/rdmtipos');
  $this->Html->addCrumb($this->data['RdmTipo']['nome'], array('controller' => 'rdmTipos', 'action' => 'edit', $this->data['RdmTipo']['id']));
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12">
    <h3 class="page-header">
      Editar Tipo de RDM
    </h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('RdmTipo');

      echo $this->BootstrapForm->input('nome', array(
                  'label' => array('text' => 'Nome: ')));

      echo $this->Form->input('id', array('type' => 'hidden'));

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

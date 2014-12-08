<?php
  $this->Html->addCrumb('Motivos', '/motivos');
  $this->Html->addCrumb($this->data['Motivo']['nome'], array('controller' => 'motivos', 'action' => 'edit', $this->data['Motivo']['id']));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Editar Motivo de Indisponibilidade</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Motivo');

     echo $this->BootstrapForm->input('id');

     echo $this->BootstrapForm->input('nome', array(
                'label' => array('text' => 'Nome')));

    echo $this->BootstrapForm->input('contavel', array(
                             'class' => 'col-sm-3 pull-left col-sm-offset-3',
                             'label' => array('text' => 'Entra no cálculo de horas?', 'class' => 'control-label col-sm-2'),
                             'type' => 'checkbox'));

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

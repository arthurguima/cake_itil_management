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

    <div class="form-group">
      <label for="MotivoAmbiente" class="col-lg-3 control-label">Ambiente: </label>
      <div class="col-lg-9">
        <select name="data[Motivo][ambiente]" class="form-control" id="filterambiente">
          <option value="1" <?php if($this->data['Motivo']['ambiente'] == 1) echo 'selected="selected"'; ?>>Homologação</option>
          <option value="2" <?php if($this->data['Motivo']['ambiente'] == 2) echo 'selected="selected"'; ?>>Produção</option>
          <option value="3" <?php if($this->data['Motivo']['ambiente'] == 3) echo 'selected="selected"'; ?>>Treinamento</option>
          <option value="3" <?php if($this->data['Motivo']['ambiente'] == 4) echo 'selected="selected"'; ?>>Sustentação</option>
        </select>
      </div>
    </div>

    <div class="form-footer col-lg-10 col-md-6 pull-right">
      <?php
        echo $this->BootstrapForm->submit('Salvar');
        echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-lg-3 col-md-6'));
        echo $this->Form->end();
      ?>
    </div>
  </div>
</div>

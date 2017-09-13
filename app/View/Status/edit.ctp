<?php
  $this->Html->addCrumb('Status', '/status');
  $this->Html->addCrumb("Editar Status", array('controller' => 'status', 'action' => 'edit', $this->data['Status']['id']));
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">Editar Status</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Status');

      echo $this->BootstrapForm->input('nome', array(
                'label' => array('text' => 'Nome: ')));

      echo $this->BootstrapForm->input('fim', array(
           'class' => 'col-sm-3 pull-left col-sm-offset-3',
           'type' => "checkbox",
           'label' => array(
             'text' => 'Finaliza o Processo? ',
             'class' => 'control-label col-sm-2')));

     echo $this->BootstrapForm->input('id');

    ?>
    <div class="form-group">
      <label for="StatusTipo" class="col-lg-3 control-label">Tipo: </label>
      <div class="col-lg-9">
        <select name="data[Status][tipo]" class="form-control" id="filterTipo">
          <option value="1">Demanda</option>
          <option value="2">SS</option>
          <option value="3">OS</option>
          <option value="4">PE</option>
          <option value="5">Chamado</option>
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

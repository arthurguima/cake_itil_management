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

     echo $this->BootstrapForm->input('id');

    ?>
    <div class="form-group">
      <label for="StatusFim" class="col-lg-3 control-label">Etapa: </label>
      <div class="col-lg-9">
        <select name="data[Status][fim]" class="form-control" id="filterFim">
          <option value="2" <?php if($this->data['Status']['fim'] == 2) echo 'selected="selected"'; ?>>Processo em andamento</option>
          <option value="1" <?php if($this->data['Status']['fim'] == 1) echo 'selected="selected"'; ?>>Finaliza o processo</option>
          <option value="3" <?php if($this->data['Status']['fim'] == 3) echo 'selected="selected"'; ?>>Inicia/Recebe o processo</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="StatusTipo" class="col-lg-3 control-label">Tipo: </label>
      <div class="col-lg-9">
        <select name="data[Status][tipo]" class="form-control" id="filterTipo">
          <option value="1" <?php if($this->data['Status']['tipo'] == 1) echo 'selected="selected"'; ?>>Demanda</option>
          <option value="2" <?php if($this->data['Status']['tipo'] == 2) echo 'selected="selected"'; ?>>SS</option>
          <option value="3" <?php if($this->data['Status']['tipo'] == 3) echo 'selected="selected"'; ?>>OS</option>
          <option value="4" <?php if($this->data['Status']['tipo'] == 4) echo 'selected="selected"'; ?>>PE</option>
          <option value="5" <?php if($this->data['Status']['tipo'] == 5) echo 'selected="selected"'; ?>>Chamado</option>
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

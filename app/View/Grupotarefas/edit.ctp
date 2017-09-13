<?php
  $this->Html->addCrumb('Grupo de tarefas', '/grupotarefas');
  $this->Html->addCrumb("Adicionar Item", "");
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">Editar Grupo de tarefas</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Grupotarefa');

     echo $this->BootstrapForm->input('id');

     echo $this->BootstrapForm->input('nome', array(
               'label' => array('text' => 'Nome')));

     echo $this->BootstrapForm->input('marcador', array(
               'label' => array('text' => 'Marcador')));

   ?>

   <div class="form-group">
     <label for="GrupotarefaTipo" class="col-lg-3 control-label">Tipo: </label>
     <div class="col-lg-9">
       <select name="data[Grupotarefa][tipo]" class="form-control" id="filtertipo">
         <option value="1" <?php if($this->data['Grupotarefa']['tipo'] == 1) echo 'selected="selected"'; ?>>Demandas</option>
         <option value="3" <?php if($this->data['Grupotarefa']['tipo'] == 3) echo 'selected="selected"'; ?>>RDMs</option>
         <option value="4" <?php if($this->data['Grupotarefa']['tipo'] == 4) echo 'selected="selected"'; ?>>Chamados</option>
         <option value="6" <?php if($this->data['Grupotarefa']['tipo'] == 6) echo 'selected="selected"'; ?>>Relases</option>
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

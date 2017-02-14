<?php
  $this->Html->addCrumb('Atribuir Grupo de Tarefas', '');
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Atribuir Grupo de tarefas</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      if(sizeof($grps) >= 1)
        $disabled = '';
      else
        $disabled = 'disabled';


      echo $this->BootstrapForm->create('Grupotarefa');

      echo $this->BootstrapForm->input('GRUPO', array(
                'label' => array('text' => 'Nome'),
                'options' => $grps,
                'disabled' =>  $disabled
              ));
    ?>
    <div class="form-footer col-lg-10 col-md-6 pull-right">
      <?php
        if(sizeof($grps) >= 1)
          echo $this->BootstrapForm->submit('Atribuir Tarefas');
        else
          echo '<span class="btn btn-default pull-right disabled">Não existem grupos cadastrados para essa atividade.</span>';

        echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-lg-3 col-md-6'));
        echo $this->Form->end();
      ?>
    </div>
  </div>
</div>

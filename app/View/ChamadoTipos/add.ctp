<?php
  $this->Html->addCrumb('Tipos de Chamados', '/chamadotipos');
  $this->Html->addCrumb("Nova", array('controller' => 'chamadotipos', 'action' => 'add'));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Novo Tipo de Chamado</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('ChamadoTipo');

      echo $this->BootstrapForm->input('nome', array(
                'label' => array('text' => 'Nome: ')));

      echo $this->BootstrapForm->input('servico_id', array(
                  'label' => array('text' => 'Serviço: ')));
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

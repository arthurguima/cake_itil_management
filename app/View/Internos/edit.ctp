<?php
  $this->Html->addCrumb('Sistemas Internos', '/internos');
  $this->Html->addCrumb("Editar" , "");
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Editar Sistema Interno</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Interno');

      echo $this->BootstrapForm->input('nome', array(
                  'label' => array('text' => 'Nome: ')));

      echo $this->BootstrapForm->input('url', array(
                 'label' => array('text' => 'Url: ')));

      echo $this->BootstrapForm->input('descricao', array(
                  'label' => array('text' => 'Descrição: '),
                  'type' => "textarea"));

      echo $this->BootstrapForm->input('instrucoes', array(
                 'label' => array('text' => 'Instruções: '),
                 'type' => 'textarea',
                 'class' => 'form-control'));

      echo $this->BootstrapForm->input('id');
    ?>
    <div class="form-footer col-lg-10 pull-right">
      <?php
        echo $this->BootstrapForm->submit('Salvar');
        echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-3'));
        echo $this->Form->end();
      ?>
    </div>
  </div>
</div>

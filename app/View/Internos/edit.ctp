<?php
  $this->Html->addCrumb('Sistemas Internos', '/internos');
  $this->Html->addCrumb("Editar" , "");
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12">
    <h3 class="page-header">
      Editar Sistema Interno
      <?php
          echo $this->Html->link("<i class='fa fa-search-plus'></i>",
          array('controller' => 'internos', 'action' => 'view', $this->data['Interno']['id']),
          array('escape' => false));
      ?>
    </h3>
  </div>
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
    <div class="form-footer col-lg-10 col-md-6 pull-right">
      <?php
        echo $this->BootstrapForm->submit('Salvar');
        echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-lg-3 col-md-6'));
        echo $this->Form->end();
      ?>
    </div>
  </div>
</div>

<?php
  $this->Html->addCrumb('Contratos', '/contratos');
  $this->Html->addCrumb($this->data['Contrato']['numero'], array('controller' => 'contratos', 'action' => 'view', $this->data['Contrato']['id']));
  $this->Html->addCrumb('Itens de contrato', '');
  $this->Html->addCrumb($this->data['Item']['id'], array('controller' => 'items', 'action' => 'edit', $this->data['Item']['id']));
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      Editar Item de Contrato <?php //echo $thisto['Servico']['id']; ?>
      <?php
          echo $this->Html->link("<i class='fa fa-search-plus'></i>",
          array('controller' => 'Items', 'action' => 'view', $this->data['Item']['id']),
          array('escape' => false));
      ?>
    </h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
        echo $this->BootstrapForm->create('Item');

        echo $this->BootstrapForm->input('id');

        echo $this->BootstrapForm->input('nome', array(
                    'label' => array('text' => 'Nome')));

        echo $this->BootstrapForm->input('volume', array(
                    'label' => array('text' => 'Volume')));

        echo $this->BootstrapForm->input('metrica', array(
                    'label' => array('text' => 'Métrica')));

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

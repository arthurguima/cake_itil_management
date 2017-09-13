<?php
  $this->Html->addCrumb('Contratos', '/contratos');
  $this->Html->addCrumb('Itens de contrato', array('controller' => 'contratos', 'action' => 'view', $this->params['url']['id']));
  $this->Html->addCrumb("Novo", '');
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">Novo Item de Contrato</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Item');

      if(!strcmp($this->params['url']['controller'],'aditivos')):
        echo $this->BootstrapForm->hidden('aditivo_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
      else:
        echo $this->BootstrapForm->hidden('contrato_id', array('value' => $this->params['url']['id']));
      endif;

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

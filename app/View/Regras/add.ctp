<?php
  $this->Html->addCrumb('Contratos', '/contratos');
  $this->Html->addCrumb('Regras de ANS', "");
  $this->Html->addCrumb("Nova", '');
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Nova Regra de ANS</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Regra');

      if(!strcmp($this->params['url']['controller'],'aditivos')):
        echo $this->BootstrapForm->hidden('aditivo_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
      else:
        echo $this->BootstrapForm->hidden('contrato_id', array('value' => $this->params['url']['id']));
      endif;

      echo $this->BootstrapForm->input('servico_id', array(
                  'class' => 'select2',
                  'empty'=>'Serviço',
                  'label' => array('text' => 'Serviço: ')));

      echo $this->BootstrapForm->input('nome', array(
                  'label' => array('text' => 'Nome')));

      echo $this->BootstrapForm->input('modelo', array(
                  'label' => array('text' => 'Volume'),
                  'type' => 'textarea'));

      echo $this->BootstrapForm->input('observacao', array(
                  'label' => array('text' => 'Observação: '),
                  'type' => 'textarea'));
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

<?php
  //-- Select2 --
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2-bootstrap');
?>

<?php
  echo $this->TinyMCE->inicialize();
?>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      containerCssClass: 'select2'
    });
  });
</script>

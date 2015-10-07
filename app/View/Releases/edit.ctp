<?php
  $this->Html->addCrumb('Serviços', '');
  $this->Html->addCrumb('Release', '/releases');
  $this->Html->addCrumb("Editar", '');
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Editar Release</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Release');

      echo $this->BootstrapForm->input('id');

      echo $this->BootstrapForm->input('servico_id', array(
                'label' => array('text' => 'Serviço:'),
                'class' => "select2",
                'empty'=>'Serviço'));

      echo $this->BootstrapForm->input('versao', array(
                'label' => array('text' => 'Versão:')));

      echo $this->BootstrapForm->input('observacao', array(
                'label' => array('text' => 'Descrição:'),
                'type' => 'textarea'));

      echo $this->BootstrapForm->input('rdm_id', array(
                'label' => array('text' => 'RDM:')));

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

<script>
  $(document).ready(function() {
    $('.select2').select2({
      containerCssClass: 'select2'
    });
  });
</script>

<?php
  //-- Select2 --
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2-bootstrap');
?>

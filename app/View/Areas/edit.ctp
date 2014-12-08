<?php
  $this->Html->addCrumb('Áreas', '/areas');
  $this->Html->addCrumb('Alterar', '');
?>

<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Editar Área Cliente <?php //echo $thisto['Cliente']['id']; ?></h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Area');

      echo $this->BootstrapForm->input('nome', array(
                  'label' => array('text' => 'Nome:')));

      echo $this->BootstrapForm->input('sigla', array(
                  'label' => array('text' => 'Sigla:')));

      echo $this->BootstrapForm->input('cliente_id', array(
                  'label' => array('text' => 'Cliente:'),
                  'options' => $clientes));

      echo $this->BootstrapForm->input('status', array(
                               'checked' => 'checked',
                               'class' => 'col-sm-3 pull-left col-sm-offset-3',
                               'label' => array(
                                 'text' => 'Status?',
                                 'class' => 'control-label col-sm-2')));

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

<script>
  $(document).ready(function() {
    $("[id*='dp']").datetimepicker({
      format: "yyyy-mm-dd",
      autoclose: true,
      todayBtn: true,
      language: 'pt'
    });
  });
</script>

<?php
  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
?>

<?php
  $this->Html->addCrumb('Contratos', '/contratos');
  $this->Html->addCrumb("Novo", '');
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Novo Contrato</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Contrato');

      echo $this->BootstrapForm->input('numero', array(
                  'label' => array('text' => 'Número:')));

      echo $this->BootstrapForm->input('data_ini', array(
                  'type' => 'text',
                  'label' => array('text' => 'Data de Início:'),
                  'id' => 'dp '));

      echo $this->BootstrapForm->input('data_fim', array(
                  'label' => array('text' => 'Data de Término:'),
                  'type' => 'text',
                  'id' => 'dp '));

      echo $this->BootstrapForm->input('cliente_id', array(
                  'label' => array('text' => 'Cliente: '),
                  'options' => $clientes));

      echo $this->BootstrapForm->input('status', array(
                               'checked' => 'checked',
                               'class' => 'col-sm-3 pull-left col-sm-offset-3',
                               'label' => array(
                                 'text' => 'Status?',
                                 'class' => 'control-label col-sm-2')));

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

<script>
  $(document).ready(function() {
    $("[id*='dp']").datetimepicker({
      format: "yyyy-mm-dd",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
    });

    $('#AreaArea').select2();
  });
</script>

<?php
  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');

  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2-bootstrap');
?>

<?php
  $this->Html->addCrumb('Contratos', '/contratos');
  $this->Html->addCrumb('Aditivos', array('controller' => 'contratos', 'action' => 'view', $this->params['url']['contrato']));
  $this->Html->addCrumb('Novo', '');
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Novo Aditivo</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Aditivo');

     echo $this->BootstrapForm->hidden('contrato_id', array('value' => $this->params['url']['contrato']));

     echo $this->BootstrapForm->input('dt_inicio', array(
          'type' => 'text',
          'label' => array('text' => 'Data de Início:'),
          'id' => 'dp '));

      echo $this->BootstrapForm->input('dt_fim', array(
          'label' => array('text' => 'Data de Início:'),
          'type' => 'text',
           'id' => 'dp '));

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
        format: "dd/mm/yyyy",
      minView: 2,
      autoclose: true,
      todayBtn: true,
      language: 'pt-BR'
    });
  });
</script>

<?php
  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
?>

<?php
  $this->Html->addCrumb('Indisponibilidades', '/indisponibilidades');
  $this->Html->addCrumb("Nova", array('controller' => 'indisponibilidades', 'action' => 'add'));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Nova Indisponibilidade</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Indisponibilidade');

      echo $this->BootstrapForm->input('num_evento', array(
                  'label' => array('text' => 'Nº Evento: '),
                  'type' => 'text'));

      echo $this->BootstrapForm->input('num_incidente', array(
                  'label' => array('text' => 'Nº Incidente: '),
                  'type' => 'text'));

      echo $this->BootstrapForm->input('Servico', array(
                 'label' => array('text' => 'Serviço(s): '),
                 'input' => 'text',
                 'multiple' => true,
                 'options' => $servicos));

      echo $this->BootstrapForm->input('motivo_id', array(
                 'label' => array('text' => 'Motivo: '),
                 'options' => $motivos));

      echo $this->BootstrapForm->input('dt_inicio', array(
                 'type' => 'text',
                 'label' => array('text' => 'Início:'),
                 'id' => 'dp '));

      echo $this->BootstrapForm->input('dt_fim', array(
                 'label' => array('text' => 'Término:'),
                 'type' => 'text',
                 'id' => 'dp '));

      echo $this->BootstrapForm->input('observacao', array(
                 'label' => array('text' => 'Observação: '),
                 'type' => 'textarea',
                 'class' => 'form-control'));

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
      minuteStep: 1,
      format: "dd/mm/yyyy hh:ii",
      autoclose: true,
      todayBtn: true,
      language: 'pt-BR',
      initialDate: new Date(new Date().setMinutes(0)),
    });

    $('#ServicoServico').select2();
  });
</script>

<?php
  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');

  //Select2
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->css('plugins/select2-bootstrap');
?>

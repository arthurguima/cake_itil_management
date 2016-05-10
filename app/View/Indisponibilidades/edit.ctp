<?php
  $this->Html->addCrumb('Indisponibilidades', '/indisponibilidades');
  $this->Html->addCrumb("Nova", array('controller' => 'indisponibilidades', 'action' => 'add'));
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      Editar Indisponibilidade
      <?php
          echo $this->Html->link("<i class='fa fa-search-plus'></i>",
          array('controller' => 'indisponibilidades', 'action' => 'view', $this->data['Indisponibilidade']['id']),
          array('escape' => false));
      ?>
    </h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php

      echo $this->BootstrapForm->create('Indisponibilidade');

      echo $this->BootstrapForm->input('num_evento', array(
                  'label' => array('text' => 'Nº Evento: '),
                  'type' => 'text'));

      echo $this->BootstrapForm->input('ano', array(
                   'label' => array('text' => 'Ano: ' .
                          $this->Html->link('<i class="fa fa-eyedropper pull-right"></i>', "#",
                              array(
                                'escape' => false, 'title' => "Resgata Informações Básicas do SDM",
                                'class' => 'btn btn-default',
                                'onclick' => "javascript:getSDMInfoIndisponibilidades($('#IndisponibilidadeNumEvento').val(), $('#dpdecade').val(), 'Indisponibilidade');"
                              ))
                    ),
                   //'type' => 'text',
                   'id' => 'dpdecade'));

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
                 'id' => 'dp'));

      echo $this->BootstrapForm->input('dt_fim', array(
                 'label' => array('text' => 'Término:'),
                 'type' => 'text',
                 'id' => 'dp1'));

      echo $this->BootstrapForm->input('observacao', array(
                 'label' => array('text' => 'Observação: '),
                 'type' => 'textarea',
                 'class' => 'form-control'));

      echo $this->BootstrapForm->input('user_id', array(
             'class' => 'select2',
             'label' => array('text' => 'Responsável: '),
             'empty' => "Responsável"));

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

    $("[id*='dpdecade']").datetimepicker({
      format: "yyyy",
        startView: "decade",
        minView: "decade",
        maxView: "decade",
        viewSelect: "decade",
        autoclose: true,
        language: 'pt-BR'
    });

    $("[id*='dp']").datetimepicker({
      format: "dd/mm/yyyy hh:ii:ss",
      autoclose: true,
      todayBtn: true,
      language: 'pt-BR',
      minuteStep: 1,
    });

    $('.select2').select2({
      containerCssClass: 'select2'
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

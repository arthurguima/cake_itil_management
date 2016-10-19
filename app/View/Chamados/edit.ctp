<?php
  $this->Html->addCrumb('Demandas', '/demandas');
  $this->Html->addCrumb('Chamado', ' ');
  $this->Html->addCrumb("Editar", ' ');
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      Editar Chamado
      <?php
          echo $this->Html->link("<i class='fa fa-search-plus'></i>",
          array('controller' => 'chamados', 'action' => 'view', $this->data['Chamado']['id']),
          array('escape' => false));
      ?>
    </h3>
  </div>
</div>

<div class="row error">
  <div class="col-lg-6 well">
    <?php
      echo $this->BootstrapForm->create('Chamado');

      echo $this->BootstrapForm->input('nome', array(
        'label' => array('text' => 'Nome: ')));

      echo $this->BootstrapForm->input('numero', array(
        'label' => array('text' => 'Número: ')));

      if(!isset($this->params['url']['servico'])){
        echo $this->BootstrapForm->input('servico_id', array('label' => array('text' => 'Serviço: ')));
      }

      echo $this->BootstrapForm->input('ano', array(
                 'label' => array('text' => 'Ano: '),
                 'type' => 'text',
                 'id' => 'dpdecade'));

      echo $this->BootstrapForm->input('user_id', array(
                'class' => 'select2',
                'label' => array('text' => 'Responsável: '),
                'empty' => "Responsável"));

      echo $this->BootstrapForm->input('dt_prev_resolv', array(
                              'label' => array('text' => 'Previsão de Atendimento: '),
                              'type' => 'text',                              
                              'id' => 'dpc '));

      echo $this->BootstrapForm->input('observacao', array(
                            'label' => array('text' => 'Observação: '),
                            'type' => 'textarea'));

      echo $this->BootstrapForm->input('status_id', array(
                  'label' => array('text' => 'Status: ')));
    ?>

      <div id="chamadoTipoList"></div>

    <?php

      echo $this->BootstrapForm->input('aberto', array(
         'class' => 'col-sm-3 pull-left col-sm-offset-3',
         'label' => array(
           'text' => 'Aberto?',
           'class' => 'control-label col-sm-2')));

      echo $this->BootstrapForm->input('pai', array(
         'class' => 'col-sm-3 pull-left col-sm-offset-3',
         'type' => 'checkbox',
         'label' => array(
           'text' => 'Pai?',
           'class' => 'control-label col-sm-2')));

     echo $this->BootstrapForm->input('demanda_id', array(
                 'label' => array('text' => 'Demanda: '),
                 'input' => 'text',
                // 'multiple' => "false",
                 'empty' => 'Demanda',
                 'options' => $demandas));

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
    $('.select2').select2({
      containerCssClass: 'select2'
    });

    $("[id*='dpdecade']").datetimepicker({
      format: "yyyy",
        startView: "decade",
        minView: "decade",
        maxView: "decade",
        viewSelect: "decade",
        autoclose: true,
        language: 'pt-BR'
    });

    $("[id*='dpc']").datetimepicker({
      format: "dd/mm/yyyy",
      minView: 2,
      autoclose: true,
      todayBtn: true,
      language: 'pt-BR'
    });

    function getChamadoTipos(servico){
      $.ajax({
        url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "chamadotipos/optionlist?tipo=<?php echo $this->data['ChamadoTipo']['id'] ?>&servico=" + servico,
        cache: false,
        success: function(html){
          $("#chamadoTipoList").html(html);
        }
      })
    }

    $( "select#ChamadoServicoId" ).change(function () {
      var str = "";
      $( "select#ChamadoServicoId option:selected" ).each(function() {
         getChamadoTipos($(this).val());
      })
    }).change();

    $('#ChamadoDemandaId').select2();

  });
</script>

<?php
  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');

  //-- Select2 --
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2-bootstrap');
?>

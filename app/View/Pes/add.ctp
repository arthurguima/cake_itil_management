<?php
  $this->Html->addCrumb('PAs', '/Pees');
  $this->Html->addCrumb("Nova PA", "");
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Nova PA</h3></div>
</div>

<div class="row">
  <div class="col-lg-12">
    <?php echo $this->BootstrapForm->create('Pe'); ?>
    <div class="col-lg-6">
      <?php
        if(!strcmp($this->params['url']['controller'],'sses')){
          echo $this->BootstrapForm->hidden('ss_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
          echo $this->BootstrapForm->hidden('servico_id', array('value' => $this->params['url']['servico'], 'type'=> "hidden"));
        }

        /*echo $this->BootstrapForm->input('nome', array(
                    'label' => array('text' => 'Nome: ')));*/

        echo $this->BootstrapForm->input('numero', array(
                    'label' => array('text' => 'Número: ')));

        echo $this->BootstrapForm->input('ano', array(
                   'label' => array('text' => 'Ano: '),
                   'type' => 'text',
                   'id' => 'dpdecade',
                   'value' => date('Y')));

        echo $this->BootstrapForm->input('num_ce', array(
                    'label' => array('text' => 'Número da CE de envio: ')));

        echo $this->BootstrapForm->input('dt_emissao', array(
                   'label' => array('text' => 'Data de Emissão: '),
                   'type' => 'text',
                   'id' => 'dp'));

        echo $this->BootstrapForm->input('dt_inicio', array(
                   'label' => array('text' => 'Data Prevista de Início da OS: '),
                   'type' => 'text',
                   'id' => 'dp'));

        echo $this->BootstrapForm->input('temp_estimado', array(
                    'label' => array('text' => 'Tempo estimado em dias: ')));

        echo $this->BootstrapForm->input('validade_pdd', array(
                    'label' => array('text' => 'Fim da Validade do PDD: '),
                    'type' => 'text',
                    'id' => 'dp'));
      ?>
    </div>
    <div class="col-lg-6">
      <?php

        echo $this->BootstrapForm->input('user_id', array(
                'class' => 'select2',
                'label' => array('text' => 'Responsável: '),
                'selected' => $this->Session->read('User.uid'),
                'empty' => "Responsável"));

        echo $this->BootstrapForm->input('status_id', array(
                    'label' => array('text' => 'Status: ')));

        echo $this->BootstrapForm->input('cvs_url', array(
                    'label' => array('text' => 'Url: ')));

        echo $this->BootstrapForm->input('observacao', array(
                    'label' => array('text' => 'Observação: '),
                    'type' => 'textarea'));
     ?>
    </div>
  </div>
  <div class="form-footer col-lg-12 col-md-6 pull-right">
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

    $('#myModal').on('shown.bs.modal', function (e) {
      document.getElementById('modal-body').appendChild(
          document.getElementById('demandaFrame')
      );
      document.getElementById('demandaFrame').style.display = "block";
      //document.getElementById('demandaFrame').style.height = "720px";
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

    $("[id*='dp']").datetimepicker({
      format: "dd/mm/yyyy",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
    });

    // Quando selecionado o Servico
    $( "select#PeServicoId" ).change(function () {
      var str = "";
      $( "select#PeServicoId option:selected" ).each(function() {
         getDemandas($(this).val()); //passa o valor do item do select selecionado
      })
    }).change();
  });
</script>

<?php
  //-- ClarityID
  echo $this->Html->script('getIdClarity.js');

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

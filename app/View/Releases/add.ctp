<?php
  $this->Html->addCrumb('Serviços', '');
  $this->Html->addCrumb('Release', '/releases');
  $this->Html->addCrumb("Novo", '');
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">Novo Release</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Release');

      echo $this->BootstrapForm->input('servico_id', array(
                'label' => array('text' => 'Serviço:'),
                'class' => "select2",
                'empty'=>'Serviço'));

      echo $this->BootstrapForm->input('versao', array(
                'label' => array('text' => 'Versão:')));

      echo $this->BootstrapForm->input('observacao', array(
                'label' => array('text' => 'Descrição:'),
                'type' => 'textarea'));

      echo $this->BootstrapForm->input('dt_ini_prevista', array(
                 'label' => array('text' => 'Data prevista de Início: '),
                 'type' => 'text',
                 'id' => 'dp'));

      echo $this->BootstrapForm->input('dt_ini_fim', array(
                'label' => array('text' => 'Data prevista de Fim: '),
                'type' => 'text',
                'id' => 'dp'));

      echo $this->BootstrapForm->input('dt_fim', array(
                'label' => array('text' => 'Data de Finalização: '),
                'type' => 'text',
                'id' => 'dp'));

      echo $this->BootstrapForm->input('user_id', array(
             'class' => 'select2user',
             'label' => array('text' => 'Responsável: '),
             'selected' => $this->Session->read('User.uid'),
             'empty' => "Responsável"));

       echo $this->BootstrapForm->input('rdm_id', array(
              'class' => 'select2rdm',
              'label' => array('text' => 'RDM: '),
              'empty' => "RDM"));

    ?>

    <!--div id="rdmList"></div-->

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
      language: "pt-BR",
      theme: "bootstrap"
    });
    <?php echo $this->User->select2(); ?>
    <?php echo $this->Rdm->select2(); ?>

    $("[id*='dp']").datetimepicker({
      format: "dd/mm/yyyy",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
    });

    /*function getRdms(servico){
      $.ajax({
        url: <?php //echo "'" . Router::url('/', true) . "'"; ?> + "rdms/optionlist?servico=" + servico,
        cache: false,
        success: function(html){
          $("#rdmList").html(html);
        }
      })
    }

    $( "select#ReleaseServicoId" ).change(function () {
      var str = "";
      $( "select#ReleaseServicoId option:selected" ).each(function() {
         getRdms($(this).val());
      })
    }).change();*/

  });
</script>

<?php
  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');

  //-- Select2 --
  echo $this->Html->script('plugins/select2/select2.full.min');
  echo $this->Html->css('plugins/select2.min');
  echo $this->Html->css('plugins/select2-bootstrap.min');
  echo $this->Html->script('plugins/select2/pt-BR');
?>

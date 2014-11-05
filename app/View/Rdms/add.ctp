<?php
  $this->Html->addCrumb('RDM', '/rdms');
  $this->Html->addCrumb("Nova RDM", "");
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Nova RDM</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Rdm');

      echo $this->BootstrapForm->input('nome', array(
                  'label' => array('text' => 'Nome: ')));

      echo $this->BootstrapForm->input('numero', array(
                  'label' => array('text' => 'Número: ')));

      echo $this->BootstrapForm->input('servico_id', array(
                  'label' => array('text' => 'Serviço: ')));

      echo $this->BootstrapForm->input('versao', array(
                 'label' => array('text' => 'Versão do serviço: ')));

      echo $this->BootstrapForm->input('dt_prevista', array(
                  'label' => array('text' => 'Data prevista: '),
                  'type' => 'text',
                  'id' => 'dp '));

      echo $this->BootstrapForm->input('dt_executada', array(
                  'label' => array('text' => 'Data de execução: '),
                  'type' => 'text',
                  'id' => 'dp '));
    ?>

    <div id="demandaList"></div>

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
      format: "dd/mm/yyyy",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
    });

    function getDemandas(servico){
      $.ajax({
        url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "demandas/optionlist?servico=" + servico,
        cache: false,
        success: function(html){
          $("#demandaList").html(html);
        }
      })
    }

    $( "select#RdmServicoId" ).change(function () {
      var str = "";
      $( "select option:selected" ).each(function() {
         getDemandas($(this).val());
      })
    }).change();
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

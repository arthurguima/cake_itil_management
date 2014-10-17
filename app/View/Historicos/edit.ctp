<?php
  $this->Html->addCrumb('Demandas', '/demandas');
  $this->Html->addCrumb("id:" . $this->params['url']['id'], array('controller' => 'demandas', 'action' => 'view', $this->params['url']['id']));
  $this->Html->addCrumb('Histórico de Demanda', '');
  $this->Html->addCrumb("Editar", array('controller' => ''));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Novo Historico de Demanda</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Historico');

      echo $this->BootstrapForm->input('data', array(
                              'label' => array('text' => 'Data: '),
                              'type' => 'text',
                              'id' => 'dp '));

      echo $this->BootstrapForm->input('analista', array(
                  'label' => array('text' => 'Analista: ')));

      echo $this->BootstrapForm->input('descricao', array(
                  'label' => array('text' => 'Descrição: '),
                  'type' => 'textarea'));

      echo $this->BootstrapForm->input('id');

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
  });
</script>

<?php
  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
?>

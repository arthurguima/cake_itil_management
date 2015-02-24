<?php
  $this->Html->addCrumb('Procedimentos', '/procedimentos');
  $this->Html->addCrumb("Editar", "");
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Editar Procedimento Documentado</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Procedimento');

      echo $this->BootstrapForm->input('nome', array(
                  'label' => array('text' => 'Nome: ')));

      echo $this->BootstrapForm->input('url', array(
                 'label' => array('text' => 'Url: ')));

      echo $this->BootstrapForm->input('dt_alteracao', array(
                  'label' => array('text' => 'Data de Alteração: '),
                  'type' => "text",
                  'id' => 'dp'));

      echo $this->BootstrapForm->input('responsavel', array(
                 'label' => array('text' => 'Responsável: ')));

      echo $this->BootstrapForm->input('descricao', array(
                  'label' => array('text' => 'Descrição: '),
                  'type' => "textarea"));

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

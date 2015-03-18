<?php
  $this->Html->addCrumb('Contratos', '/contratos');
  $this->Html->addCrumb("Indicadores","");
  $this->Html->addCrumb("Novo", '');
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Registrar Indicador</h3></div>
</div>

<div class="row">
  <div class="col-lg-4">
    <?php
      echo $this->BootstrapForm->create('Indicadore');

      echo $this->BootstrapForm->input('regra_id', array(
                  'label' => array('text' => 'Regra de ANS'),
                  'empty' => ""));

      echo $this->BootstrapForm->input('mes', array(
                 'label' => array('text' => 'Mês: '),
                 'type' => 'text',
                 'id' => 'dpyear',
                 'value' => date('m')));

     echo $this->BootstrapForm->input('ano', array(
                'label' => array('text' => 'Ano: '),
                'type' => 'text',
                'id' => 'dpdecade',
                'value' => date('Y')));

      echo $this->BootstrapForm->input('valor', array(
                  'label' => array('text' => 'Valor'),
                  'type' => 'textarea'));

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

<?php
  echo $this->TinyMCE->inicialize();
?>

<?php
  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
?>

<script>
/*
function getModelo(regra){
  $.ajax({
    url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "regras/modelo?id=" + regra,
    cache: false,
    success: function(html){
      //tinymce.activeEditor.execCommand('mceCleanup', false);
      tinymce.activeEditor.execCommand('mceSetContent', false, html);
    }
  })
}

$( "select#IndicadoreRegraId" ).change(function () {
  var str = "";
  $( "select#IndicadoreRegraId option:selected" ).each(function() {
     getModelo($(this).val());
  })
}).change();*/

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

  $("[id*='dpyear']").datetimepicker({
      format: "mm",
      startView: "year",
      minView: "year",
      maxView: "year",
      viewSelect: "year",
      autoclose: true,
      language: 'pt-BR',
      initialDate: new Date(new Date().setMinutes(0)),
  });

});
</script>

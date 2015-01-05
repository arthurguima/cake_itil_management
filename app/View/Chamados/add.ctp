<?php
  if(isset($this->params['url']['servico'])){
    $this->Html->addCrumb('Demandas', '/demandas');
    $this->Html->addCrumb("id:" . $this->params['url']['id'], array('controller' => 'demandas', 'action' => 'view', $this->params['url']['id']));
  }
  $this->Html->addCrumb('Chamado', '');
  $this->Html->addCrumb("Novo", array('controller' => 'chamados', 'action' => 'add'));
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Novo Chamado</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Chamado');

      echo $this->BootstrapForm->input('nome', array(
        'label' => array('text' => 'Nome: ')));

      echo $this->BootstrapForm->input('numero', array(
        'label' => array('text' => 'Número: ')));

      if(isset($this->params['url']['servico'])){
        echo $this->BootstrapForm->hidden('demanda_id', array('value' => $this->params['url']['id']));
        echo $this->BootstrapForm->hidden('servico_id', array('value' => $this->params['url']['servico']));
      }
      else{
        echo $this->BootstrapForm->input('servico_id', array('label' => array('text' => 'Serviço: ')));
      }

      echo $this->BootstrapForm->input('ano', array(
                 'label' => array('text' => 'Ano: '),
                 'type' => 'text',
                 'id' => 'dpdecade',
                 'value' => date('Y')));

      echo $this->BootstrapForm->input('responsavel', array(
                 'label' => array('text' => 'Responsável: '),
                 'value' => $this->Ldap->nomeUsuario()));

      echo $this->BootstrapForm->input('observacao', array(
                            'label' => array('text' => 'Observação: '),
                            'type' => 'textarea'));

      echo $this->BootstrapForm->input('status_id', array(
                  'label' => array('text' => 'Status: ')));

    ?>

    <div id="chamadoTipodemandaList"></div>

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

    function getChamadoTipos(servico){
      $.ajax({
        url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "chamadotipos/optionlist?servico=" + servico,
        cache: false,
        success: function(html){
          $("#chamadoTipodemandaList").html(html);
        }
      })
    }

    $( "select#ChamadoServicoId" ).change(function () {
      var str = "";
      $( "select option:selected" ).each(function() {
         getChamadoTipos($(this).val());
      })
    }).change();
  });
</script>

<?php
  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
?>

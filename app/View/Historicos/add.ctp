<?php
  if(isset($this->params['url']['popup']) && $this->params['url']['popup'] == 'true'){
      /* CSS */
      //-- Bootstrap Core CSS --
      echo $this->Html->css('bootstrap.min.css');
      //-- MetisMenu CSS --
      echo $this->Html->css('plugins/metisMenu/metisMenu.min.css');
      //-- Timeline CSS --
      //echo $this->Html->css('plugins/timeline.css');
      //-- Custom Fonts
      echo $this->Html->css('font-awesome-4.2.0/css/font-awesome.min.css');
      //-- Custom admin CSS --
      echo $this->Html->css('sb-admin-2.css');

      echo $this->Html->meta('icon');
      /* JS */
      //-- jQuery Version 1.11.0 --
      echo $this->Html->script('jquery-1.11.0.js');
      //-- Bootstrap Core JavaScript --
      echo $this->Html->script('bootstrap.min.js');
      //-- Metis Menu Plugin JavaScript -->
      echo $this->Html->script('plugins/metisMenu/metisMenu.min.js');
      echo $this->Html->script('sb-admin-2.js');
      //-- Sidebar
      echo $this->Html->script('sidebar.js');
  }

  $this->Html->addCrumb('Demandas', '/demandas');
  $this->Html->addCrumb("id:" . $this->params['url']['id'], array('controller' => 'demandas', 'action' => 'view', $this->params['url']['id']));
  $this->Html->addCrumb('Histórico', '');
  $this->Html->addCrumb("Novo", array('controller' => 'historicos', 'action' => 'add'));
?>
<style media="screen">
    body{
      background-color: #fff;
    }
</style>

<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">Novo Historico</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Historico');

      switch($this->params['url']['controller']){
        case 'demandas':
          $con =  $this->BootstrapForm->hidden('demanda_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
          break;
        case 'rdms':
          $con =  $this->BootstrapForm->hidden('rdm_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
          break;
        case 'pes':
          $con =  $this->BootstrapForm->hidden('pe_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
          break;
        case 'ords':
          $con =  $this->BootstrapForm->hidden('ord_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
          break;
        case 'sses':
          $con =  $this->BootstrapForm->hidden('ss_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
          break;
        case 'chamados':
          $con =  $this->BootstrapForm->hidden('chamado_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
          break;
        case 'indisponibilidades':
          $con =  $this->BootstrapForm->hidden('indisponibilidade_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
          break;
        case 'releases':
          $con =  $this->BootstrapForm->hidden('release_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
          break;
      }
      if(isset($con))
        echo $con;

      echo $this->BootstrapForm->input('data', array(
                              'label' => array('text' => 'Data: '),
                              'type' => 'text',
                              'value' => date('d/m/Y'),
                              'id' => 'dp '));

      echo $this->BootstrapForm->input('analista', array(
                  'label' => array('text' => 'Analista: '),
                  'value' => $this->Session->read('User.nome')));

      echo $this->BootstrapForm->input('descricao', array(
                  'label' => array('text' => 'Descrição: '),
                  'type' => 'textarea'));

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
  echo $this->TinyMCE->Simpleinicialize();
?>

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

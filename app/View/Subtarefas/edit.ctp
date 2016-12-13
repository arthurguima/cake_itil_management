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

  $this->Html->addCrumb('Tarefas', '');
  $this->Html->addCrumb("Editar");
?>
<style media="screen">
    body{
      background-color: #fff;
    }
</style>

<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Editar Tarefa</h3></div>
</div>
<style media="screen">
    body{
      background-color: #fff;
    }
</style>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Subtarefa');

      echo $this->BootstrapForm->input('user_id', array(
              'class' => 'select2',
              'label' => array('text' => 'Responsável: '),
              'empty' => "Responsável"));

        if(!isset($this->params['url']['controller']))
          echo $this->BootstrapForm->input('servico_id', array(
                'class' => 'select2',
                'label' => array('text' => 'Serviço: '),
                'empty' => "Serviço"));

        echo $this->BootstrapForm->input('dt_prevista', array(
                                'label' => array('text' => 'Data Prevista: '),
                                'type' => 'text',
                                'id' => 'dp '));

        echo $this->BootstrapForm->input('descricao', array(
                    'label' => array('text' => 'Tarefa: '),
                    'type' => 'textarea'));

        echo $this->BootstrapForm->input('check', array(
                                 'type' => 'checkbox',
                                 'class' => 'col-sm-3 pull-right col-sm-offset',
                                 'label' => array(
                                   'text' => 'Finalizada?',
                                   'class' => 'control-label',
                                   'style' => "left: -400px;")));
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

    $('.select2').select2({
      containerCssClass: 'select2'
    });
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

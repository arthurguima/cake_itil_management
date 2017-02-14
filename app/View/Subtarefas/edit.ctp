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
              'class' => 'select2user',
              'label' => array('text' => 'Responsável: '),
              'empty' => "Responsável"));

        if(!isset($this->params['url']['controller']))
          echo $this->BootstrapForm->input('servico_id', array(
                'class' => 'select2',
                'label' => array('text' => 'Serviço: '),
                'empty' => "Serviço"));

        echo $this->BootstrapForm->input('dt_inicio', array(
               'label' => array('text' => 'Data Prevista de Início: '),
               'type' => 'text',
               'id' => 'dp '));

        echo $this->BootstrapForm->input('dt_prevista', array(
                                'label' => array('text' => 'Data Prevista de Fim: '),
                                'type' => 'text',
                                'id' => 'dp '));

        echo $this->BootstrapForm->input('dt_fim', array(
                                'label' => array('text' => 'Data de Finalização: '),
                                'type' => 'text',
                                'id' => 'dp '));


        echo $this->BootstrapForm->input('descricao', array(
                    'label' => array('text' => 'Tarefa: '),
                    'type' => 'textarea'));

        echo $this->BootstrapForm->input('id');

        $options = array( 1 => 'Sim', 0 => 'Não');
        echo $this->BootstrapForm->input('notificar', array(
                                'label' => array('text' => 'Notificar responsável por e-mail? '),
                                'type' => 'select',
                                'options' => $options,
                                'selected' => 0,
                                'checked' => ''));
      ?>
      <div class="form-group">
        <label for="SubtarefaCheck" class="col-lg-3 control-label">Status: </label>
        <div class="col-lg-9">
          <select name="data[Subtarefa][check]" class="form-control" id="filtercheck">
            <option value="0" <?php if($this->data['Subtarefa']['check'] == 0) echo 'selected="selected"'?>>Em andamento</option>
            <option value="1" <?php if($this->data['Subtarefa']['check'] == 1) echo 'selected="selected"'?>>Finalizada</option>
            <option value="2" <?php if($this->data['Subtarefa']['check'] == 2) echo 'selected="selected"'?>>Aguardando Início</option>
          </select>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="error">
      	<div class="well">
      		<h3 class="page-header">Como Funcionam as tarefas?</h3>
          <ul>
            <li>As tarefas estão sempre associadas ao usuário definido e um sistema.</li>
            <li>Elas também podem ser associadas as Demandas, RDMs, Chamados e Releases.</li>
            <li>Caso não exista uma <b>Data Prevista de Início</b> o sistema considera a <b>Data de criação da Tarefa</b>.</li>
            <li>Caso não exista uma <b>Data de Finalização</b> o sistema considera a <b>Data Prevista de Fim</b>.</li>
            <li>Existem apenas 3 status para as Demandas: Aguardando Início, Em andamento, Finalizada.</li>
            <br/>
            <!--li>As tarefas do Grupo de tarefas são criadas sob a responsabilidade do usuário e com a <b>Data Prevista de Fim</b> = 'data de hoje' + 1 dia.</li-->
          </ul>
        </div>
      </div>
    </div>

    <div class="form-footer col-lg-10 col-md-12 pull-right">
      <?php
        echo $this->BootstrapForm->submit('Salvar');
        echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-lg-3 col-md-6'));
        echo $this->Form->end();
      ?>
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
      language: "pt-BR",
      theme: "bootstrap"
    });

    <?php echo $this->User->select2(); ?>
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

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

  $this->Html->addCrumb('Sub-tarefa', '');
  $this->Html->addCrumb("Nova", array('controller' => 'subtarefas', 'action' => 'add'));
?>
<style media="screen">
    body{
      background-color: #fff;
    }
</style>

<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">Nova Tarefa</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Subtarefa');

      switch($this->params['url']['controller']){
        case 'demandas':
          $con =  $this->BootstrapForm->hidden('demanda_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
          break;
        case 'chamados':
          $con =  $this->BootstrapForm->hidden('chamado_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
          break;
        case 'rdms':
          $con =  $this->BootstrapForm->hidden('rdm_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
          break;
        case 'releases':
          $con =  $this->BootstrapForm->hidden('release_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));
          break;
      }
      if(isset($con))
        echo $con;

        echo $this->BootstrapForm->input('user_id', array(
               'class' => 'select2user',
               'label' => array('text' => 'Responsável: '),
               'selected' => $this->Session->read('User.uid'),
               'empty' => "Responsável"));

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

        $options = array( 1 => 'Sim', 0 => 'Não');
        echo $this->BootstrapForm->input('notificar', array(
                                'label' => array('text' => 'Notificar responsável por e-mail? '),
                                'type' => 'select',
                                'options' => $options,
                                'selected' => 0,
                                'checked' => ''));

        if(!isset($this->params['url']['controller'])){
          echo $this->BootstrapForm->input('servico_id', array(
           'class' => 'select2',
           'label' => array('text' => 'Serviço: '),
           'selected' => $this->params['url']['servico'],
           'empty' => "Serviço"));

          $options = array(0 => 'Demanda', 1 => 'RDM', 2 => "Release", 3 => "Chamado", 4 => "Somente o Serviço");
          echo $this->BootstrapForm->input('associar', array(
               'label' => array('text' => 'Associar com: '),
               'type' => 'select',
               'options' => $options,
               'selected' => 4));

           echo $this->BootstrapForm->input('Rdm', array(
                      'class' => 'select2rdm',
                      'label' => array('text' => 'RDMs: '),
                      'empty' => "RDMs"));
        }
        else
          echo  $this->BootstrapForm->hidden('servico_id', array('value' => $this->params['url']['servico'], 'type'=> "hidden"));

      ?>

      <div class="form-group">
          <label for="SubtarefaCheck" class="col-lg-3 control-label">Status: </label>
          <div class="col-lg-9">
            <select name="data[Subtarefa][check]" class="form-control" id="filtercheck">
              <option value="2">Aguardando Início</option>
              <option value="0">Em andamento</option>
              <option value="1">Finalizada</option>
            </select>
          </div>
      </div>

      <div class="form-footer col-lg-10 col-md-6 pull-right">
        <?php
          echo $this->BootstrapForm->submit('Salvar');
          echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-lg-3 col-md-6'));
          echo $this->Form->end();
        ?>
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
          <!-- li>As tarefas do Grupo de tarefas são criadas sob a responsabilidade do usuário e com a <b>Data Prevista de Fim</b> = 'data de hoje' + 1 dia.</li -->
        </ul>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    <?php echo $this->Rdm->select2(); ?>

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

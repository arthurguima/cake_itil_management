<?php
  $this->Html->addCrumb('Usuários', '/users');
  $this->Html->addCrumb("Novo", "");
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Novo Usuário</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('User');

      echo $this->BootstrapForm->input('nome', array(
                  'label' => array('text' => 'Nome: ')));

      echo $this->BootstrapForm->input('matricula', array(
                  'label' => array('text' => 'Matrícula: ')));

      echo $this->BootstrapForm->input('mail', array(
                  'label' => array('text' => 'E-mail: ')));

      echo $this->BootstrapForm->input('Cliente', array(
                  'label' => array('text' => 'Clientes: '),
                  'input' => 'text',
                  'multiple' => true,));
    ?>
      <div class="form-group">
        <label for="UserWorkspaceFirst" class="col-lg-3 control-label">Workspace: </label>
        <div class="col-lg-9">
          <select name="data[User][workspace_first]" class="form-control" id="filterambiente">
            <option value="1">Demandas</option>
            <option value="2">Tarefas</option>
            <option value="3">RDMs</option>
            <option value="4">Chamados</option>
            <option value="5">Indisponibilidades</option>
            <option value="6">Relases</option>
          </select>
        </div>
      </div>
    </div>

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
    $('#ClienteCliente').select2();
  });
</script>

<?php
  //Select2
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->css('plugins/select2-bootstrap');
?>

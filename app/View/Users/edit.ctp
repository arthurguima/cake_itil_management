<?php
  $this->Html->addCrumb('Usuários', '/users');
  $this->Html->addCrumb("Editar", "");
?>
<div class="col-lg-12 page-header-box">
  <div class="col-lg-12"><h3 class="page-header">Editar Usuário</h3></div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('User');

      echo $this->BootstrapForm->input('id');

      echo $this->BootstrapForm->input('nome', array(
                  'label' => array('text' => 'Nome: ')));

      echo $this->BootstrapForm->input('matricula', array(
                  'label' => array('text' => 'Matrícula: ')));

      echo $this->BootstrapForm->input('mail', array(
                  'label' => array('text' => 'E-mail: ')));

      $options = array( 1 => 'Sim', 0 => 'Não');
      echo $this->BootstrapForm->input('email_rdms', array(
                  'label' => array('text' => 'Receber E-mail sobre RDMs? '),
                  'options' => $options,
                  'type' => 'select'));

      echo $this->BootstrapForm->input('Cliente', array(
                  'label' => array('text' => 'Clientes: '),
                  'input' => 'text',
                  'multiple' => true,));
    ?>
      <div class="form-group">
        <label for="UserWorkspaceFirst" class="col-lg-3 control-label">Workspace: </label>
        <div class="col-lg-9">
          <select name="data[User][workspace_first]" class="form-control" id="filterambiente">
            <option value="1" <?php if($this->data['User']['workspace_first'] == 1) echo 'selected="selected"'; ?>>Demandas</option>
            <option value="2" <?php if($this->data['User']['workspace_first'] == 2) echo 'selected="selected"'; ?>>Tarefas</option>
            <option value="3" <?php if($this->data['User']['workspace_first'] == 3) echo 'selected="selected"'; ?>>RDMs</option>
            <option value="4" <?php if($this->data['User']['workspace_first'] == 4) echo 'selected="selected"'; ?>>Chamados</option>
            <option value="5" <?php if($this->data['User']['workspace_first'] == 5) echo 'selected="selected"'; ?>>Indisponibilidades</option>
            <option value="6" <?php if($this->data['User']['workspace_first'] == 6) echo 'selected="selected"'; ?>>Releases</option>
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
    $('#ClienteCliente').select2({
      language: "pt-BR",
      theme: "bootstrap"
    });
  });
</script>

<?php
  //-- Select2 --
  echo $this->Html->script('plugins/select2/select2.full.min');
  echo $this->Html->css('plugins/select2.min');
  echo $this->Html->css('plugins/select2-bootstrap.min');
  echo $this->Html->script('plugins/select2/pt-BR');
?>

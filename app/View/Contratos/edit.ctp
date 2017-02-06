<?php
  $this->Html->addCrumb('Contratos', '/contratos');
  $this->Html->addCrumb('Alterar', '');
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      Editar Contrato
      <?php
          echo $this->Html->link("<i class='fa fa-search-plus'></i>",
          array('controller' => 'Contratos', 'action' => 'view', $this->data['Contrato']['id']),
          array('escape' => false));
      ?>
    </h3>
    </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Contrato');

      echo $this->BootstrapForm->input('numero', array(
                  'label' => array('text' => 'Número:')));

      echo $this->BootstrapForm->input('data_ini', array(
                  'type' => 'text',
                  'label' => array('text' => 'Data de Início:'),
                  'id' => 'dp '));

      echo $this->BootstrapForm->input('data_fim', array(
                  'label' => array('text' => 'Data de Término:'),
                  'type' => 'text',
                  'id' => 'dp '));

      echo $this->BootstrapForm->input('cliente_id', array(
                  'label' => array('text' => 'Cliente: '),
                  'options' => $clientes));

      echo $this->BootstrapForm->input('status', array(
                               'checked' => 'checked',
                               'class' => 'col-sm-3 pull-left col-sm-offset-3',
                               'label' => array(
                                 'text' => 'Status?',
                                 'class' => 'control-label col-sm-2')));

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

  <div class="col-lg-12">
    <div class="panel panel-default panel-success">
      <div class="panel-heading">
        <p>
          <h3 class="panel-title">Itens de Contrato
          <?php echo $this->Html->link("<i class='fa fa-plus pull-right'></i>",
            array('controller' => 'items', 'action' => 'add','?' => array('controller' => 'contratos', 'id' => $this->data['Contrato']['id'], 'action' => 'edit')),
            array('escape' => false)); ?></h3>
        </p>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="dataTables-contrato">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Volume</th>
                <th>Métrica</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($this->data['Item'] as $item): ?>
                <tr>
                  <td><?php echo $item['nome']; ?></td>
                  <td><?php echo $item['volume']; ?></td>
                  <td><?php echo $item['metrica']; ?></td>
                  <td>
                     <?php
                        echo $this->Html->link("<i class='fa fa-pencil'></i>",
                              array('controller' => 'items', 'action' => 'edit', $item['id'], '?' => array('action' => 'edit', 'controller' => 'contratos', 'id' => $this->data['Contrato']['id'])),
                              array('escape' => false));
                        echo $this->BootstrapForm->postLink("<i class='fa fa-remove' style='margin-left: 5px;'></i>",
                              array('controller' => 'items', 'action' => 'delete', $item['id']),
                              array('escape' => false), "Você tem certeza");
                     ?>
                   </td>
                </tr>
              <?php endforeach; ?>
            <?php unset($item); ?>
          </tbody>
        </table>
      </div>
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

    $('#AreaArea').select2(
      language: "pt-BR",
      theme: "bootstrap"
    );
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

<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Nova Nota</h3></div>
</div>

<div class="col-lg-12 page-header-box">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('Note');
      echo $this->BootstrapForm->hidden('release_id', array('value' => $this->params['url']['id'], 'type'=> "hidden"));

      echo $this->BootstrapForm->input('valor', array(
                  'label' => array('text' => 'Nota: '),
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

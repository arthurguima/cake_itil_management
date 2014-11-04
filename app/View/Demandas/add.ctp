<?php
  $this->Html->addCrumb('Demandas', '/demandas');
  $this->Html->addCrumb("Nova Demanda", '');
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Nova Demanda</h3></div>
</div>

<div class="row">
  <div class="col-lg-12">
    <?php
      echo $this->BootstrapForm->create('Demanda');

     echo $this->BootstrapForm->input('clarity_url', array(
                'label' => array('text' => 'URL do Clarity: '),
                'type' => 'text',
                'onblur' =>'getID();')); ?>

      <div class="form-group">
        <label for="DemandaClarityId" class="control-label col-sm-2">Clarity ID: </label>
        <div class="col-sm-10">
           <div class='input-group'>
             <input name="data[Demanda][clarity_id]" style="background-color: #EEEEEE;" class="form-control" type="text" id="DemandaClarityId">
             <span class='input-group-addon'><a id='viewClarity' data-toggle='modal' data-target='#myModal'></a></span>
           </div>
        </div>
     </div>

     <?php echo $this->BootstrapForm->input('clarity_dm_id', array(
                 'label' => array('text' => 'DM Clarity: '),
                 'type' => 'text'));

      echo $this->BootstrapForm->input('mantis_id', array(
                 'label' => array('text' => 'Nº Mantis: '),
                 'type' => 'text'));

      echo $this->BootstrapForm->input('nome', array(
                 'label' => array('text' => 'Nome: '),
                 'type' => 'text'));

      echo $this->BootstrapForm->input('data_cadastro', array(
                 'label' => array('text' => 'Data de Cadastro: '),
                 'type' => 'text',
                 'id' => 'dp '));

      echo $this->BootstrapForm->input('dt_prevista', array(
                 'label' => array('text' => 'Data Prevista de Término: '),
                 'type' => 'text',
                 'id' => 'dp '));

      echo $this->BootstrapForm->input('data_homologacao', array(
                 'label' => array('text' => 'Data de Homologação: '),
                 'type' => 'text',
                 'id' => 'dp '));

      echo $this->BootstrapForm->input('criador', array(
                 'label' => array('text' => 'Solicitante: ')));

      echo $this->BootstrapForm->input('executor', array(
                 'label' => array('text' => 'Responsável: ')));

      echo $this->BootstrapForm->input('prioridade', array(
                 'label' => array('text' => 'Prioridade: ')));

      echo $this->BootstrapForm->input('demanda_tipo_id', array(
                  'label' => array('text' => 'Tipo da Demanda: ')));

      echo $this->BootstrapForm->input('servico_id', array(
                  'label' => array('text' => 'Serviço: ')));

      echo $this->BootstrapForm->input('status_id', array(
                  'label' => array('text' => 'Status: ')));

      echo $this->BootstrapForm->input('descricao', array(
                  'label' => array('text' => 'Descrição: '),
                  'type' => 'textarea'));

    ?>
    <div class="form-footer col-lg-10 pull-right">
      <?php
        echo $this->BootstrapForm->submit('Salvar');
        echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-md-3'));
        echo $this->Form->end();
      ?>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body" id="modal-body">
      </div>
    </div>
  </div>
</div>
<iframe id="demandaFrame" style="display:none;" name='demanda' width='100%' height='720px' frameborder='0'></iframe>

<script>
  $(document).ready(function() {
    $("[id*='dp']").datetimepicker({
      format: "dd/mm/yyyy",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
    });

    $('#myModal').on('shown.bs.modal', function (e) {
      document.getElementById('modal-body').appendChild(
          document.getElementById('demandaFrame')
      );
      document.getElementById('demandaFrame').style.display = "block";
      //document.getElementById('demandaFrame').style.height = "720px";
    })
  });
</script>

<?php
  //-- ClarityID
  echo $this->Html->script('getIdClarity.js');

  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
?>

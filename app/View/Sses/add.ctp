<?php
  $this->Html->addCrumb('SS', '/Sses');
  $this->Html->addCrumb("Nova SS", "");
?>
<div class="row">
  <div class="col-lg-12"><h3 class="page-header">Nova SS</h3></div>
</div>

<div class="row">
  <div class="col-lg-12">
    <?php echo $this->BootstrapForm->create('Ss'); ?>
    <div class="col-lg-6">
      <?php
        echo $this->BootstrapForm->input('clarity_url', array(
                   'label' => array('text' => 'URL do Clarity: '),
                   'type' => 'text',
                   'onblur' =>"getID('SsClarity');")); ?>

         <div class="form-group">
           <label for="SsClarityId" class="control-label col-lg-3">Clarity ID: </label>
           <div class="col-lg-9">
              <div class='input-group'>
                <input name="data[Ss][clarity_id]" style="background-color: #EEEEEE;" class="form-control" type="text" id="SsClarityId">
                <span class='input-group-addon'><a id='viewClarity' data-toggle='modal' data-target='#myModal'></a></span>
              </div>
           </div>
        </div>

        <?php
          echo $this->BootstrapForm->input('clarity_dm_id', array(
                      'label' => array('text' => 'Clarity DM: '),
                      'type' => 'text'));

          echo $this->BootstrapForm->input('nome', array(
                      'label' => array('text' => 'Nome: ')));

          echo $this->BootstrapForm->input('numero', array(
                      'label' => array('text' => 'Número: ')));

          echo $this->BootstrapForm->input('ano', array(
                     'label' => array('text' => 'Ano: '),
                     'type' => 'text',
                     'id' => 'dpdecade',
                     'value' => date('Y')));

          echo $this->BootstrapForm->input('responsavel', array(
                      'label' => array('text' => 'Responsável: '),
                      'value' => $this->Ldap->nomeUsuario()));

          echo $this->BootstrapForm->input('servico_id', array(
                      'label' => array('text' => 'Serviço: '),
                      'empty'=>'Serviço'));

          echo $this->BootstrapForm->input('cvs_url', array(
                      'label' => array('text' => 'Url: ')));

          echo $this->BootstrapForm->input('observacao', array(
                      'label' => array('text' => 'Observação: '),
                      'type' => 'textarea'));
        ?>
      </div>
      <div class="col-lg-6">
        <?php
          echo $this->BootstrapForm->input('status_id', array(
                   'label' => array('text' => 'Status: ')));

          echo $this->BootstrapForm->input('prioridade', array(
                     'label' => array('text' => 'Prioridade: ')));

          echo $this->BootstrapForm->input('dt_recebimento', array(
                      'label' => array('text' => 'Data de Recebimento da SS: '),
                      'type' => 'text',
                      'id' => 'dp '));

          /*echo $this->BootstrapForm->input('dt_prevista', array(
                      'label' => array('text' => 'Prazo de entrega pela UD: '),
                      'type' => 'text',
                      'id' => 'dp '));*/

          echo $this->BootstrapForm->input('dt_prazo', array(
                      'label' => array('text' => 'Prazo final contratual: '),
                      'type' => 'text',
                      'id' => 'dp '));
      ?>
      <div id="demandaList"></div>

      <?php echo $this->BootstrapForm->input('dv', array(
                 'label' => array('text' => 'Documento de Visão (Link): ')));

         echo $this->BootstrapForm->input('contagem', array(
                 'label' => array('text' => 'Contagem: (Link):')));
      ?>
    </div>
  </div>
  <div class="form-footer col-lg-12 col-md-6 pull-right">
    <?php
      echo $this->BootstrapForm->submit('Salvar');
      echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-lg-3 col-md-6'));
      echo $this->Form->end();
    ?>
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
  /* Lista de Demandas */
    function getDemandas(servico){
      $.ajax({
        url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "demandas/optionlist?controller=Ss&servico=" + servico,
        cache: false,
        success: function(html){
          $("#demandaList").html(html);
        }
      })
    }

  $(document).ready(function() {
    $('#myModal').on('shown.bs.modal', function (e) {
      document.getElementById('modal-body').appendChild(
          document.getElementById('demandaFrame')
      );
      document.getElementById('demandaFrame').style.display = "block";
      //document.getElementById('demandaFrame').style.height = "720px";
    });


    $("[id*='dpdecade']").datetimepicker({
      format: "yyyy",
        startView: "decade",
        minView: "decade",
        maxView: "decade",
        viewSelect: "decade",
        autoclose: true,
        language: 'pt-BR'
    });

    $("[id*='dp']").datetimepicker({
      format: "dd/mm/yyyy",
        minView: 2,
        autoclose: true,
        todayBtn: true,
        language: 'pt-BR'
    });

    // Quando selecionado o Servico
    $( "select#SsServicoId" ).change(function () {
      var str = "";
      $( "select#SsServicoId option:selected" ).each(function() {
         getDemandas($(this).val()); //passa o valor do item do select selecionado
      })
    }).change();
  });
</script>

<?php
  //-- ClarityID
  echo $this->Html->script('getIdClarity.js');

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

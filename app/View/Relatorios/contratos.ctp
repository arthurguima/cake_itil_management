<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Contrato
      </h3>
    </div>
  <div class="col-lg-12 pull-left filters">
    <div class="">
      <div class="row"><span class="filter-show col-lg-2" style="cursor:pointer;" onclick="javascript:$('.filters > div > .inner').toggle();">Filtros <i class="fa fa-plus-square"></i></span></div>
      <div class="row inner">
        <?php  echo $this->BootstrapForm->create(false, array('class' => 'form-inline')); ?>
        <div class="col-lg-12 filters-item">
          <div class="form-group" style="float:left;">
            <?php echo $this->BootstrapForm->input('contrato_id', array(
                              'label' => array('text' => 'Contrato: '),
                              'class' => "form-control pull-right")); ?>
          </div>
          <div id="aditivoList" style="float:left;"></div>
          <!--div id="itemList"></div-->
        </div>
        <?php
          echo $this->BootstrapForm->button("Filtrar <i class='fa fa-search'></i>", array('type' => 'submit', 'class' => 'control-label btn btn-default pull-right'));
          echo $this->BootstrapForm->end();
        ?>
      </div>
    </div>
  </div>
</div>

<?php if($this->request->data != null): ?>
  <?php $totaltime = 0; ?>
  <div class="row">
    <div class="col-lg-3">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <p>
            <h3 class="panel-title">Informações</h3>
          </p>
        </div>
        <div class="panel-body">
          <ul class="nav nav-pills nav-stacked">
            <li><a><b>Numero: </b><?php debug($pes);//echo $contrato['numero']; ?></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<script>
  /* Lista de Itens
  function getItens(tipo, id){
    $.ajax({
      url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "items/optionlist?controller=relatorios&tipo=" + tipo + "&id=" + id,
      cache: false,
      success: function(html){
        $("#itemList").html(html);
      }
    })
  }*/

/* Lista de Aditivos */
  function getAditivos(contrato){
    $.ajax({
      url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "aditivos/optionlist?controller=relatorios&contrato=" + contrato,
      cache: false,
      success: function(html){
        $("#aditivoList").html(html);
      }
    });
  }

  $(document).ready(function() {
    // Quando selecionado o Contrato
    $( "select#contrato_id" ).change(function () {
      var str = "";
      $( "select#contrato_id option:selected" ).each(function() {
         //getItens("Contrato", $(this).val());
         getAditivos($(this).val());
      })
    }).change();

    /* Quando selecionado o Aditivo
    $(document).on('change', $("select#AditivoAditivo"), function () {
      var str = "";
      $("select#AditivoAditivo option:selected").each(function() {
         if($(this).val() != "Aditivo"){
          getItens("Aditivo", $(this).val());
         }
      })
    });*/
  });
</script>


<?php
  // Circliful
  echo $this->Html->script('plugins/circliful/js/jquery.circliful.js');
  echo $this->Html->css('plugins/jquery.circliful.css');

  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
?>

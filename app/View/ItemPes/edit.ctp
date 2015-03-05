<?php
  $this->Html->addCrumb('PA', '');
  $this->Html->addCrumb('Itens de contrato da PA', '');
  $this->Html->addCrumb($this->data['ItemPe']['id'], array('controller' => 'itempes', 'action' => 'edit', $this->data['ItemPe']['id']));
?>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header">
      Editar Item de Contrato da PA
    </h3>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <?php
      echo $this->BootstrapForm->create('ItemPe');

      echo $this->BootstrapForm->input('id');

      echo $this->BootstrapForm->input('contrato', array(
              'label' => array('text' => 'Contrato: '),
              'input' => 'text',
              'options' => $contratos));
      ?>
    <div id="aditivoList"></div>
    <div id="itemList"></div>
    <?php echo $this->BootstrapForm->input('volume', array('label' => array('text' => 'Volume Utilizado: '))); ?>

    <div class="form-footer col-lg-10 col-md-6 pull-right">
      <?php
        echo $this->BootstrapForm->submit('Salvar');
        echo $this->Html->link('Voltar', 'javascript:history.back(1);', array('class' => 'btn btn-danger pull-right col-lg-3 col-md-6'));
        echo $this->Form->end();
      ?>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="well col-lg-9 error-message">
      <?php
        $str =  "Atual: Contrato -> " . $this->data['Contrato']['numero'];
        if(isset($this->data['Aditivo']['dt_inicio'])){
            $str = $str . "; Aditivo -> " . date('d/m/Y', strtotime($this->data['Aditivo']['dt_inicio']));
        }
        else{   $str = $str . "; Aditivo -> *** ";}
        $str = $str ."; Item -> " . $this->data['Item']['nome'];
        echo $str;
      ?>
    </div>
  </div>
</div>

<script>
  /* Lista de Itens */
    function getItens(tipo, id, contrato){
      $.ajax({
        url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "items/optionlist?controller=ItemPe&tipo=" + tipo + "&id=" + id,
        cache: false,
        success: function(html){
          $("#itemList").html(html);
        }
      })
    }

  /* Lista de Aditivos */
    function getAditivos(contrato){
      $.ajax({
        url: <?php echo "'" . Router::url('/', true) . "'"; ?> + "aditivos/optionlist?controller=ItemPe&contrato=" + contrato,
        cache: false,
        success: function(html){
          $("#aditivoList").html(html);
        }
      });
    }

  // Quando selecionado o Contrato
  $( "select#ItemPeContrato" ).change(function () {
    var str = "";
    $( "select#ItemPeContrato option:selected" ).each(function() {
       getItens("Contrato", $(this).val(), $(this).val());
       getAditivos($(this).val());
    })
  }).change();

  // Quando selecionado o Aditivo
  $(document).on('change', $("select#AditivoAditivo"), function () {
    var str = "";
    $("select#AditivoAditivo option:selected").each(function() {
       if($(this).val() != "Aditivo"){
        getItens("Aditivo", $(this).val());
       }
    })
  });
</script>

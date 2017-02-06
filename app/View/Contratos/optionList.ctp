<div class="form-group">
  <label for="ContratoContrato" class="col-lg-3 control-label">Contrato: </label>
  <div class="col-lg-9">
    <input type="hidden" name="data[Contrato][Contrato]" value="" id="ContratoContrato_">
    <select name="data[Contrato][Contrato][]" seperator="</div>" class="form-control" id="ContratoContrato">
      <option>Contrato</option>
      <?php foreach ($contratos as $con):
        echo "<option value='" . $con['id'] . "'>" . $con['numero'] . "</option>"
      ?>
      <?php endforeach; ?>
    </select>
</div>


<?php
  //-- Select2 --
  echo $this->Html->script('plugins/select2/select2.full.min');
  echo $this->Html->css('plugins/select2.min');
  echo $this->Html->css('plugins/select2-bootstrap.min');
  echo $this->Html->script('plugins/select2/pt-BR');
?>

<script>
  $(document).ready(function() {
    $('#ContratoContrato').select2({
      language: "pt-BR",
      theme: "bootstrap"
    });
  })
</script>

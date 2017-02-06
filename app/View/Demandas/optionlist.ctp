<?php //debug($demandas) ?>
<div class="form-group">
  <label for="DemandaDemanda" class="col-lg-3 control-label">Demanda(s):</label>
  <div class="col-lg-9">
    <input type="hidden" name="data[Demanda][Demanda]" value="" id="DemandaDemanda_">
    <select name="data[Demanda][Demanda][]" seperator="</div>" class="form-control" input="text" multiple="multiple" id="DemandaDemanda">
      <?php foreach ($demandas as $key => $value):
        echo "<option value='" . $key . "'>" . $demandas[$key] . "</option>"
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
    $('#DemandaDemanda').select2({
      language: "pt-BR",
      theme: "bootstrap"
    });
  })
</script>

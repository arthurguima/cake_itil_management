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

<script>
  $(document).ready(function() {
    $('#DemandaDemanda').select2();
  })
</script>

<?php
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2-bootstrap');
?>

<?php //debug($chamados) ?>
<div class="form-group">
  <label for="ChamadoChamado" class="col-lg-3 control-label">Chamado(s):</label>
  <div class="col-lg-9">
    <input type="hidden" name="data[Chamado][Chamado]" value="" id="ChamadoChamado_">
    <select name="data[Chamado][Chamado][]" seperator="</div>" class="form-control" input="text" multiple="multiple" id="ChamadoChamado">
      <?php foreach ($chamados as $key => $value):
        echo "<option value='" . $key . "'>" . $chamados[$key] . "</option>"
      ?>
      <?php endforeach; ?>
    </select>
</div>

<script>
  $(document).ready(function() {
    $('#ChamadoChamado').select2();
  })
</script>

<?php
  echo $this->Html->script('plugins/select2/select2.min');
  echo $this->Html->css('plugins/select2');
  echo $this->Html->script('plugins/select2/select2_locale_pt-BR');
  echo $this->Html->css('plugins/select2-bootstrap');
?>

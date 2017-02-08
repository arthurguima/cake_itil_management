<div class="form-group">
  <label for="ChamadoChamadoTipoId" class="col-lg-3 control-label">Tipo de Chamado:</label>
  <div class="col-lg-9">
    <select name="data[Chamado][chamado_tipo_id]" seperator="</div>" class="form-control" id="ChamadoChamadoTipoId">
      <option value>Tipo de Chamado</option>
      <?php foreach ($chamadotipos as $key => $value):
        if($this->request['url']['tipo'] == $key)
          echo "<option selected value='" . $key . "'>" . $chamadotipos[$key] . "</option>";
        else
          echo "<option value='" . $key . "'>" . $chamadotipos[$key] . "</option>";
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
    $('#ChamadoChamadoTipoId').select2({
      language: "pt-BR",
      theme: "bootstrap",
      placeholder: "Tipo de Chamado",
    });
  })
</script>

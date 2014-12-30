<div class="form-group">
  <label for="ChamadoChamadoTipoId" class="col-lg-3 control-label">Tipo de Chamado:</label>
  <div class="col-lg-9">
    <select name="data[Chamado][chamado_tipo_id]" seperator="</div>" class="form-control" id="ChamadoChamadoTipoId">
      <option>Tipo de Chamado</option>
      <?php foreach ($chamadotipos as $key => $value):
        echo "<option value='" . $key . "'>" . $chamadotipos[$key] . "</option>"
      ?>
      <?php endforeach; ?>
    </select>
</div>

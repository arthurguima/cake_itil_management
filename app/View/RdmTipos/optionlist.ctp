<div class="form-group">
  <label for="RdmRdmTipoId" class="col-lg-3 control-label">Tipo RDM:</label>
  <div class="col-lg-9">
    <select name="data[Rdm][rdm_tipo_id]" seperator="</div>" class="form-control" id="RdmRdmTipoId">
      <option>Tipo RDM</option>
      <?php foreach ($rdmtipos as $key => $value):
        echo "<option value='" . $key . "'>" . $rdmtipos[$key] . "</option>"
      ?>
      <?php endforeach; ?>
    </select>
</div>

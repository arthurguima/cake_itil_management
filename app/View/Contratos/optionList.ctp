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

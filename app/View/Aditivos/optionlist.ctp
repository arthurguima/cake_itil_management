<div class="form-group">
  <label for="AditivoAditivo" class="col-lg-2 control-label">Aditivo:</label>
  <div class="col-lg-10">
    <input type="hidden" name="data[Aditivo][Aditivo]" value="" id="AditivoAditivo_">
    <select name="data[Aditivo][Aditivo][]" seperator="</div>" class="form-control" id="AditivoAditivo">
      <option>Aditivo</option>
      <?php foreach ($aditivos as $key => $value):
        echo "<option value='" . $key . "'>" . $aditivos[$key] . "</option>"
      ?>
      <?php endforeach; ?>
    </select>
</div>

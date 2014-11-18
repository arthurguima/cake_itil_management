<div class="form-group">
  <label for="ItemItem" class="col-lg-2 control-label">Item:</label>
  <div class="col-lg-10">
    <select name="data[<?php echo $this->params['url']['controller'] ?>][item_id]" seperator="</div>" class="form-control" id="<?php echo $this->params['url']['controller'] ?>ItemId">
      <?php foreach ($items as $key => $value):
        echo "<option value='" . $key . "'>" . $items[$key] . "</option>"
      ?>
      <?php endforeach; ?>
    </select>
</div>

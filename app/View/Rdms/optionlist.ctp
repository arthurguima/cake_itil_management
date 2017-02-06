<?php //debug($rdms) ?>
<div class="form-group">
  <label for="RdmRdm" class="col-lg-3 control-label">Rdm(s):</label>
  <div class="col-lg-9">
    <select name="data[Release][rdm_id]" seperator="</div>" class="form-control" input="text"  id="ReleaseRdmId">
      <?php foreach ($rdms as $key => $value):
        echo "<option value='" . $key . "'>" . $rdms[$key] . "</option>"
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
    $('#RdmRdm').select2({
      language: "pt-BR",
      theme: "bootstrap"
    });
  })
</script>

<div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        Timeline: <?php echo ($ss['Ss']['nome'] . " - " . $ss['Servico']['nome']); ?>
      </h3>
    </div>
  <div class="col-lg-12">
  </div>
</div>

<script>
  $(document).ready(function() {

  });
</script>


<?php
  // Circliful
  echo $this->Html->script('plugins/circliful/js/jquery.circliful.js');
  echo $this->Html->css('plugins/jquery.circliful.css');

  //-- TimePicker --
  echo $this->Html->script('plugins/timepicker/bootstrap-datetimepicker');
  echo $this->Html->css('plugins/bootstrap-datetimepicker.min');
  echo $this->Html->script('plugins/timepicker/locales/bootstrap-datetimepicker.pt-BR');
?>

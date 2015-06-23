<?php
  $containers = 0;
  $lista = "<table id='containers' class='table table-striped table-bordered table-hover'><thead><tr><th>Container</th><th>Resposta</th><th>Container</th><th>Resposta</th></tr></thead><tbody>";

  $counter = 0;
  foreach ($servico['Container'] as $cont):
    $containers += $this->Disponibilidade->container_online($cont['url'], 'GET');
    if($counter%2 == 0){
      $lista = $lista . "<tr><td>". $cont['nome'] ."</td>". $this->Disponibilidade->online($cont['url'], 'GET');
    }
    else{
      $lista = $lista . "<td>". $cont['nome'] ."</td>". $this->Disponibilidade->online($cont['url'], 'GET') ."</tr>";
    }
    $counter++;
  endforeach; unset($cont);

  $lista = $lista . "</tbody></table>";
  $color = "";
  if($containers < sizeof($servico['Container']))
    $color = 'red';

  echo '<div data-toggle="popover-' . $servico['Servico']['sigla'] . '" title=' ."'<b>". $servico['Servico']['sigla'] ."</b>'". ' data-content="' . $lista . '" data-html="true">
          <span class="' . $color . '">' . $containers . '</span>/' . sizeof($servico['Container']) .
       '</div>';
?>

<script>
$(document).ready(function() {
  <?php if(!isset($this->params['url']['position'])): ?>
    $('[data-toggle="popover-<?php echo $servico['Servico']['sigla']; ?>"]').popover({trigger: 'hover','placement': 'left', html: 'true'});
  <?php else: ?>
    <?php if(!isset($this->params['url']['trigger'])): ?>
      $('[data-toggle="popover<?php echo $servico['Servico']['sigla']; ?>"]').popover({trigger: 'hover','placement': '<?php echo $this->params['url']['position']?>', html: 'true'});
    <?php else: ?>
      $('[data-toggle="popover-<?php echo $servico['Servico']['sigla']; ?>"]').popover({trigger: '<?php echo $this->params['url']['trigger']?>','placement': '<?php echo $this->params['url']['position']?>', html: 'true'});
    <?php endif;?>
  <?php endif;?>
});
</script>

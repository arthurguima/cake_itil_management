<?php
  $containers = 0;
  $lista = "<table class='table table-striped table-bordered table-hover'><thead><tr><th>Container</th><th>Resposta</th></tr></thead><tbody>";
  foreach ($servico['Container'] as $cont):
    $containers += $this->Disponibilidade->container_online($cont['url'], 'GET');
    $lista = $lista . "<tr><td>". $cont['nome'] ."</td>". $this->Disponibilidade->online($cont['url'], 'GET') ."</tr>";
  endforeach; unset($cont);

  $lista = $lista . "</tbody></table>";
  $color = "";
  if($containers < sizeof($servico['Container']))
    $color = 'red';

  echo '<span data-toggle="popover" title=' ."'<b>". $servico['Servico']['sigla'] ."</b>'". ' data-content="' . $lista . '" data-html="true">
          <span class="' . $color . '">' . $containers . '</span>/' . sizeof($servico['Container']) .
       '</span>';
?>

<script>
$(document).ready(function() {
  $('[data-toggle="popover"]').popover({trigger: 'hover','placement': 'left', html: 'true'});
});
</script>

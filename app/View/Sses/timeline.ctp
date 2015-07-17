<?php
  /* CSS */
  //-- Bootstrap Core CSS --
  echo $this->Html->css('bootstrap.min.css');
  //-- MetisMenu CSS --
  echo $this->Html->css('plugins/metisMenu/metisMenu.min.css');
  //-- Custom Fonts
  echo $this->Html->css('font-awesome-4.2.0/css/font-awesome.min.css');
  //-- Custom admin CSS --
  echo $this->Html->css('sb-admin-2.css');
?>
<style media="screen">
    body{
      background-color: #fff;
    }
</style>

<div style="padding: 25px 15px; border-left: 1px solid #e7e7e7;">
  <div class="row" style>
      <div class="col-lg-12">
        <h3 class="page-header">
          Timeline da SS: <?php echo ($ss['Ss']['nome'] . " - " . $ss['Servico']['nome']); ?>
        </h3>
      </div>
    <div class="col-lg-12">
      <br/><br/>
      <div id="visualization"></div>
    </div>
  </div>
</div>

<?php
  /* JS */
  //-- jQuery Version 1.11.0 --
  echo $this->Html->script('jquery-1.11.0.js');
  //-- Bootstrap Core JavaScript --
  echo $this->Html->script('bootstrap.min.js');
  // Vis
  echo $this->Html->script('plugins/vis/moment-with-locales.min.js');
  echo $this->Html->script('plugins/vis/vis.min.js');
  echo $this->Html->css('plugins/vis.min.css');
?>

<script>
  var container = document.getElementById('visualization');

  // Dados para o preenchimento da Timeline
  var items = new vis.DataSet(<?php  echo $this->Ss->timelineItens($ss); ?>);

  // Configurações da Timeline
  var options = {
    height: '70%',
    locales: {
      pt: {
        current: 'courant',
        time: 'temps',
      }
    },
    locale: 'pt'
  };

  var groups = new vis.DataSet([
   {id: 0, content: 'SS', value: 1},
   {id: 1, content: 'PA', value: 2},
   {id: 2, content: 'OS', value: 3},
   {id: 3, content: 'Demandas Internas', value: 4}
  ]);

  // Cria a Timeline
  var timeline = new vis.Timeline(container, items, options);
  timeline.setGroups(groups);
  timeline.fit();

  $( document ).ready(function() {
    setTimeout(function(){
      $('[data-toggle="popover"]').popover({trigger: 'click','placement': 'right', html: 'true'});
    }, 1500);
	});
</script>

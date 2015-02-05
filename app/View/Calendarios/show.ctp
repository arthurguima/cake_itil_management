<div class="row">
    <div class="col-lg-12"><h3 class="page-header">Calendário de Previsões de Término</h3></div>
</div>

<div class="row">
  <div id='calendar' class="col-lg-12"></div>
</div>


<?php
 // FullCalendar
 echo $this->Html->script('plugins/fullcalendar/lib/moment.min.js');
 echo $this->Html->script('plugins/fullcalendar/fullcalendar.min.js');
 echo $this->Html->script('plugins/fullcalendar/lang/pt-br.js');

 echo $this->Html->css('plugins/fullcalendar/fullcalendar.min.css');
?>

<script>
  $(document).ready(function() {
    $('#calendar').fullCalendar({
      header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
      events: {
        url: 'json',
        //color: '#DEDEDE',   // an option!
        //textColor: 'black' // an option!
      },
      eventRender: function(event, element) {
        if(event.description != null)
          element.find('.fc-title').append("<br/>" + event.description);
      }
    })
  });
</script>

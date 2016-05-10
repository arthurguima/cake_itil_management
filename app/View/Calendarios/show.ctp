<?php
  $this->Html->addCrumb("Calendário", '/calendarios/show');
?>

<div class="row">
    <div class="col-lg-12"><h3 class="page-header"><i class="fa fa-calendar fa-fw"></i> Calendário </h3></div>
</div>

<div class="row">
  <div id='calendar' class="col-lg-12"></div>
</div>

<?//php debug($_SESSION) ?>

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

      views: {
        month: {
            eventLimit: 7 // adjust to 6 only for agendaWeek/agendaDay
        }
      },

      events: {
        url: "<?php echo Router::url('/', true). 'calendarios/json/' . $this->request->params['pass'][0]; ?>",
        //color: '#DEDEDE',   // an option!
        //textColor: 'black' // an option!
        //As cores estão vindo dos métodos que geram os arrays para cada Model
      },

      eventRender: function(event, element) {
        if(event.description != null)
          element.find('.fc-title').append("<br/>" + event.description);
      },

      dayClick: function(date, allDay, jsEvent, view) {
        $('#calendar').fullCalendar('gotoDate', date);
        $('#calendar').fullCalendar('changeView', 'basicDay');
      }

    })
  });
</script>

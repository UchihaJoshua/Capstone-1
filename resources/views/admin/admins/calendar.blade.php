<x-adminlayout>
    <div class="container">
        <h1 class="title">All Scheduled Subjects for the Week</h1>
        <div id="calendar"></div>
    </div>

    <!-- FullCalendar CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.11.0/main.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.11.0/main.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@5.11.0/main.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@5.11.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.11.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@5.11.0/main.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var schoolYear = @json($schoolYear);
            var startYear = schoolYear.split('-')[0];

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                initialDate: startYear + '-08-01',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek'
                },
                events: @json($events),
                editable: false,
                droppable: false,
                allDaySlot: false,
                nowIndicator: true,
                timeZone: 'local',
                height: 'auto',
                slotMinTime: '07:00:00',
                slotMaxTime: '19:00:00',
            });

            calendar.render();
        });
    </script>

    <style>
        #calendar {
            max-width: 1100px;
            margin: 0 auto;
        }
        .title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</x-adminlayout>

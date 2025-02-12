@extends('frontend.layout.main')

@section('container')

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
<style>
    #calendar > div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr > div:nth-child(1) > button{
        text-transform: capitalize;
    }
    #calendar > div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr > div:nth-child(3) > div > button.fc-timeGridDay-button.fc-button.fc-button-primary{
        text-transform: capitalize;
    }

    #calendar > div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr > div:nth-child(3) > div > button.fc-timeGridWeek-button.fc-button.fc-button-primary{
        text-transform: capitalize;
    }
    #calendar > div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr > div:nth-child(3) > div > button.fc-timeGridWeek-button.fc-button.fc-button-primary{
        text-transform: capitalize;
    }
    #calendar > div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr > div:nth-child(3) > div > button.fc-dayGridMonth-button.fc-button.fc-button-primary.fc-button-active{
        text-transform: capitalize;  
    }
</style>
    {{-- ======================================
                    DASHBOARD
    ======================================= --}}
    <div id="document">
        <div class="container-fluid">
            <div class="dashboard-container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="document-left-block">
                            <div class="inner-block table-block">

                            <div id="calendar"></div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var calendarEl = document.getElementById('calendar');
    
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Show monthly view
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($due_dates), // Pass your events as JSON
            });
    
            calendar.render();
        })
    </script>
    
@endsection

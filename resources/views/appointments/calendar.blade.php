@extends('adminlte::page')

@section('css')
    <style>
        .date.morning {
            width: 10px;
            height: 10px;
            top: 37px;
            content: " ";
            display: block;
            background: #6ED0F6;
            margin-left: 46%;
        }

        .date.afternoon {
            width: 10px;
            height: 10px;
            border-radius: 100%;
            top: 37px;
            content: " ";
            display: block;
            background: #F49AC1;
            margin-left: 46%;
        }

        .date.evening {
            width: 10px;
            height: 10px;
            top: 37px;
            content: " ";
            display: block;
            background: #F2DB4E;
            margin-left: 46%;
        }

        .eventBody {
            width: 100%;
            position: absolute;
            left: 0;
            bottom: -8px;
        }

        .event {
            width: 3px;
            height: 3px;
            border-radius: 150px;
            display: inline-block;
            background: #6ED0F6;
            margin: 0 2px;
        }

        .event.afternoon {
            background: #F49AC1;
        }

        .event.evening {
            background: #F2DB4E;
        }

        button.btn.btn-success {
            margin: 5px 0;
        }

        .flatpickr-calendar {
            width: 100% !important;
        }

        .date-picker {
            pointer-events: none;
            opacity: 0.5;
        }

        button.btn.btn-success.active {
            background-color: white;
            color: green;
        }

        .fc-view-container {
            overflow-x: scroll;
        }
        .flatpickr-calendar.animate.open {
            top: 277px;
            left: 668px;
            right: auto;
            width: 16% !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href='https://unpkg.com/@fullcalendar/timeline@4.4.2/main.min.css' rel='stylesheet' />
    <link href='https://unpkg.com/@fullcalendar/resource-timeline@4.4.2/main.min.css' rel='stylesheet' />
@stop

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.js"></script>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-4">
                    <button class="btn btn-sm btn-success" onclick="goBack()" style="margin-left: 3%;"><i
                            class="fa fa-arrow-left"></i> Back
                    </button>
                    <a href="{{route('appointments.index')}}" class="btn btn-sm btn-info"><i class="fa fa-list"></i>
                        Full List View</a>
                </div>
                <div class="col-md-4">
                    <strong>Appointments (Calendar)</strong>
                </div>
                <div class="col-md-4">

                    @if(auth()->user()->role_id == 5)
                        @if(\App\Service::all()->count() > 0)
                            <button data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-success btn-block">
                                <i class="fa fa-calendar-plus-o"></i> Create New Appontment
                            </button>
                        @else
                            There are no services available <a href="#">Contact Admin.</a>
                        @endif
                    @else
                        <button data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-success btn-block">
                            <i class="fa fa-calendar-plus-o"></i> Create New Appontment
                        </button>
                    @endif

                </div>
            </div>
            <br>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs nav-tabs-success">
                    <li class="active"><a href="#default-calendar" data-toggle="tab">Default Calendar</a></li>
                    <li id="timeline-calendar-link"><a href="#timeline-calendar" data-toggle="tab">Timeline Calendar</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="default-calendar">
                        <div class="box box-success" id="calendar"></div>
                    </div>

                    <div class="tab-pane" id="timeline-calendar">
                        <div class="box box-success" id="calendar-timeline"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Appointment --}}
    <div class="modal fade" id="myModal" role="dialog">
        @include('inc.appointments.create_appointment_calendar.create')
    </div>

    {{-- Create Patient on the appointment --}}
    <div class="modal fade" id="addNewPatient" role="dialog">
        @include('inc.appointments.create_user.create_user_ajax')
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src='https://unpkg.com/@fullcalendar/core@4.4.2/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/timeline@4.4.2/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/resource-common@4.4.2/main.min.js'></script>
    <script src='https://unpkg.com/@fullcalendar/resource-timeline@4.4.2/main.min.js'></script>
     <script>
        let Result = null;
        let fp = null;
        let events = {!! $events !!};
        let resources = {!! $resources !!};
        let now = new Date();
        now = (now.getHours() === 0 ? now.getHours() : now.getHours() - 1) + ':00:00';

        // Get availableDateTime for current doctor & month, year
            function getAvailableDateTime(month, year, days) {
            $.ajax({
                type: 'get',
                url: 'timings',
                data: {
                    'service_id': $('#service_id option:selected').val(),
                    'doctor_id': $('#doctor_id option:selected').val(),
                    'month': month,
                    'year': year,
                    'days': days,
                    'timeZone': Intl.DateTimeFormat().resolvedOptions().timeZone,
                },
                success: function (data) {
                    initializeFlatpickr(data);
                }
            });
        }

        // Get availableDateTime for changed doctor
        function createNewFlatpickr() {
            $('#appointmentFromTime').val('');

            // Clear timing
            $('#morning').replaceWith('<td colspan="3" id="morning"><div class="text-info">Please choose a date</div></td>');
            $('#afternoon').html('');
            $('#evening').html('');

            // Destroy previous flatpickr instance
            if (fp){
                fp.destroy();
            }

            let date = new Date();
            getAvailableDateTime(date.getMonth() + 1, date.getFullYear(), new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate());
        }

        // Create a new instance of flatpkr
        function initializeFlatpickr(data) {
            Result = data;
            let disabledDates = [];

            fp = flatpickr("#appointment_date", {
                inline: true,
                minDate: 'today',
                altInput: true,
                allowInput: true,
                altFormat: 'd F, Y',
                onDayCreate: function (dObj, dStr, fp, dayElem) {
                    if (formatDate($(dayElem).attr("aria-label")) in Result) {
                        var eventBody = "<span class='eventBody'>";
                        if (Result[formatDate($(dayElem).attr("aria-label"))]['morning'].length > 0) {
                            eventBody += "<span class='event'></span>";
                        }

                        if (Result[formatDate($(dayElem).attr("aria-label"))]['afternoon'].length > 0) {
                            eventBody += "<span class='event afternoon'></span>";
                        }

                        if (Result[formatDate($(dayElem).attr("aria-label"))]['evening'].length > 0) {
                            eventBody += "<span class='event evening'></span>";
                        }

                        eventBody += "</span>";
                        dayElem.innerHTML += eventBody;
                    } else {
                        disabledDates.push(formatDate($(dayElem).attr("aria-label")));
                    }
                },
                onMonthChange: function (selectedDates, dateStr, instance) {
                    disabledDates = [];
                    $('.date-picker').css({"pointer-events": "none", "opacity": "0.5"});
                    $('#morning').replaceWith('<td colspan="3" id="morning"><div class="text-info">Please choose a date</div></td>');
                    $('#afternoon').html('');
                    $('#evening').html('');


                    let date = new Date(instance.currentYear, instance.currentMonth);

                    $.ajax({
                        type: 'get',
                        url: 'timings',
                        data: {
                            'service_id': $('#service_id option:selected').val(),
                            'doctor_id': $('#doctor_id option:selected').val(),
                            'month': date.getMonth() + 1,
                            'year': date.getFullYear(),
                            'days': new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate(),
                            'timeZone': Intl.DateTimeFormat().resolvedOptions().timeZone,
                        },
                        success: function (response) {
                            Result = response;

                            instance.redraw();
                            fp.set('disable', disabledDates);
                            $('.date-picker').css({"pointer-events": "all", "opacity": "1"});
                        }
                    });
                },
                onYearChange: function (selectedDates, dateStr, instance) {
                    disabledDates = [];
                    $('.date-picker').css({"pointer-events": "none", "opacity": "0.5"});
                    $('#morning').replaceWith('<td colspan="3" id="morning"><div class="text-info">Please choose a date</div></td>');
                    $('#afternoon').html('');
                    $('#evening').html('');


                    let date = new Date(instance.currentYear, instance.currentMonth);

                    $.ajax({
                        type: 'get',
                        url: 'timings',
                        data: {
                            'service_id': $('#service_id option:selected').val(),
                            'doctor_id': $('#doctor_id option:selected').val(),
                            'month': date.getMonth() + 1,
                            'year': date.getFullYear(),
                            'days': new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate(),
                            'timeZone': Intl.DateTimeFormat().resolvedOptions().timeZone,
                        },
                        success: function (response) {
                            Result = response;

                            instance.redraw();
                            fp.set('disable', disabledDates);
                            $('.date-picker').css({"pointer-events": "all", "opacity": "1"});
                        }
                    });
                },
                onChange: function (selectedDates, dateStr, instance) {
                    $('.box-title').text(dateStr);

                    if (dateStr in Result) {
                        let [morning, afternoon, evening] = Array(3).fill('');

                        Result[dateStr]['morning'].forEach(function (value, index, array) {
                            morning += '<button type="button" class="btn btn-success" onclick="setFrom(this)">' + value + '</button><br>';
                        });
                        Result[dateStr]['afternoon'].forEach(function (value, index, array) {
                            afternoon += '<button type="button" class="btn btn-success" onclick="setFrom(this)">' + value + '</button><br>';
                        });
                        Result[dateStr]['evening'].forEach(function (value, index, array) {
                            evening += '<button type="button" class="btn btn-success" onclick="setFrom(this)">' + value + '</button><br>';
                        });

                        $('#morning').replaceWith('<td id="morning">' + morning + ' </td>');
                        $('#afternoon').html(afternoon);
                        $('#evening').html(evening);
                    } else {
                        $('#morning').replaceWith('<td colspan="3" id="morning"><div class="text-danger">Doctor not available on selected date!</div></td>');
                        $('#afternoon').html('');
                        $('#evening').html('');
                    }
                },
            });

            fp.set('disable', disabledDates);
            $('.date-picker').css({"pointer-events": "all", "opacity": "1"});
        }

        // Set from
        function setFrom(_this) {
            $('#appointmentFromTime').val($(_this).text());

            // remove classes from all
            $("button").removeClass("active");
            // add class to the one we clicked
            $(_this).addClass("active");
        }

        // Format date
        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }

        // Get doctor by service
        function getDoctor() {
            // Clear timing
            $('#morning').replaceWith('<td colspan="3" id="morning"><div class="text-info">Please choose a date</div></td>');
            $('#afternoon').html('');
            $('#evening').html('');

            // Destroy previous flatpckr instance if exists
            if (fp) {
                fp.destroy();
            }

            // Make ajax call to get doctor by service
            $.ajax({
                type: 'get',
                url: 'doctor-by-service/' + $('#service_id').val(),
                success: function (response) {
                    $('#doctor_id').html('');
                    $('#doctor_id').append('<option selected disabled>Select doctor</option>');

                    if (jQuery.isEmptyObject(response)) {
                        alert('No doctor found for this service!');
                    } else {
                        for (var key in response) {
                            $('#doctor_id').append('<option value="' + response[key].id + '">' + response[key].firstname + ' ' + response[key].lastname + '</option>');
                        }
                    }
                }
            });
        }

        function addEvent(date) {
            console.log(date._d);
            $('#myModal').modal('show');
        }

        // calender timeline
        document.getElementById('timeline-calendar-link').addEventListener('click', function () {
            setTimeout(function() {
                $('.fc-resourceTimelineDay-button').click();
            }, 1);
        });

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar-timeline');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                plugins: [ 'resourceTimeline' ],
                header: {
                    left: 'today prev,next',
                    center: 'title',
                    right: 'resourceTimelineDay,resourceTimelineWeek'
                },
                aspectRatio: 1.6,
                defaultView: 'resourceTimelineWeek',
                resourceGroupField: 'room',
                events: events,
                slotDuration: '00:05:00',
                slotLabelInterval: 5,
                slotMinutes: 5,
                scrollTime: now,
                resources: resources
            });

            calendar.render();
        });

        // calender
        document.addEventListener('DOMContentLoaded', function () {
            let myCalendar = $('#calendar');
            let calendarEl = document.getElementById('calendar');

            const handleHorizontalScrollbar = ((myCalendar) => {

                const minColumnWidthInPixels = 180; // up to you

                const getContainerWidth = () => myCalendar.parent().outerWidth();

                const getAgendaWidthInPercent = () => {
                    const containerWidthInPixels = getContainerWidth();
                    const numberOfColumns = calendar.getTopLevelResources().length;
                    const firstColumnWidthInPixels = myCalendar.find(".fc-axis.fc-widget-header").outerWidth();
                    const expectedTotalWidthInPixels = minColumnWidthInPixels * numberOfColumns
                        + firstColumnWidthInPixels
                        + numberOfColumns;
                    const agendaWidthInPercent = expectedTotalWidthInPixels / containerWidthInPixels * 100;
                    return Math.max(agendaWidthInPercent, 100); // should not be less than 100% anyway
                }

                return (calendar) => {
                    calendar.el.style.width = getAgendaWidthInPercent() + "%";
                };

            })(myCalendar);

            let calendar = new FullCalendar.Calendar(calendarEl, {
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                datesRender: handleHorizontalScrollbar,
                windowResize: handleHorizontalScrollbar,
                plugins: ['interaction', 'dayGrid', 'resourceTimeGrid', 'list', 'resourceTimeline'],
                defaultView: 'resourceTimeGridDay',
                aspectRatio: 3,
                slotDuration: '00:10:00',
                slotLabelInterval: 10,
                slotMinutes: 10,
                scrollTime: now,
                height: window.innerHeight * .7,
                nowIndicator: true,
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                header: {
                    left: 'prevYear,prev,next,nextYear today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,resourceTimeGridDay,listMonth,listWeek,listDay'
                },
                views: {
                    resourceTimeGridDay: {
                        type: 'resourceTimeGrid',
                        duration: {days: 1}
                    },
                    listMonth: {
                        buttonText: 'list month'
                    },
                    listWeek: {
                        buttonText: 'list week'
                    },
                    listDay: {
                        buttonText: 'list day'
                    },
                },
                resources: resources,
                events: events,
                dateClick: function (info) {
                    $('#myModal').modal('show');
                },
                resourceRender: function(renderInfo) {
                    renderInfo.el.style.color = 'white';
                    renderInfo.el.style.backgroundColor = `rgb(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}`;
                }
            });

            calendar.render();
        });

        $('#appoi_user').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action')+'2',
                data: $(this).serialize(),
                success: function(response) {
                    $('#user_id').html(response);
                    $('#appoi_user').trigger("reset");
                    $('#addNewPatient').modal('hide');
                }
            });
        });

    </script>
@stop

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

        span.select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        .title {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@stop

@section('content')
    <div class="panel panel-success no-print">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-4">
                    <button onclick="goBack()" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i> Back</button>
                </div>
                <div class="col-md-4">
                    <strong>{{$patient->firstname}} {{$patient->lastname}}</strong>
                </div>
                <div class="col-md-2">
                    <a href="{{route('patients.edit', $patient->id)}}" class="btn btn-sm btn-primary btn-block"><i class="fa fa-pencil"></i> Edit Client</a>
                </div>
                <div class="col-md-2">
                    <a href="javascript:print()" class="btn btn-sm btn-info btn-block"><i class="fa fa-print"></i> Print</a>
                </div>
            </div>
        </div>
    </div>

    <div id="app">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                <div class="box box-success">
                    <div class="box-body box-profile">
                        @if($patient->profile_photo)
                            <img class="profile-user-img img-responsive img-circle" src="{{asset('/storage/'.$patient->profile_photo)}}"
                                 alt="{{$patient->firstname}} {{$patient->lastname}}'s' profile picture">
                        @else
                            <img class="profile-user-img img-responsive img-circle" src="{{asset('img/user.png')}}"
                                 alt="{{$patient->firstname}} {{$patient->lastname}}'s' profile picture">
                        @endif

                        <h3 class="profile-username text-center">{{ucwords($patient->title)}} {{$patient->firstname}} {{$patient->lastname}}</h3>

                        <p class="text-muted text-center">{{$patient->occupation}}</p>

                        <ul class="list-group list-group-unbordered">

                            <li class="list-group-item"><strong>Username : </strong><a>{{$patient->username}}</a></li>
                            <li class="list-group-item"><strong>NHS Number : </strong><a>{{$patient->nhs_number}}</a></li>
                            <li class="list-group-item"><strong>Date of Birth : </strong><a>{{\Carbon\Carbon::parse($patient->date_of_birth)->format('D jS, M, Y')}}</a></li>
                            <li class="list-group-item"><strong>Phone : </strong><a>{{$patient->phone}}</a></li>
                            <li class="list-group-item"><strong>Emmergency Contact : </strong><a>{{$patient->emergency_contact}}</a></li>
                            <li class="list-group-item"><strong>Email : </strong><a>{{$patient->email}}</a></li>
                            <li class="list-group-item"><strong>Communication preference : </strong>
                                <a>
                                    @if($patient->communication_preference === 0)
                                        Email
                                    @elseif($patient->communication_preference == 1)
                                        SMS
                                    @elseif($patient->communication_preference == 2)
                                        SMS & Email
                                    @elseif($patient->communication_preference == 4)
                                        Phone
                                    @else
                                        None
                                    @endif
                                </a>
                            </li>
                            <li class="list-group-item"><strong>Privacy policy : </strong>
                                <a>
                                    @if($patient->privacy_policy === 0)
                                        No response
                                    @elseif($patient->privacy_policy == 1)
                                        Accepted
                                    @elseif($patient->privacy_policy == 2)
                                        Rejected
                                    @else

                                    @endif
                                </a>
                            </li>
                            <li class="list-group-item"><strong>Created On : </strong><a>{{$patient->created_at->format('g:i A D jS, M, Y')}}</a></li>

                        </ul>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom" style="background: transparent">
                    <ul class="nav nav-tabs nav-tabs-success no-print" style="background: #ffffff;height: 46px;">
                        <li class="active"><a href="#reports-summary" data-toggle="tab">Summary</a></li>
                        <li><a href="#more_details" data-toggle="tab">Patient Details</a></li>
                        <li><a href="#contacts" data-toggle="tab">Contacts</a></li>
                        <li><a href="#appointments" data-toggle="tab">Appointments</a></li>
                        @if(!(auth()->user()->role_id == 4 && auth()->user()->role_type == 2))
                            <li><a href="#notes" data-toggle="tab">Notes</a></li>
                        @endif
                        <li><a href="#tasks" data-toggle="tab">Tasks</a></li>
                        <li><a href="#invoices" data-toggle="tab">Invoices</a></li>
                        @if((auth()->user()->role_id == 1 || auth()->user()->role_id == 2) || (isset($patient->doctor) && count($patient->doctor->companies) && $patient->doctor->companies->first()->sms_enabled))
                            <li><a href="#communication" data-toggle="tab">Communication</a></li>
                        @endif
                    </ul>

                    <div class="tab-content" style="background: transparent">
                        <div class="active tab-pane" id="reports-summary">
                            <div class="box">
                                <div class="box-body">
                                    @include('inc.patients.single_patient.documents')
                                </div>
                            </div>

                            @if(!(auth()->user()->role_id == 4 && auth()->user()->role_type == 2))

                                <div class="box">
                                    <div class="box-body">
                                        @include('inc.patients.single_patient.notes-summary')
                                    </div>
                                </div>

                                <div class="box">
                                    <div class="box-body">
                                        @include('inc.patients.single_patient.prescriptions')
                                    </div>
                                </div>

                                <div class="box">
                                    <div class="box-body">
                                        @include('inc.patients.single_patient.letters-summary')
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane" id="more_details">
                            <div class="box">
                                <div class="box-body">
                                    @include('inc.patients.single_patient.more_details')
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="contacts">
                            <div class="box">
                                <div class="box-body">
                                    @include('inc.patients.single_patient.contacts')
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="appointments">
                            <div class="box">
                                <div class="box-body">
                                    @include('inc.patients.single_patient.appointments')
                                </div>
                            </div>
                        </div>

                        @if(!(auth()->user()->role_id == 4 && auth()->user()->role_type == 2))
                            <div class="tab-pane" id="notes">
                                <div class="box">
                                    <div class="box-body">
                                        @include('inc.patients.single_patient.notes')
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="box-body">
                                        @include('inc.patients.single_patient.documents')
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="box-body">
                                        @include('inc.patients.single_patient.letters')
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="box-body">
                                        @include('inc.patients.single_patient.prescriptions')
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="tab-pane" id="tasks">
                            <div class="box">
                                <div class="box-body">
                                    @include('inc.patients.single_patient.tasks')
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="invoices">
                            <div class="box">
                                <div class="box-body">
                                    @include('inc.patients.single_patient.invoices')
                                </div>
                            </div>
                        </div>

                        @if((auth()->user()->role_id == 1 || auth()->user()->role_id == 2) || (isset($patient->doctor) && count($patient->doctor->companies) && $patient->doctor->companies->first()->sms_enabled))
                            <div class="tab-pane" id="communication">
                                <div class="box">
                                    <div class="box-body">
                                        <table class="table table-hover">
                                            <tr class="active">
                                                <th width="50%">
                                                    <h4><strong>Patient's SMS</strong></h4>
                                                </th>
                                                <th>
                                                    <a href="#" data-toggle="modal" data-target="#sendSMS" class="pull-right btn btn-success no-print pull-right">Send</a>
                                                </th>
                                            </tr>
                                        </table>
                                        @if (count($patient->smss) > 0)
                                            <table class="table table-bordered">
                                                <thead>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Message</th>
                                                <th>Sent at</th>
                                                <th>Actions</th>
                                                </thead>
                                                <tbody>
                                                @foreach ($patient->smss as $sms)
                                                    <tr>
                                                        <td>{{$sms->from}}</td>
                                                        <td>{{$sms->to}}</td>
                                                        <td>{{$sms->message}}</td>
                                                        <td>{{$sms->created_at->diffForHumans()}}</td>
                                                        <td>
                                                            <form action="{{route('messages.destroy', $sms->id)}}" method="POST">
                                                                {{csrf_field()}} {{method_field('DELETE')}}
                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i
                                                                        class="fa fa-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            Patient has no sms.
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create New Appointment</h4>
                </div>
                <div class="modal-body">

                    <form action="{{route('appointments.store')}}" method="post">

                        {{csrf_field()}}

                        <div class="row" style="padding: 1%;">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Select Service</label>

                                    @if($services->count() > 0)
                                        <select onchange="getDoctor()" name="service_id" id="service_id" class="form-control" required>
                                            <option selected disabled>Select service</option>
                                            @foreach ($services as $service)
                                                <option value="{{$service->id}}">{{$service->name}}</option>
                                            @endforeach
                                        </select>
                                    @else

                                        @if (!auth()->user()->role_id == 5)
                                            <p>No Service Available.
                                        @endif
                                        <p>No Service Available.
                                            <a href="{{route('services.create')}}">Create Service</a>
                                        </p>
                                    @endif

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Assign Staff</label>
                                    <select name="doctor_id" id="doctor_id" class="form-control" onchange="createNewFlatpickr()" required>
                                        <option selected disabled>Select service first</option>
                                        {{--@foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->firstname}} {{$user->lastname}}</option>
                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="box border-info">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="date-picker col-md-5">
                                                        <input type="hidden" name="from" id="appointmentFromTime">
                                                        <input class="form-control flatpickr flatpickr-input" type="text" id="appointment_date" name="appointment_date"
                                                               value="{{old('appointment_date')}}" placeholder="Select Appointment Date" data-id="inline" readonly="readonly"
                                                               required>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div style="padding: 7px!important;" class="box-header bg-success text-center">
                                                            <h3 class="box-title">Date: </h3>

                                                        </div>
                                                        <div class="table-responsive text-center" style="width: 100%">
                                                            <table class="table">
                                                                <thead>
                                                                <tr>
                                                                    <th class="text-center"><span class="date morning"></span>Morning</th>
                                                                    <th class="text-center"><span class="date afternoon"></span>Afternoon</th>
                                                                    <th class="text-center"><span class="date evening"></span>Evening</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td colspan="3" id="morning">
                                                                        <div class="text-info">Please choose a date</div>
                                                                    </td>
                                                                    <td id="afternoon">
                                                                    </td>
                                                                    <td id="evening">
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">

                                    @if (auth()->user()->role_id == 5)
                                        <label>Patient Name. </label>
                                        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                                        <select name="user_id" id="user_id" class="form-control" disabled>
                                            <option value="{{auth()->user()->id}}" id="test">
                                                {{auth()->user()->firstname}}
                                                {{auth()->user()->lastname}}
                                                - DOB : {{auth()->user()->date_of_birth}}
                                                @if (auth()->user()->nhs_number)
                                                    - NHS : {{auth()->user()->nhs_number}}
                                                @endif
                                            </option>
                                        </select>
                                    @else

                                        <label>Patient Name.</label>
                                        <select name="user_id" id="user_id" class="form-control" required>
                                            <option value="{{$patient->id}}">
                                                {{$patient->firstname}} {{$patient->lastname}} -
                                                DOB : {{$patient->date_of_birth}}
                                                @if ($patient->nhs_number)
                                                    - NHS : {{$patient->nhs_number}}
                                                @endif

                                            </option>
                                        </select>

                                    @endif

                                </div>
                            </div>

                        </div>

                        <hr>
                        <div class="row" style="padding: 1%;">
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Enter Comment...">{{old('description')}}</textarea>
                            </div>
                        </div>
                        <hr>

                        <div class="row" style="padding: 1%;">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_video_conference" value="1"> Video consultation
                                </label>
                            </div>
                        </div>
                        <hr>

                        <div class="row" style="padding: 1%;">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
                            </div>
                            <div class="col-md-6">
                                <input type="submit" class="btn btn-sm btn-success btn-block" value="Submit Appointment">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="patientNote" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alert Message</h4>
                </div>
                <div class="modal-body">
                    {!! html_entity_decode($patient->patient_note) !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div id="sendSMS" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Send Message</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('patients.sendSMS') }}" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $patient->id }}">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                                <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ $patient->phone }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Choose template</label>
                            <div class="col-sm-10">
                                <select name="template" id="template" class="form-control" onchange="showTemplate();checkLengthOfMessage()">
                                    <option value="">Select Template</option>
                                    @foreach($smsTemplates as $smsTemplate)
                                        <option value="{{ $smsTemplate->body }}">{{ $smsTemplate->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Message</label>
                            <div class="col-sm-10">
                                <textarea name="message" onkeyup="checkLengthOfMessage()" id="message" class="form-control" placeholder="Message"
                                          rows="5">{{old('message')}}</textarea>
                                <span class="help-block">
                                    <strong></strong>
                                </span>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Save as template</label>
                            <div class="col-sm-2">
                                <input type="checkbox" name="save_as_template" onchange="toogleInput(this)">
                            </div>
                            <div class="title col-md-8">
                                <label for="inputPassword3" class="col-sm-4 col-form-label">Template title</label>
                                <div class="col-sm-8">
                                    <input type="text" name="template_title" placeholder="Template title" class="form-control">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Send SMS</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="patientNoteNew" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alert Message</h4>
                </div>
                <div class="modal-body">
                    {!! html_entity_decode($patient->patient_note) !!}
                </div>
                <div class="modal-footer">
                    <div class="col-md-6">
                        <form action="{{route('patient_store_prescription.store')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="user_id" value="{{$patient->id}}">
                            <input type="submit" value="Create Prescription Letter" class="btn btn-success pull-left">
                        </form>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/vue.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        let Result = null;
        let fp = null;

        $(document).ready(function () {
            @if($patient->patient_note_text && $patient->patient_note_text != "")
            $('#patientNote').modal('show');
                @endif

            var selectDropDown = $(".template_id").select2();
            selectDropDown.on('select2:select', function (e) {
                var event = new Event('change');
                e.target.dispatchEvent(event);
            });

            //let date = new Date();
            //getAvailableDateTime(date.getMonth() + 1, date.getFullYear(), new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate());

            var locationPosition = $(location).attr('hash');
            var locationsArray = ['#reports-summary', '#more_details', '#contacts', '#appointments', '#tasks', '#invoices', '#communication'];
            if (!locationsArray.includes(locationPosition)) {
                locationPosition = '#reports-summary';
            }
            $('a[href="' + locationPosition + '"]').click();
        });

        // Get availableDateTime for current doctor & month, year
        function getAvailableDateTime(month, year, days) {
            $.ajax({
                type: 'get',
                url: '{{ route('timings.show') }}',
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
            if (fp) {
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
                        url: '{{ route('timings.show') }}',
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
                        url: '{{ route('timings.show') }}',
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
                url: window.location.origin + '/doctor-by-service/' + $('#service_id').val(),
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
            $('#myModal').modal('show');
        }

        function showNote() {
            $('#patientNoteNew').modal('show');
        }

        function toogleInput(_this) {
            if (_this.checked) {
                $('.title').show();
            } else {
                $('.title').hide();
            }
        }

        function showTemplate() {
            $('#message').val($('#template option:selected').val());
        }
    </script>
@endsection

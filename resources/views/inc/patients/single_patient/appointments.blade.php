<table class="table table-hover">
    <tr class="active">
        <th width="50%">
            <h4><strong>Patient's Appointments</strong></h4>
        </th>
        <th>
            <a href="javascript:void(0)" class="btn btn-success btn-sm no-print pull-right" data-toggle="modal" data-target="#myModal">Create Appointment</a>
        </th>
    </tr>
</table>

@if (count($patient->appointments) > 0)
    <table class="table table-bordered" id="appointments_table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Appointment Date</th>
            {{-- <th>End Date</th> --}}
            <th>Status</th>
            <th>Doctor Assigned</th>
            <th>Created On</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($patient->appointments as $appointment)
            <tr>
                <td><a href="{{route('appointments.show', $appointment->id)}}">@if($appointment->service){{$appointment->service->name}}@endif</a></td>
                <td>{{$appointment->appointment_date/*->format('D, jS, M, Y')*/}} {{ date('h:iA', strtotime($appointment->from)) }}-{{ date('h:iA', strtotime($appointment->to)) }}</td>
                {{-- <td>{{$appointment->end_date}}</td> --}}
                <td>{{$appointment->status}}</td>
                <td>@if($appointment->doctor){{$appointment->doctor->firstname}}@endif</td>
                <td>{{$appointment->created_at->diffForHumans()}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    Patient has No Appointments yet.
@endif

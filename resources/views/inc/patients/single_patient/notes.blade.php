<table class="table table-hover">
    <tr class="active">
        <th width="50%">
            <h4><strong>Initial Consultation Notes</strong></h4>
        </th>
        <th>
            <a href="{{route('patientinitialnote.create', $patient->id)}}" class="btn btn-success btn-sm no-print pull-right"> Create Initial Consultation Note</a>
        </th>
    </tr>
</table>
@if (count($patient->initialconsultations) > 0)
    <table class="table table-bordered" id="initialnotes_table">
        <thead>
        <th>#ID</th>
        <th>Presenting Complaint</th>
        <th>Created On</th>
        </thead>
        <tbody>
        @foreach ($patient->initialconsultations as $note)
            <tr>
                <td>{{$note->id}}</td>
                <td><a href="{{route('initialnotes.show', $note->id)}}">{!! $note->complain !!}</a></td>
                <td>{{$note->created_at->diffForHumans()}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    Patient has No Initial Consultation Notes yet.
@endif

<br>
<br>
<hr>
<br>

<table class="table table-hover">
    <tr class="active">
        <th width="50%">
            <h4><strong>Follow Up Consultation Notes</strong></h4>
        </th>
        <th>
            <a href="{{route('patientfollowupnote.create', $patient->id)}}" class="btn btn-success btn-sm no-print pull-right"> Create Follow Up Consultation Note</a>
        </th>
    </tr>
</table>
@if (count($patient->followupconsultations) > 0)
    <table class="table table-bordered" id="followupnotes_table">
        <thead>
        <th>#ID</th>
        <th>Patient Progress</th>
        <th>Created On</th>
        </thead>
        <tbody>
        @foreach ($patient->followupconsultations as $note)
            <tr>
                <td>{{$note->id}}</td>
                <td><a href="{{route('followupnotes.show', $note->id)}}">{!! $note->patient_progress !!}</a></td>
                <td>{{$note->created_at->diffForHumans()}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    Patient has No Follow Up Consultation Notes yet.
@endif

<br>
<br>
<hr>
<br>

<table class="table table-hover">
    <tr class="active">
        <th width="50%">
            <h4><strong>Vitals Note</strong></h4>
        </th>
        <th>
            <a href="{{route('patientvital.create', $patient->id)}}" class="btn btn-success btn-sm no-print pull-right"> Create Vitals Note</a>
        </th>
    </tr>
</table>
@if (count($patient->vitals) > 0)
    <table class="table table-bordered" id="vitals_table">
        <thead>
        <th>#ID</th>
        <th>Weight</th>
        <th>Height</th>
        <th>Temp</th>
        <th>Sat O2</th>
        <th>RR</th>
        <th>BP</th>
        <th>Pulse</th>
        <th>Ad O2</th>
        <th>Pain</th>
        <th>Head cir.</th>
        <th>Date</th>
        </thead>
        <tbody>
        @foreach ($patient->vitals as $vital)
            <tr>
                <td><a href="{{route('vitals.show', $vital->id)}}">#{{$vital->id}}</a></td>
                <td>{{$vital->weight}}</td>
                <td>{{$vital->height}}</td>
                <td>{{$vital->temperature}}</td>
                <td>{{$vital->oxygen_saturation}}</td>
                <td>{{$vital->respiratory_rate}}</td>
                <td>{{$vital->systolic_bp}}-{{$vital->diastolic_bp}}</td>
                <td>{{$vital->pulse_rate}}</td>
                <td>{{$vital->o2_administered}}</td>
                <td>{{$vital->pain}}</td>
                <td>{{$vital->head_circumference}}</td>
                <td>{{$vital->created_at->format('jS M, Y')}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    Patient has No Vital Note yet.
@endif

<br>
<br>
<hr>
<br>

<table class="table table-hover">
    <tr class="active">
        <th width="50%">
            <h4><strong>Template</strong></h4>
        </th>
        <th>
            @if(auth()->user()->role_id != 4)
                <a href="{{ route('patients.newTemplate', ['id' => $patient->id, 'type'=>'note']) }}" class="btn btn-success btn-sm no-print pull-right">Create Template</a>
            @elseif(auth()->user()->role_id == 4 && auth()->user()->role_type == 1)
                <a href="{{ route('patients.newTemplate', ['id' => $patient->id, 'type'=>'note']) }}" class="btn btn-success btn-sm no-print pull-right">Create Template</a>
            @endif
        </th>
    </tr>
</table>
<table class="table table-bordered" id="treatment_note">
    <thead>
    <th>Template</th>
    <th>Appointment</th>
    <th>Created On</th>
    <th>Actions</th>
    </thead>
    <tbody>
    @if (count($patient->treatmentNote) > 0)
        @foreach ($patient->treatmentNote as $note)
            @if($note->type == 'note')
                <tr>
                    <td><a href="{{route('patient_treatment_notes.show', $note->id)}}">{{$note->template->title}}</a></td>
                    <td>@if($note->appointment_id && isset($note->appointment->appointment_date)){{date('d M Y', strtotime($note->appointment->appointment_date))}}, {{ $note->appointment->from }}@else None @endif</td>
                    <td>{{$note->created_at->diffForHumans()}}</td>
                    <td>
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{route('patient_treatment_notes.show', $note->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Show</a>
                            </div>
                            @if(auth()->user()->role_id != 4)
                                @if($note->status === 0)
                                <div class="col-md-4">
                                    <a href="{{ route('patient_treatment_notes.edit', $note->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                </div>
                                @endif
                                <div class="col-md-4">
                                    <form action="{{route('patient_treatment_notes.destroy', $note->id)}}" method="POST">
                                        {{csrf_field()}} {{method_field('DELETE')}}
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
    @else
        Patient has No Treatment Notes yet.
    @endif
    </tbody>
</table>

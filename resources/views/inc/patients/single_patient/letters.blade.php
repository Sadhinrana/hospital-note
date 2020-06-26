<table class="table table-hover">
    <tr class="active">
        <th width="50%">
            <h4><strong>Letters</strong></h4>
        </th>
        <th>
            @if(auth()->user()->role_id != 4)
                <a href="{{ route('patients.newTemplate', ['id' => $patient->id, 'type'=>'letter']) }}" data-toggle="modal" class="btn btn-success btn-sm no-print pull-right">Create Template</a>
            @endif
        </th>
    </tr>
</table>

@if (count($patient->treatmentNote) > 0)
    <table class="table table-bordered">
        <thead>
        <th>Template</th>
        <th>Appointment</th>
        <th>Created On</th>
        <th>Actions</th>
        </thead>
        <tbody>
        @foreach ($patient->treatmentNote as $note)
            @if($note->type == 'letter')
                <tr>
                    <td><a href="{{route('patient_treatment_notes.show', $note->id)}}">{{$note->template->title}}</a></td>
                    <td>@if($note->appointment_id){{date('d M Y', strtotime($note->appointment->appointment_date))}}, {{ $note->appointment->from }}@else None @endif</td>
                    <td>{{$note->created_at->diffForHumans()}}</td>
                    <td>
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{route('patient_treatment_notes.show', $note->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Show</a>
                            </div>
                            @if(auth()->user()->role_id != 4)
                                @if($note->status === 0)
                                <div class="col-md-4">
                                    <a @click="editNote('{{ $note->id }}', '{{ route('patient_treatment_notes.update', $note->id) }}')" href="{{ route('patient_treatment_notes.edit', $note->id) }}" data-toggle="modal" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
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
        </tbody>
    </table>
@else
    Patient has No Treatment Notes yet.
@endif

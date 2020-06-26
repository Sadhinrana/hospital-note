@if (count($patient->treatmentNote) > 0)
    <table class="table table-hover">
        @if (count($patient->treatmentNote) > 0)
            @foreach ($patient->treatmentNote as $patientTreatmentNote)
                @if($patientTreatmentNote->type == 'letter')
                    <tr class="active">
                        <th width="50%">
                            <h4><strong>Date created: </strong> {{ $patientTreatmentNote->created_at->format('d/m/Y') }}</h4>
                            <h4><strong>Created by: </strong> {{ $patientTreatmentNote->creator->firstname . ' ' . $patientTreatmentNote->creator->lastname }}</h4>
                        </th>
                        <th>
                            <h4><strong>Type of the note: </strong> Template</h4>
                        </th>
                    </tr>
                    @foreach($patientTreatmentNote->template->sections as $section)
                        @foreach($section->questions as $question)
                            @if($patientTreatmentNote->notes()->where('question_id', $question->id)->where('answer', '!=', '')->first())
                            <tr>
                                <th width="200px">{{ $question->title }}</th>
                                @foreach($patientTreatmentNote->notes as $note)
                                    @if($note->question_id == $question->id)
                                        @if($question->type == 4)
                                            <td style="text-align: justify">
                                                <div class="row">
                                                    @foreach(explode(",",$note->answer) as $imageSrc)
                                                        @if($imageSrc)
                                                        <div style="width:250px; border: 1px solid #dddddd; float: left;">
                                                            <img src="{{asset('/').$imageSrc}}" style="width:100%">
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                        @elseif($question->type == 3)
                                            <td style="text-align: justify">
                                                <div class="row">
                                                    @foreach(explode(",",$note->answer) as $item)
                                                        <span class="badge bg-info">{{$item}}</span>
                                                    @endforeach
                                                </div>
                                            </td>
                                        @else
                                            <td style="text-align: justify">{!! nl2br($note->answer) !!}</td>
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                            @endif
                        @endforeach
                    @endforeach
                @endif
            @endforeach
        @endif
    </table>
@else
    Patient has No Treatment Notes yet.
@endif

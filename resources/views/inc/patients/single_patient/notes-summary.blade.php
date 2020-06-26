<div class="panel">
    <div class="panel-body">
        @if(count($patient->initialconsultations) == 0 && count($patient->followupconsultations) == 0 && count($patient->vitals) == 0 && count($patient->treatmentNote) == 0)
            Patient has No Notes yet.
        @else
            <table class="table table-hover">
                <tbody>
                @if (count($patient->initialconsultations) > 0)
                    @foreach ($patient->initialconsultations as $note)
                        <tr class="active">
                            <th width="50%">
                                <h4><strong>Date created: </strong> {{ $note->created_at->format('d/m/Y') }}</h4>
                                <h4><strong>Created by: </strong> {{ $note->creator->firstname . ' ' . $note->creator->lastname }}</h4>
                            </th>
                            <th>
                                <h4><strong>Type of the note: </strong> Initial Consultation Notes</h4>
                            </th>
                        </tr>
                        @if($note->complain)
                            <tr>
                                <th>Presenting Complain</th>
                                <td style="text-align: justify">{!! html_entity_decode($note->complain) !!}</td>
                            </tr>
                        @endif
                        @if($note->history_presenting_complaint)
                            <tr>
                                <th>History of Presenting Complaint</th>
                                <td style="text-align: justify">{!! $note->history_presenting_complaint ?? '' !!}</td>
                            </tr>
                        @endif
                        @if($note->past_medical_history)
                            <tr>
                                <th>Past Medical History</th>
                                <td style="text-align: justify">{!! $note->past_medical_history ?? '' !!}</td>
                            </tr>
                        @endif
                        @if($note->family_history)
                            <tr>
                                <th>Family History</th>
                                <td style="text-align: justify">{!! $note->family_history ?? '' !!}</td>
                            </tr>
                        @endif
                        @if($note->social_history)
                            <tr>
                                <th>Social History</th>
                                <td style="text-align: justify">{!! $note->social_history ?? '' !!}</td>
                            </tr>
                        @endif
                        @if($note->drug_history)
                            <tr>
                                <th>Drug History</th>
                                <td style="text-align: justify">{!! $note->drug_history ?? '' !!}</td>
                            </tr>
                        @endif
                        @if($note->drug_allergies)
                            <tr>
                                <th>Drug Allergies</th>
                                <td style="text-align: justify">{!! $note->drug_allergies ?? '' !!}</td>
                            </tr>
                        @endif
                        @if($note->examination)
                            <tr>
                                <th>Examination</th>
                                <td style="text-align: justify">{!! $note->examination ?? '' !!}</td>
                            </tr>
                        @endif
                        @if($note->diagnosis)
                            <tr>
                                <th>Diagnosis</th>
                                <td style="text-align: justify">{!! $note->diagnosis ?? '' !!}</td>
                            </tr>
                        @endif
                        @if($note->treatment)
                            <tr>
                                <th>Treatment</th>
                                <td style="text-align: justify">{!! $note->treatment ?? '' !!}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
                @if (count($patient->followupconsultations) > 0)
                    @foreach ($patient->followupconsultations as $consultation)
                        <tr class="active">
                            <th>
                                <h4><strong>Date created: </strong> {{ $consultation->created_at->format('d/m/Y') }}</h4>
                                <h4><strong>Created by: </strong> {{ $consultation->creator->firstname . ' ' . $consultation->creator->lastname }}</h4>
                            </th>
                            <th>
                                <h4><strong>Type of the note: </strong> Follow Up Consultation Notes</h4>
                            </th>
                        </tr>
                        @if($consultation->patient_progress)
                            <tr>
                                <th>Patient Progress</th>
                                <td style="text-align: justify">{!! $consultation->patient_progress !!}</td>
                            </tr>
                        @endif
                        @if($consultation->assessment)
                            <tr>
                                <th>Patient Assessment</th>
                                <td style="text-align: justify">{!! $consultation->assessment !!}</td>
                            </tr>
                        @endif
                        @if($consultation->plan)
                            <tr>
                                <th>Plan</th>
                                <td style="text-align: justify">{!! $consultation->plan !!}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
                @if (count($patient->vitals) > 0)
                    @foreach ($patient->vitals as $vital)
                        <tr class="active">
                            <th>
                                <h4><strong>Date created: </strong> {{ $vital->created_at->format('d/m/Y') }}</h4>
                                <h4><strong>Created by: </strong> {{ $vital->creator->firstname . ' ' . $vital->creator->lastname }}</h4>
                            </th>
                            <th>
                                <h4><strong>Type of the note: </strong> Vitals Note</h4>
                            </th>
                        </tr>
                        @if($vital->temperature)
                            <tr>
                                <th>Temperature</th>
                                <td style="text-align: justify">{{$vital->temperature}}</td>
                            </tr>
                        @endif
                        @if($vital->pulse_rate)
                            <tr>
                                <th>Pulse Rate</th>
                                <td style="text-align: justify">{{$vital->pulse_rate}}</td>
                            </tr>
                        @endif
                        @if($vital->systolic_bp)
                            <tr>
                                <th>Systolic BP</th>
                                <td style="text-align: justify">{{$vital->systolic_bp}}</td>
                            </tr>
                        @endif
                        @if($vital->diastolic_bp)
                            <tr>
                                <th>Diastolic BP</th>
                                <td style="text-align: justify">{{$vital->diastolic_bp}}</td>
                            </tr>
                        @endif
                        @if($vital->respiratory_rate)
                            <tr>
                                <th>Respiratory Rate</th>
                                <td style="text-align: justify">{{$vital->respiratory_rate}}</td>
                            </tr>
                        @endif
                        @if($vital->oxygen_saturation)
                            <tr>
                                <th>Oxygen Saturation</th>
                                <td style="text-align: justify">{{$vital->oxygen_saturation}}</td>
                            </tr>
                        @endif
                        @if($vital->o2_administered)
                            <tr>
                                <th>O2 Administered</th>
                                <td style="text-align: justify">{{$vital->o2_administered}}</td>
                            </tr>
                        @endif
                        @if($vital->pain)
                            <tr>
                                <th>Pain</th>
                                <td style="text-align: justify">{{$vital->pain}}</td>
                            </tr>
                        @endif
                        @if($vital->head_circumference)
                            <tr>
                                <th>Head Circumference</th>
                                <td style="text-align: justify">{{$vital->head_circumference}}</td>
                            </tr>
                        @endif
                        @if($vital->height)
                            <tr>
                                <th>Height</th>
                                <td style="text-align: justify">{{$vital->height}}</td>
                            </tr>
                        @endif
                        @if($vital->weight)
                            <tr>
                                <th>Weight</th>
                                <td style="text-align: justify">{{$vital->weight}}</td>
                            </tr>
                        @endif
                        @if($vital->created_at)
                            <tr>
                                <th>Created On</th>
                                <td>{{$vital->created_at->format('D, M, jS, Y g:i A')}}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
                @if (count($patient->treatmentNote) > 0)
                    @foreach ($patient->treatmentNote as $patientTreatmentNote)
                        @if($patientTreatmentNote->type == 'note')
                            <tr class="active">
                                <th>
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
                </tbody>
            </table>
        @endif
    </div>
</div>

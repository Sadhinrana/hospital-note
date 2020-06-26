@extends('adminlte::page')

@section('content')

    <div class="panel panel-success">
        <div class="panel-heading hidden-print">
            <div class="row">
                <div class="col-md-4">
                    <button onclick="goBack()" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i> Back</button>
                </div>
                <div class="col-md-4 text-center">
                    <strong>Report show</strong>
                </div>
                <div class="col-md-4 text-right">
                    <a href="{{ route('medical-reports.index') }}" class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> Back to list</a>
                </div>
            </div>
        </div>
        <div class="panel-body hidden" id="report-wrapper">
            @include('inc.medical-report.report')
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('/js/vue.min.js') }}"></script>
    <script>
        let reportOptions = {!! $medicalReport->data !!};

        // New vue instance
        new Vue({
            el: '#report-wrapper',
            data: {
                reportRender: 1,
                renderForm: 14,
                reportData: reportOptions,
                examinationNeck: [
                    {
                        label:
                            "Examination revealed a moderate restriction in movement due to pain at the limits of movement. Distraction testing was negative.",
                        value: '81',
                        settings: { sfe: 110, rlr: 70, rlf: 40, llr: 70, llf: 40 }
                    },
                    {
                        label: "Not Examined.",
                        value: '2'
                    },
                    {
                        label:
                            "Neck examination showed a normal range of movement in movement with no tenderness to palpation or pain on movement.",
                        value: '3',
                        settings: { sfe: 120, rlr: 80, rlf: 45, llr: 80, llf: 45 }
                    },
                    {
                        label: "Neck examination showed a normal range of movement in movement.",
                        value: '4'
                    },
                    {
                        label: "Full range of movement with pain at limits.",
                        value: '5'
                    },
                    {
                        label:
                            "Neck examination showed a slight restriction in movement with associated trapezius tenderness, equal on both sides. Axial loading was negative. Distraction testing was negative.",
                        value: '6',
                        settings: { sfe: 110, rlr: 75, rlf: 40, llr: 75, llf: 40 }
                    },
                    {
                        label:
                            "Neck examination showed a slight restriction in movement with associated trapezius tenderness, especially on the left. Axial loading was negative. Distraction testing was negative. ",
                        value: '7',
                        settings: { sfe: 110, rlr: 75, rlf: 40, llr: 80, llf: 45 }
                    },
                    {
                        label:
                            "Neck examination showed a slight restriction in movement with associated trapezius tenderness, especially on the right. Axial loading was negative. Distraction testing was negative. ",
                        value: '8',
                        settings: { sfe: 110, rlr: 80, rlf: 45, llr: 75, llf: 40 }
                    },
                    {
                        label:
                            "Neck examination showed a moderate restriction in movement with associated trapezius tenderness, equal on both sides. Axial loading was negative. Distraction testing was negative. ",
                        value: '9',
                        settings: { sfe: 110, rlr: 70, rlf: 40, llr: 70, llf: 40 }
                    },
                    {
                        label:
                            "Neck examination showed a moderate restriction in movement with associated trapezius tenderness, especially on the left.",
                        value: '10',
                        settings: { sfe: 120, rlr: 70, rlf: 40, llr: 80, llf: 45 }
                    },
                    {
                        label:
                            "Neck examination showed a moderate restriction in movement with associated trapezius tenderness, especially on the right. Axial loading was negative. Distraction testing was negative.",
                        value: '11',
                        settings: { sfe: 110, rlr: 80, rlf: 45, llr: 70, llf: 40 }
                    },
                    {
                        label:
                            "Neck examination showed a severe restriction in movement with associated trapezius tenderness, equal on both sides. Axial loading was negative. Distraction testing was negative.",
                        value: '12',
                        settings: { sfe: 110, rlr: 65, rlf: 35, llr: 65, llf: 35 }
                    },
                    {
                        label:
                            "Neck examination showed a severe restriction in in movement with associated trapezius tenderness, especially on the left. Axial loading was negative. Distraction testing was negative.",
                        value: '13',
                        settings: { sfe: 120, rlr: 65, rlf: 35, llr: 80, llf: 45 }
                    },
                    {
                        label:
                            "Neck examination showed a severe restriction in in movement with associated trapezius tenderness, especially on the right. Axial loading was negative. Distraction testing was negative.",
                        value: '14',
                        settings: { sfe: 110, rlr: 80, rlf: 45, llr: 65, llf: 35 }
                    },

                    {
                        label:
                            "Neck examination showed a moderate restriction in movement. Axial loading was negative. Distraction testing was negative. ",
                        value: '15',
                        settings: { sfe: 110, rlr: 70, rlf: 40, llr: 70, llf: 40 }
                    },
                    {
                        label: "Neck examination showed a severe restriction in movement.",
                        value: '16',
                        settings: { sfe: 90, rlr: 65, rlf: 35, llr: 65, llf: 35 }
                    }
                ],
                severityListText: [
                    {
                        id: 1,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be severe. The current severity of the symptom is described as severe. The symptom has therefore not changed from it's initial severity."
                    },
                    {
                        id: 2,
                        text:
                            "The onset of this symptom was immediately after the material incident. The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be severe. The current severity of the symptom is described as moderate. The symptom has therefore improved over time. "
                    },
                    {
                        id: 3,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be severe. The current severity of the symptom is described as mild. The symptom has therefore improved over time."
                    },
                    {
                        id: 4,
                        text:
                            "The onset of this symptom was immediately after the material incident. The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be severe. The current severity of the symptom is nil. This symptom has resolved."
                    },
                    {
                        id: 5,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be moderate. The current severity of the symptom is described as severe. The symptom has therefore deteriorated over time."
                    },
                    {
                        id: 6,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be moderate. The current severity of the symptom is described as moderate. The symptom has therefore not changed from it's initial severity."
                    },
                    {
                        id: 7,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be moderate. The current severity of the symptom is described as mild. The symptom has therefore improved over time."
                    },
                    {
                        id: 8,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be moderate. The current severity of the symptom is described as nil. The symptom has therefore resolved over time."
                    },
                    {
                        id: 9,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be mild. The current severity of the symptom is described as severe. The symptom has therefore deteriorated over time."
                    },
                    {
                        id: 10,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be mild. The current severity of the symptom is described as moderate. The symptom has therefore deteriorated over time."
                    },
                    {
                        id: 11,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be mild. The current severity of the symptom is described as mild. The symptom has therefore not changed from it's initial severity."
                    },
                    {
                        id: 12,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be mild. The current severity of the symptom is described as nil. The symptom has therefore resolved over time."
                    }
                ],
            },
            mounted: function () {
                $('#report-wrapper').removeClass('hidden').fadeIn();

                var rrData = JSON.stringify(this.reportData);
                var G = this.reportData.claimant.gender === 'M' ? 'he' : 'she';
                var GM = this.reportData.claimant.gender === 'M' ? 'his' : 'her';
                rrData = rrData.replace(/\$he-she\$/g, G);
                rrData = rrData.replace(/\$his-her\$/g, GM);
                this.reportData = JSON.parse(rrData);
            }
        });
    </script>
@endsection

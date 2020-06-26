@extends('adminlte::page')

@section('content')

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-4">
                    <button onclick="goBack()" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i> Back</button>
                </div>
                <div class="col-md-4">
                    <strong>All Medical Reports</strong>
                </div>
                <div class="col-md-4">
                    @if(auth()->user()->role_id != 5)
                        <a href="{{route('medical-reports.create')}}" class="btn btn-sm btn-primary btn-block"><i class="fa fa-plus"></i> Create New Medical Report</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="panel-body">
            @if(count($medicalReports) > 0)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date Of Birth</th>
                        <th>Created On</th>
                        <th>Created By</th>
                        <th class="text-right">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($medicalReports as $reports)

                        @php $report = json_decode($reports->data, 1); @endphp
                        <tr>
                            <td>{{ $report['claimant']['title'] . ' ' . $report['claimant']['firstName'] . ' ' .$report['claimant']['lastName'] }}</td>
                            <td>{{ $report['claimant']['dob'] }}</td>
                            <td>{{$reports->created_at->format('d M, Y')}}</td>
                            <td>{{$reports->user->firstname . ' ' . $reports->user->lastname}}</td>
                            <td class="text-right">
                                @if(auth()->user()->role_id != 5)
                                    <button type="button" class="btn btn-primary btn-sm"
                                            data-toggle="modal"
                                            data-target="#sendMailModal"
                                            data-report="{{ encrypt($reports->id) }}"
                                            data-email="{{ $reports->patient ? $reports->patient->email : '' }}">Send Mail
                                    </button>
                                    <a href="{{ route('invoices.create',"medical_report_id={$reports->id}") }}" class="btn btn-info btn-sm">Create Invoice</a>
                                @endif
                                <a href="{{route('medical-reports.show', $reports->id)}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>
                                <a href="{{route('medical-reports.edit', $reports->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                <form action="{{route('medical-reports.destroy', $reports->id)}}" method="POST" style="display: inline-block;">
                                    {{csrf_field()}}{{method_field('DELETE')}}
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @else
                <h4>There are no medical reports</h4>
            @endif
        </div>
    </div>

    <div class="modal fade" id="sendMailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Send medical report to patient</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('medical-report.email') }}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="report_id" id="report">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">Recipient:</label>
                            <input type="text" class="form-control" name="email" id="recipient-name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Message:</label>
                            <textarea class="form-control" name="message" id="message-text"></textarea>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">Send message</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(function () {
            $('#sendMailModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var recipient = button.data('email') // Extract info from data-* attributes
                var modal = $(this)
                modal.find('.modal-body #recipient-name').val(recipient)
                modal.find('#report').val(button.data('report'))
            })
        })
    </script>
@endsection

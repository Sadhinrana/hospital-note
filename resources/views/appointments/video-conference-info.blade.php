@extends('adminlte::page')

@section('content')
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-4">
                    <button onclick="goBack()" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i> Back</button>
                </div>
                <div class="col-md-4 text-center">
                    <h4><strong>Video conference</strong></h4>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>

        <div class="panel-body">
            @if($overdue)
            <div class="alert alert-danger">
                This appointments scheduled time has passed. This appointments was scheduled at <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M, Y') }} {{ \Carbon\Carbon::parse($appointment->from)->format('h:iA') }}-{{ \Carbon\Carbon::parse($appointment->to)->format('h:iA') }}</strong>.Please contact support if you think this is system bug.
            </div>
            @else
            <div class="alert alert-warning">
                This appointments scheduled time hasn't come yet. This appointments is scheduled at <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M, Y') }} {{ \Carbon\Carbon::parse($appointment->from)->format('h:iA') }}-{{ \Carbon\Carbon::parse($appointment->to)->format('h:iA') }}</strong>.Please contact support if you think this is system bug.
            </div>
            @endif
        </div>
    </div>
@endsection

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
                    <a href="{{route('medical-reports.create')}}" class="btn btn-sm btn-primary btn-block"><i class="fa fa-plus"></i> Create New Medical Report</a>
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
                            <td>{{date('d M, Y', strtotime($report['claimant']['dob']))}}</td>
                            <td>{{$reports->created_at->format('d M, Y')}}</td>
                            <td>{{$reports->user->firstname . ' ' . $reports->user->lastname}}</td>
                            <td class="text-right">
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

@endsection

@extends('adminlte::page')

@section('content')

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-4">
                    <button onclick="goBack()" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i>  Back</button>
                </div>
                <div class="col-md-4">
                    <strong>{{$service->name}}</strong>
                </div>
                <div class="col-md-4">
                    <a href="{{route('services.edit', $service->id)}}" class="btn btn-sm btn-primary btn-block"><i class="fa fa-pencil"></i>  Edit Service</a>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <p><b>Price:</b> {{ $service->price }}</p>
            <p><b>Payment required:</b> @if($service->is_payment) <button class="btn btn-success btn-sm">Yes</button> @else <button class="btn btn-danger btn-sm">No</button> @endif</p>
            <p>{{$service->description ?? 'No description'}}</p>
        </div>
        <div class="panel-footer">
            {{$service->created_at->format('D, M, jS, Y g:i A')}}
        </div>

    </div>

@endsection

@extends('adminlte::page')

@section('title', 'Room')

@section('content')
    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{ Session::get('success') }}
        </div>
    @endif

    <div class="panel panel-success">
        <div class="panel-heading">
             <div class="row">
                <div class="col-md-4">
                    <button onclick="goBack()" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i> Back</button>
                </div>
                <div class="col-md-4">
                    <strong> Room</strong>
                </div>
                <div class="col-md-4">
                    <a href="{{route('rooms.create')}}" class="btn btn-sm btn-primary btn-block"><i class="fa fa-user-plus"></i> Create  Room</a>
                </div>
            </div>
        </div>

        <div class="panel-body">
        @if(count($rooms) > 0)
            <table class="table table-bordered" id="users_table">
                <thead>
                    <tr>
                        <th>Name </th> 
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($rooms as $room)
                        <tr>
                            <td>{{ $room->name }}</td>
                             
                            <td>
                                <div class="row"> 
                                    <div class="col-md-1">
                                        <a href="{{route('rooms.edit', $room->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                    </div>
                                    <div class="col-md-1">
                                        <form action="{{route('rooms.destroy', $room->id)}}" method="POST">
                                            {{csrf_field()}} {{method_field('DELETE')}}
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                         </tr>
                        @endforeach
                </tbody>
            </table>
        @else
            <h4>There are no room</h4>
        @endif
        </div>
    </div>

@endsection

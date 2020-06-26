@extends('adminlte::page')

@section('title', 'Room create')

@section('css')
    <style>
        .ml-5 {
            margin-left: 3rem !important;
        }
        textarea{
            resize: vertical
        }
    </style>
@stop

@section('content') 

    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{ Session::get('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel panel-success">
        <div class="panel-heading">
          <div class="row">
            <div class="col-md-4">
                <button onclick="goBack()" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i> Back</button>
            </div>
            <div class="col-md-4">
                <strong>Create Room</strong>
            </div>
            <div class="col-md-4">
            </div>
          </div>
        </div>

        <div class="panel-body">
            <form action="{{route('rooms.store')}}" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Room Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Room Name..." required>
                        </div>
                    </div>
                </div>
 

                <div class="row" style="padding: 1%;">
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                </div>
            </form>
        </div>

        <hr>
   
    </div>

@endsection

@section('js') 
@endsection

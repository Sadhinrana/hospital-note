@extends('adminlte::page')

@section('content')

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-4">
                    <button onclick="goBack()" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i> Back</button>
                </div>
                <div class="col-md-4">
                    <strong>Edit Company Details</strong>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>

        <div class="panel-body">
            <form action="{{route('companydetails.update', $companydetail->id)}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}} {{method_field('PATCH')}}

                <div class="row">
                    <div class="col-md-6">
                        <label>Company Name</label>
                        <input type="text" name="name" value="{{$companydetail->name}}" placeholder="Enter Company Name..." class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Address</label>
                        <input type="text" name="address" value="{{$companydetail->address}}" placeholder="Enter Address..." class="form-control">
                    </div>
                </div><hr>
                <div class="row">
                    <div class="col-md-6">
                        <label>Company Email</label>
                        <input type="email" name="email" value="{{$companydetail->email}}" placeholder="Enter Company Email..." class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="tel" name="phone" value="{{$companydetail->phone}}" placeholder="Enter Phone..." class="form-control">
                    </div>
                </div><hr>

                <div class="row">
                    <div class="col-md-6">
                        <label>Company Logo</label>
                        <input type="file" name="logo" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Industry</label>
                        <input type="text" name="industry" value="{{$companydetail->industry}}" placeholder="Enter Industry..." class="form-control">
                    </div>
                </div><hr>

                <div class="row" style="padding-left:2%; padding-right:2%;">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" {{old('status',$companydetail->status)=="1"? 'selected':''}}>Active</option>
                        <option value="0" {{old('status',$companydetail->status)=="0"? 'selected':''}}>Inactive</option>
                    </select>
                </div><hr>

                @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                <div class="row" style="padding-left:2%; padding-right:2%;">
                    <label for="sms_enabled">SMS Enabled</label>
                    <select name="sms_enabled" id="sms_enabled" class="form-control">
                        <option value="1" {{old('sms_enabled', $companydetail->sms_enabled)=="1"? 'selected':''}}>Yes</option>
                        <option value="0" {{old('sms_enabled', $companydetail->sms_enabled)=="0"? 'selected':''}}>No</option>
                    </select>
                </div><hr>

                <div class="row" style="padding-left:2%; padding-right:2%;">
                    <label for="sms_enabled">Company Owner</label>
                    <select name="user_id" id="user_id" class="form-control">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{old('user_id', $companydetail->user_id) == $user->id ? 'selected' : ''}}>{{ $user->firstname . ' ' . $user->lasstname }}</option>
                        @endforeach
                    </select>
                </div><hr>
                @endif

                <div class="row" style="padding-left:2%; padding-right:2%;">
                    <label>More Information</label>
                    <textarea name="more_info" id="more_info" placeholder="Enter More Information...">
                {{$companydetail->more_info}}
            </textarea>
                </div><hr>

                <div class="row" style="padding-left:2%; padding-right:2%;">
                    <input type="submit" class="btn btn-sm btn-primary btn-block" value="Update Company Details">
                </div>
            </form>
        </div>
    </div>

@endsection

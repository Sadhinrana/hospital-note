@extends('adminlte::page')

@section('content')

            <div class="panel panel-success">
                <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-4">
                            <button onclick="goBack()" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i> Back</button>
                        </div>
                        <div class="col-md-4">
                            <strong>Create New Sicknote Letter</strong>
                        </div>
                        <div class="col-md-4">
                            {{-- <a href="{{route('sicknotes.create')}}" class="btn btn-sm btn-primary">Create New sicknote</a> --}}
                        </div>
                    </div>
                </div>

                <div class="panel-body">
  
                        <form action="{{route('sicknotes.update', $note->id)}}" method="post">
                                {{csrf_field()}} {{method_field('PUT')}}

                                {{-- <div class="row" style="padding-left: 1%; padding-right: 1%;">
                                    <label>Assign Company</label>
                                    <select name="company_id" id="company_id">
                                        @foreach ($companies as $company)
                                            <option value="{{$company->id}}"
                                                @if ($company->id == $note->company_id)
                                                    selected
                                                @endif>{{$company->name}}</option>                                            
                                        @endforeach
                                    </select>
                                </div><br> --}}

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sicknote Name</label>
                                            <input type="text" name="name" value="{{$note->name}}" class="form-control" placeholder="Enter sicknote Name...">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Related Patient</label>
                                            <select name="user_id" id="patient_id" class="form-control">
                                                @foreach ($users as $user)
                                                    <option value="{{$user->id}}"
                                                        @if ($user->id == $note->user_id)
                                                            selected
                                                        @endif>{{$user->firstname}} {{$user->lastname}} - 
                                                               NHS : {{$user->nhs_number}} - 
                                                               DOB : {{$user->date_of_birth}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                               <div class="row" style="padding: 1%;">
                                    <div class="form-group">
                                        <label>Sicknote Body</label>
                                        <textarea name="body" class="form-control" id="description" placeholder="Enter Sicknote Body...">
                                            {{$note->body}}
                                        </textarea>
                                    </div>
                               </div>
                               <hr>
                                <div class="form-group">
                                    <input type="submit" value="Update Sicknote" class="btn btn-sm btn-block btn-success">
                                </div>
                            </form>
                </div>
            </div>
    
@endsection

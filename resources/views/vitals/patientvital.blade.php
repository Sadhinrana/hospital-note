@extends('adminlte::page')

@section('content')

            <div class="panel panel-success">
                <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-4">
                            <button onclick="goBack()" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i> Back</button>
                        </div>
                        <div class="col-md-4">
                        <strong>Create Vitals Note for {{$user->firstname}} {{$user->lastname}}</strong>
                        </div>
                        <div class="col-md-4">
                            {{-- <a href="{{route('roles.create')}}" class="btn btn-sm btn-primary">Create New Role</a> --}}
                        </div>
                    </div>
                </div>

                <div class="panel-body">

                    <form action="{{route('patient_store_vital.store')}}" method="post">
                            @include('inc.tabMenu', ['tabMenuPosition' => 1, 'patient_id' => $user->id])
                                {{csrf_field()}}

                        <input type="hidden" name="user_id" value="{{$user->id}}">

                        <div style="padding: 1%;">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                            <label>Patient Name</label>
                                            <select name="user_id" id="patient_id" class="form-control" disabled>
                                                    <option value="{{$user->id}}">
                                                            DOB : {{$user->date_of_birth}} -
                                                            {{$user->firstname}} {{$user->lastname}}
                                                            NHS : {{$user->nhs_number}}
                                                    </option>
                                            </select>
                                        </div>
                                </div>

                                <div class="col-md-4">
                                   <div class="form-group">
                                       <label>Height</label>
                                       <input type="text" name="height" value="{{old('height')}}" class="form-control" placeholder="Enter height...">
                                   </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                       <label>Weight</label>
                                       <input type="text" name="weight" value="{{old('weight')}}" class="form-control" placeholder="Enter weight...">
                                   </div>
                                </div>

                            </div><hr>

                            <div class="row">
                                <div class="col-md-4">
                                   <div class="form-group">
                                       <label>Temperature</label>
                                       <input type="text" name="temperature" value="{{old('temperature')}}" class="form-control" placeholder="Enter temperature...">
                                   </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                       <label>Pulse Rate</label>
                                       <input type="text" name="pulse_rate" value="{{old('pulse_rate')}}" class="form-control" placeholder="Enter Pulse Rate...">
                                   </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                       <label>Systolic BP</label>
                                       <input type="text" name="systolic_bp" value="{{old('systolic_bp')}}" class="form-control" placeholder="Enter Systolic BP...">
                                   </div>
                                </div>
                            </div><hr>

                            <div class="row">
                                <div class="col-md-4">
                                   <div class="form-group">
                                       <label>Diastolic BP</label>
                                       <input type="text" name="diastolic_bp" value="{{old('diastolic_bp')}}" class="form-control" placeholder="Enter Diastolic BP...">
                                   </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                       <label>Respiratory Rate</label>
                                       <input type="text" name="respiratory_rate" value="{{old('respiratory_rate')}}" class="form-control" placeholder="Enter Respiratory Rate...">
                                   </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                       <label>Oxygen Saturation</label>
                                       <input type="text" name="oxygen_saturation" value="{{old('oxygen_saturation')}}" class="form-control" placeholder="Enter Oxygen Saturation...">
                                   </div>
                                </div>
                            </div><hr>

                            <div class="row">
                                <div class="col-md-4">
                                   <div class="form-group">
                                       <label>O2 Administered</label>
                                       <input type="text" name="o2_administered" value="{{old('o2_administered')}}" class="form-control" placeholder="Enter O2 Administered...">
                                   </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                       <label>Pain</label>
                                       <input type="text" name="pain" value="{{old('pain')}}" class="form-control" placeholder="Enter pain...">
                                   </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                       <label>Head Circumference</label>
                                       <input type="text" name="head_circumference" value="{{old('head_circumference')}}" class="form-control" placeholder="Enter Head Circumference...">
                                   </div>
                                </div>
                            </div><hr>

                            <div class="hidden">
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="status">Save as draft
                                </label>
                            </div>
                            <hr>
                            <button type="submit" onclick="document.querySelector('input[name=status]').checked = true;" class="btn btn-warning btn-sm">Save as draft</button>
                            <button type="submit" class="btn btn-danger btn-sm">Save as final</button>
                        </div>
                    </form>

                </div>
            </div>

@endsection

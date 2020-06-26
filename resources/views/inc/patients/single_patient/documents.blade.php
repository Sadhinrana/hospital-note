<style>
    .collapse.in, .collapse{
        height: 100% !important;
        width: 100% !important;
        /*width: 530px !important;*/
        /*overflow-y: scroll;*/
        /* max-height:200px; */
    }
</style>
<table class="table table-hover">
    <tr class="active">
        <th width="50%">
            <h4><strong>Patient's Documents</strong></h4>
        </th>
        <th>
            <a href="{{route('patientdocument.create', $patient->id)}}" class="btn btn-success btn-sm no-print pull-right"> Add Document</a>
        </th>
    </tr>
</table>

@if (count($patient->files) > 0)
    <table class="table table-bordered" id="documents_table" style="width: 100%">
        <thead>
        <tr>
            <th width="60%">File Name</th>
            <th width="20%">Created By</th>
            <th width="20%">Created On</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($patient->files as $file)
            <tr>
                <td>
                    <a data-toggle="collapse" href="#collapseFile{{$file->id}}" aria-expanded="false" aria-controls="collapseExample">
                        {{$file->name}}</a>

                    <a href="../storage/{{$file->filename}}" target="_blank" class="pull-right">
                        <i class="fa fa-external-link-alt"></i>
                    </a>

                    <div class="collapse" id="collapseFile{{$file->id}}"  >
                        <div class="mt-5">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>{{$file->name}}</strong>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{route('files.edit', $file->id)}}">Click To Edit File Details</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <strong>Patient Name : </strong> {{$file->user->firstname}} {{$file->user->lastname}}
                                                </li>
                                                <li class="list-group-item">
                                                    <strong>Created On : </strong> {{$file->created_at->format('g:i A D jS, M, Y')}}
                                                </li>

                                                <li class="list-group-item">
                                                    <strong>Created By : </strong> {{$file->creator->firstname}} {{$file->creator->lastname}}
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-md-8">
                                            @if (@is_array(getimagesize('storage/'.$file->filename)))
                                                <img src="{{asset('storage/'.$file->filename)}}" alt="file" width="500" height="350">
                                            @else
                                                <a href="{{asset('storage/'.$file->filename)}}" target="_blank">Document (Click to download)</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    {{$file->created_at->format('D jS, M, Y')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>{{$file->creator ? $file->creator->firstname .' '. $file->creator->lastname : ''}}</td>
                <td>{{$file->created_at->format('g:i A D jS, M, Y')}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    Patient has No documents yet.
@endif

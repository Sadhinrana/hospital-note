<div v-show="renderForm === 2 && reportRender == 0">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Claimant
                <small class="pull-right">Date: {{date('D, d, M, Y, H:i:s')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>

    {{--    select patient start--}}
    @if(auth()->user() && auth()->user()->role_id != 5)
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Select Patient</label>
                    <select v-model="reportData.claimant.patient_id" v-on:change="selectPatient()" class="form-control select2" v-select2>
                        <option :value="'N/A'">N/A</option>
                        <option :value="patient.id" v-for="patient of patients">@{{ patient.cap_title }} @{{ patient.firstname }} @{{ patient.lastname }}</option>
                    </select>
                </div>
            </div>
        </div>
    @endif
    {{--select patient end--}}
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Title</label>
                <select class="form-control select2" v-model="reportData.claimant.title" v-select2>
                    <option :value="title.value" v-for="title in titles"> @{{ title.label }}</option>
                    <option :value="reportData.claimant.title" v-if="reportData.claimant.title !== '' && placeOfExam.some(e => e.value === reportData.claimant.title) === false">
                        @{{ reportData.claimant.title }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" class="form-control" placeholder="First Name" v-model="reportData.claimant.firstName">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" placeholder="Last Name" v-model="reportData.claimant.lastName">
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Gender</label>
                <select class="form-control select2" v-model="reportData.claimant.gender" v-select2>
                    <option :value="g.value" v-for="g in gender"> @{{ g.label }}</option>
                    <option :value="reportData.claimant.gender" v-if="reportData.claimant.gender !== '' && gender.some(e => e.value === reportData.claimant.gender) === false">
                        @{{ reportData.claimant.gender }}
                    </option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Domestic Status</label>
                <select class="form-control select2" v-model="reportData.claimant.domesticStatus" v-select2>
                    <option :value="domesticStatus" v-for="domesticStatus in domesticStatusList"> @{{ domesticStatus }}</option>
                    <option :value="reportData.claimant.domesticStatus"
                            v-if="reportData.claimant.domesticStatus !== '' && domesticStatusList.indexOf(reportData.claimant.domesticStatus) < 0"> @{{
                        reportData.claimant.domesticStatus }}
                    </option>
                </select>
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>DOB</label>
                <input type="date" class="form-control flatpickr" id="dob" v-model="reportData.claimant.dob">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label> Handed</label>
                <select class="form-control select2" v-model="reportData.claimant.handed" v-select2>
                    <option :value="hand.value" v-for="hand in handed"> @{{ hand.label }}</option>
                    <option :value="reportData.claimant.handed" v-if="reportData.claimant.handed !== '' && handed.some(e => e.value === reportData.claimant.handed) === false"> @{{
                        reportData.claimant.handed }}
                    </option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" placeholder="Address" v-model="reportData.claimant.address">
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Town</label>
                <input type="text" class="form-control" placeholder="Town" v-model="reportData.claimant.city">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Country</label>
                <input type="text" class="form-control" placeholder="Country" v-model="reportData.claimant.country">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Postcode</label>
                <input type="text" class="form-control" placeholder="Postcode" v-model="reportData.claimant.postcode">
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Job</label>
                <select class="form-control select2" v-model="reportData.claimant.job" v-select2>
                    <option :value="job" v-for="job in jobs"> @{{ job }}</option>
                    <option :value="reportData.claimant.job" v-if="reportData.claimant.job !== '' && jobs.indexOf(reportData.claimant.job) < 0"> @{{ reportData.claimant.job }}
                    </option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Poof of Identity</label>
                <select class="form-control select2" v-model="reportData.claimant.id" v-select2>
                    <option :value="pId" v-for="pId in ids"> @{{ pId }}</option>
                    <option :value="reportData.claimant.id" v-if="reportData.claimant.id !== '' && ids.indexOf(reportData.claimant.id) < 0"> @{{ reportData.claimant.id }}</option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Sickness Record</label>
                <textarea class="form-control" v-model="reportData.claimant.sicknessRecord"></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Job/Educational Status</label>
                <select class="form-control select2" v-model="reportData.claimant.jobEductionStatus" v-select2>
                    <option :value="jobEduction" v-for="jobEduction in jobEductionStatusList"> @{{ jobEduction }}</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div v-show="renderForm === 1 && reportRender == 0">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Admin
                <small class="pull-right">Date: {{date('D, d, M, Y, H:i:s')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>

    <!-- Table row -->
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>GP records</label>
                <select class="form-control select2" v-model="reportData.admin.gpRecord" v-select2>
                    <option value="Yes"> Yes</option>
                    <option value="No"> No</option>
                    <option :value="reportData.admin.gpRecord" v-if="reportData.admin.gpRecord !== '' && ['Yes', 'No'].indexOf(reportData.admin.gpRecord) < 0"> @{{ reportData.admin.gpRecord }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Hospital records</label>
                <select class="form-control select2" v-model="reportData.admin.hospitalRecords" v-select2>
                    <option value="Yes"> Yes</option>
                    <option value="No"> No</option>
                    <option :value="reportData.admin.hospitalRecords" v-if="reportData.admin.hospitalRecords !== '' && ['Yes', 'No'].indexOf(reportData.admin.hospitalRecords) < 0"> @{{ reportData.admin.hospitalRecords }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Rehabilitation Records</label>
                <select class="form-control select2" v-model="reportData.admin.rehabilitationRecords" v-select2>
                    <option value="Yes"> Yes</option>
                    <option value="No"> No</option>
                    <option :value="reportData.admin.rehabilitationRecords" v-if="reportData.admin.rehabilitationRecords !== '' && ['Yes', 'No'].indexOf(reportData.admin.rehabilitationRecords) < 0"> @{{ reportData.admin.rehabilitationRecords }}</option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Date of examination</label>
                <input type="text" class="form-control flatpickr" v-model="reportData.admin.dateOfExam">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Date of report</label>
                <input type="text" class="form-control flatpickr" v-model="reportData.admin.dateOfReport">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>MedCo Case ID</label>
                <input type="text" class="form-control" placeholder="MedCo Case ID" v-model="reportData.admin.medcoId">
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Case reference</label>
                <input type="text" class="form-control" placeholder="Case reference" v-model="reportData.admin.caseRef">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label> Accompanied by</label>
                <select class="form-control select2" v-model="reportData.admin.accompaniedBy" v-select2>
                    <option :value="accompanied" v-for="accompanied in accompaniedByList"> @{{ accompanied }} </option>
                    <option :value="reportData.admin.accompaniedBy" v-if="reportData.admin.accompaniedBy !== '' && accompaniedByList.indexOf(reportData.admin.accompaniedBy) < 0"> @{{ reportData.admin.accompaniedBy }} </option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Duration of examination</label>
                <select class="form-control select2" v-model="reportData.admin.durationOfExamination" v-select2>
                    <option :value="duration" v-for="duration in durationOfExaminationList"> @{{ duration }} </option>
                    <option :value="reportData.admin.durationOfExamination" v-if="durationOfExaminationList.indexOf(reportData.admin.durationOfExamination) < 0"> @{{ reportData.admin.durationOfExamination }} </option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Primary Referrer Name</label>
                <input type="text" class="form-control" placeholder="Primary Referrer Name" v-model="reportData.admin.primaryReferrerName">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Instructing party reference</label>
                <input type="text" class="form-control" placeholder="Instructing party reference" v-model="reportData.admin.instructingPartyRef">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Place of examination / Report Type</label>
                <select class="form-control select2" v-model="reportData.admin.placeOfExam" v-select2>
                    <option :value="place" v-for="place in placeOfExam"> @{{ place }} </option>
                    <option :value="reportData.admin.placeOfExam" v-if="reportData.admin.placeOfExam !== '' && placeOfExam.indexOf(reportData.admin.placeOfExam) < 0"> @{{ reportData.admin.placeOfExam }} </option>

                </select>
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Agreement of report</label>
                <textarea name="description" class="form-control" v-model="reportData.admin.agreementOfReport"></textarea>
            </div>
        </div>
    </div>
    <!-- /.col -->
</div>

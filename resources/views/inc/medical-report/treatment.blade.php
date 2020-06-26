<div v-show="renderForm === 4 && reportRender == 0">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Treatment
                <small class="pull-right">Date: {{date('D, d, M, Y, H:i:s')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Out of hours visits</label>
                <select class="form-control select2" v-model="reportData.treatment.hospitalVisits" v-select2>
                    <option :value="hours" v-for="hours in hospitalVisits"> @{{ hours }} </option>
                    <option :value="reportData.treatment.hospitalVisits" v-if="reportData.treatment.hospitalVisits !== '' && hospitalVisits.indexOf(reportData.treatment.hospitalVisits) < 0"> @{{ reportData.treatment.hospitalVisits }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Hospital/Consultant Visits</label>
                <select class="form-control select2" v-model="reportData.treatment.consultantVisits" v-select2>
                    <option :value="visit" v-for="visit in hospitalVisits"> @{{ visit }} </option>
                    <option :value="reportData.treatment.consultantVisits" v-if="reportData.treatment.consultantVisits !== '' && hospitalVisits.indexOf(reportData.treatment.consultantVisits) < 0"> @{{ reportData.treatment.consultantVisits }}</option>
                </select>
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Accident & Emergency visits</label>
                <select class="form-control select2" v-model="reportData.treatment.aeVisits" v-select2>
                    <option :value="eVisit" v-for="eVisit in hospitalVisits"> @{{ eVisit }} </option>
                    <option :value="reportData.treatment.aeVisits" v-if="reportData.treatment.aeVisits !== '' && hospitalVisits.indexOf(reportData.treatment.aeVisits) < 0"> @{{ reportData.treatment.aeVisits }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Primary Care Visits</label>
                <select class="form-control select2" v-model="reportData.treatment.primaryCareVisits" v-select2>
                    <option :value="pVisit" v-for="pVisit in hospitalVisits"> @{{ pVisit }} </option>
                    <option :value="reportData.treatment.primaryCareVisits" v-if="reportData.treatment.primaryCareVisits !== '' && hospitalVisits.indexOf(reportData.treatment.primaryCareVisits) < 0"> @{{ reportData.treatment.primaryCareVisits }}</option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Hospital</label>
                <select class="form-control select2" v-model="reportData.treatment.hospital" v-select2>
                    <option :value="hospital" v-for="hospital in hospitals"> @{{ hospital }} </option>
                    <option :value="reportData.treatment.hospital" v-if="reportData.treatment.hospital !== '' && hospitals.indexOf(reportData.treatment.hospital) < 0"> @{{ reportData.treatment.hospital }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Rehab session</label>
                <select class="form-control select2" v-model="reportData.treatment.furtherTreatment" v-select2>
                    <option :value="session" v-for="session in hospitalVisits"> @{{ session }} </option>
                    <option :value="reportData.treatment.furtherTreatment" v-if="reportData.treatment.furtherTreatment !== '' && hospitalVisits.indexOf(reportData.treatment.furtherTreatment) < 0"> @{{ reportData.treatment.furtherTreatment }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Rehabilitation provider</label>
                <select class="form-control select2" v-model="reportData.treatment.rehabProvider" v-select2>
                    <option :value="rlist" v-for="rlist in rehabProviderList"> @{{ rlist }} </option>
                    <option :value="reportData.treatment.rehabProvider" v-if="reportData.treatment.rehabProvider !== '' && rehabProviderList.indexOf(reportData.treatment.rehabProvider) < 0"> @{{ reportData.treatment.rehabProvider }}</option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Home exercise</label>
                <select class="form-control select2" v-model="reportData.treatment.homeExercise" v-select2>
                    <option :value="exercise" v-for="exercise in HomeExercise"> @{{ exercise }} </option>
                    <option :value="reportData.treatment.homeExercise" v-if="reportData.treatment.homeExercise !== '' && HomeExercise.indexOf(reportData.treatment.homeExercise) < 0"> @{{ reportData.treatment.homeExercise }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Medication</label>
                <select class="form-control select2" v-model="reportData.treatment.medication" v-select2>
                    <option :value="medi" v-for="medi in medication"> @{{ medi }} </option>
                    <option :value="reportData.treatment.medication" v-if="reportData.treatment.medication !== '' && medication.indexOf(reportData.treatment.medication) < 0"> @{{ reportData.treatment.medication }}</option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label> Immediate Medical Attendance</label>
                <select class="form-control select2" v-model="reportData.treatment.immediateTreatment" v-select2>
                    <option :value="tList" v-for="tList in immediateTreatmentList"> @{{ tList }} </option>
                    <option :value="reportData.treatment.immediateTreatment" v-if="reportData.treatment.immediateTreatment !== '' && immediateTreatmentList.indexOf(reportData.treatment.immediateTreatment) < 0"> @{{ reportData.treatment.immediateTreatment }}</option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label> Treatment description </label>
                <select class="form-control select2" v-model="reportData.treatment.treatmentDescription" v-select2>
                    <option :value="description" v-for="description in treatmentDescription"> @{{ description }} </option>
                    <option :value="reportData.treatment.treatmentDescription" v-if="reportData.treatment.treatmentDescription !== '' && treatmentDescription.indexOf(reportData.treatment.treatmentDescription) < 0"> @{{ reportData.treatment.treatmentDescription }}</option>
                </select>
            </div>
        </div>
    </div>
</div>

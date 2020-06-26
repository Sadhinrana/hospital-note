<div v-show="renderForm === 13 && reportRender == 0">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i>Future
                <small class="pull-right">Date: {{date('D, d, M, Y, H:i:s')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Investigations</label>
                <select class="form-control select2" v-select2 v-model="reportData.future.investigations">
                    <option :value="investigation" v-for="investigation in investigationsList"> @{{ investigation }} </option>
                    <option :value="reportData.future.investigations" v-if="reportData.future.investigations !== '' && investigationsList.indexOf(reportData.future.investigations) < 0"> @{{ reportData.future.investigations }} </option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Long term sequelae</label>
                <select class="form-control select2" v-select2 v-model="reportData.future.longTermSequelae">
                    <option :value="term" v-for="term in longTermSequelaeList"> @{{ term }} </option>
                    <option :value="reportData.future.longTermSequelae" v-if="reportData.future.longTermSequelae !== '' && longTermSequelaeList.indexOf(reportData.future.longTermSequelae) < 0"> @{{ reportData.future.longTermSequelae }} </option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Other comments</label>
                <select class="form-control select2" v-select2 v-model="reportData.future.otherComments">
                    <option value="N/A">N/A</option>
                    <option value="In my opinion and on the balance of probabilities, I would confirm that the incapacities claimed, treatments received and consequential losses described are consistent with the index accident.">In my opinion and on the balance of probabilities, I would confirm that the incapacities claimed, treatments received and consequential losses described are consistent with the index accident.</option>
                    <option :value="reportData.future.otherComments" v-if="reportData.future.otherComments !== '' && ['In my opinion and on the balance of probabilities, I would confirm that the incapacities claimed, treatments received and consequential losses described are consistent with the index accident.'].indexOf(reportData.future.otherComments) < 0"> @{{ reportData.future.otherComments }} </option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Future Job Prospects</label>
                <select class="form-control select2" v-select2 v-model="reportData.future.jobProspects">
                    <option :value="fJob" v-for="fJob in futureJobProspectsList"> @{{ fJob }} </option>
                    <option :value="reportData.future.jobProspects" v-if="reportData.future.jobProspects !== '' && futureJobProspectsList.indexOf(reportData.future.jobProspects) < 0"> @{{ reportData.future.jobProspects }} </option>
                </select>
            </div>
        </div>
    </div>
</div>

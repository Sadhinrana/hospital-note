<div v-show="renderForm === 7 && reportRender == 0">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Other injuries
                <small class="pull-right">Date: {{date('D, d, M, Y, H:i:s')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <div v-for="(injury, index) in reportData.otherInjuries">
        <div class="row">
            <div class="col-md-6">
                <h2> Injuiry @{{ index+1 }} </h2>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-danger" @click="removeInjuries(index)">&times;</button>
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Other injury</label>
                    <select class="form-control select2" v-select2 v-model="injury.other_injury">
                        <option :value="reportData.otherInjuries[index].other_injury" v-if="reportData.otherInjuries[index].other_injury !== ''"> @{{ reportData.otherInjuries[index].other_injury }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Current Status</label>
                    <select class="form-control select2" v-select2 v-model="injury.current_status">
                        <option :value="status" v-for="status in otherInjiryStatusList"> @{{ status }} </option>
                        <option :value="reportData.otherInjuries[index].current_status" v-if="reportData.otherInjuries[index].current_status !== '' && otherInjiryStatusList.indexOf(reportData.otherInjuries[index].current_status) < 0"> @{{ reportData.otherInjuries[index].current_status }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> onset</label>
                    <select class="form-control select2" v-select2 v-model="injury.onset">
                        <option :value="oOnset" v-for="oOnset in onsetDaysAfter"> @{{ oOnset }} </option>
                        <option :value="reportData.otherInjuries[index].onset" v-if="reportData.otherInjuries[index].onset !== '' && onsetDaysAfter.indexOf(reportData.otherInjuries[index].onset) < 0"> @{{ reportData.otherInjuries[index].onset }} </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Intensity</label>
                    <select class="form-control select2" v-select2 v-model="injury.intensity">
                        <option :value="oSeverity.value" v-for="oSeverity in severityList"> @{{ oSeverity.label }} </option>
                        <option :value="reportData.otherInjuries[index].intensity" v-if="reportData.otherInjuries[index].intensity !== '' && severityList.some(e => e.value === reportData.otherInjuries[index].intensity) === false"> @{{ reportData.otherInjuries[index].intensity }} </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Initial Treatment less than 24hrs</label>
                    <select class="form-control select2" v-select2 v-model="injury.initial_treatment">
                        <option :value="initial" v-for="initial in initialTreatmentList"> @{{ initial }} </option>
                        <option :value="reportData.otherInjuries[index].initial_treatment" v-if="reportData.otherInjuries[index].initial_treatment !== '' && initialTreatmentList.indexOf(reportData.otherInjuries[index].initial_treatment) < 0"> @{{ reportData.otherInjuries[index].initial_treatment }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> Subsequent Tx</label>
                    <select class="form-control select2" v-select2 v-model="injury.subsequent_tx">
                        <option :value="subsequent" v-for="subsequent in subsequentTxList"> @{{ subsequent }} </option>
                        <option :value="reportData.otherInjuries[index].subsequent_tx" v-if="reportData.otherInjuries[index].subsequent_tx !== '' && subsequentTxList.indexOf(reportData.otherInjuries[index].subsequent_tx) < 0"> @{{ reportData.otherInjuries[index].subsequent_tx }} </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 text-right">
            <button type="button" class="btn btn-primary" @click="addInjuries">Add Another</button>
        </div>
    </div>
</div>

<div v-show="renderForm === 9 && reportRender == 0">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Psychological Symptoms
                <small class="pull-right">Date: {{date('D, d, M, Y, H:i:s')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Psych Symptoms</label>
                <select class="form-control select2" v-select2 v-model="reportData.anxity.symptoms">
                    <option value="Yes"> Yes </option>
                    <option value="No"> No </option>
                    <option value="N/A"> N/A </option>
                    <option :value="reportData.anxity.symptoms" v-if="reportData.anxity.symptoms !== '' && ['Yes', 'No', 'N/A'].indexOf(reportData.anxity.symptoms) < 0"> @{{ reportData.anxity.symptoms }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6" v-if="reportData.anxity.symptoms == 'Yes'">
            <div class="form-group">
                <label>Onset in days after</label>
                <select class="form-control select2" v-select2 v-model="reportData.anxity.onsetDaysAfter">
                    <option :value="aOnset" v-for="aOnset in onsetDaysAfter"> @{{ aOnset }} </option>
                    <option :value="reportData.anxity.onsetDaysAfter" v-if="reportData.anxity.onsetDaysAfter !== '' && onsetDaysAfter.indexOf(reportData.anxity.onsetDaysAfter) < 0"> @{{ reportData.anxity.onsetDaysAfter }} </option>
                </select>
            </div>
        </div>
    </div>
    <section v-if="reportData.anxity.symptoms == 'Yes'">
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Intensity</label>
                    <select class="form-control select2" v-select2 v-model="reportData.anxity.intensity">
                        <option :value="intensity.value" v-for="intensity in severityList"> @{{ intensity.label }} </option>
                        <option :value="reportData.anxity.intensity" v-if="reportData.anxity.intensity !== '' && severityList.some(e => e.value === reportData.anxity.intensity) === false"> @{{ reportData.anxity.intensity }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Symptoms</label>
                    <select class="form-control select2" v-select2 v-model="reportData.anxity.symptomsDescription">
                        <option :value="aSymptoms" v-for="aSymptoms in anxitySymptomsList"> @{{ aSymptoms }} </option>
                        <option :value="reportData.anxity.symptomsDescription" v-if="reportData.anxity.symptomsDescription !== '' && anxitySymptomsList.indexOf(reportData.anxity.symptomsDescription) < 0"> @{{ reportData.anxity.symptomsDescription }} </option>
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Manifest as</label>
                    <select class="form-control select2" v-select2 v-model="reportData.anxity.manifestAs" multiple>
                        <option :value="anxity" v-for="anxity in anxityList"> @{{ anxity }} </option>
                        <option :value="e" v-for="e in reportData.anxity.manifestAs" v-if="reportData.anxity.manifestAs !== '' && anxityList.indexOf(e) < 0"> @{{ e }} </option>
                    </select>
                </div>
            </div>
        </div>
    </section>

</div>

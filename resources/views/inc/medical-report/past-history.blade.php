<div v-show="renderForm === 8 && reportRender == 0">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Past Medical & Accident History
                <small class="pull-right">Date: {{date('D, d, M, Y, H:i:s')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Previous Medical History?</label>
                <select class="form-control select2" v-select2 v-model="reportData.history.medical_history">
                    <option value="Yes"> Yes </option>
                    <option value="No"> No </option>
                    <option :value="reportData.history.medical_history" v-if="reportData.history.medical_history !== '' && ['Yes', 'No'].indexOf(reportData.history.medical_history) < 0"> @{{ reportData.history.medical_history }}</option>
                </select>
            </div>
        </div>
    </div>
    <div v-if="reportData.history.medical_history === 'Yes'" v-for="(medical_history, index) in reportData.history.medical_histories">
        <div class="row">
            <div class="col-md-6">
                <h2> Medical history @{{ index+1 }} </h2>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-danger" @click="removeMedicalHistory(index)">&times;</button>
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Injury/Symptom</label>
                    <input type="text" class="form-control" v-model="medical_history.medical_history_symptom">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Progress of symptoms?</label>
                    <select class="form-control select2" v-select2 v-model="medical_history.progress">
                        <option value="Resolved">Resolved</option>
                        <option value="On-going">On-going</option>
                        <option :value="reportData.history.medical_histories[index].progress" v-if="reportData.history.medical_histories[index].progress !== '' && ['Resolved', 'On-going'].indexOf(reportData.history.medical_histories[index].progress) < 0"> @{{ reportData.history.medical_histories[index].progress }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>At time of accident?</label>
                    <select class="form-control select2" v-select2 v-model="medical_history.accident">
                        <option value="This was symptomatic at the time of the accident.">This was symptomatic at the time of the accident.</option>
                        <option value="This was asymptomatic at the time of the accident.">This was asymptomatic at the time of the accident.</option>
                        <option :value="reportData.history.medical_histories[index].accident" v-if="reportData.history.medical_histories[index].accident !== '' && ['This was symptomatic at the time of the accident.', 'This was asymptomatic at the time of the accident.'].indexOf(reportData.history.medical_histories[index].accident) < 0"> @{{ reportData.history.medical_histories[index].accident }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Aggravation</label>
                    <select class="form-control select2" v-select2 v-model="medical_history.aggravation">
                        <option value="The pre-existing condition was aggravated by this incident.">The pre-existing condition was aggravated by this incident.</option>
                        <option value="The pre-existing condition was not aggravated by this incident.">The pre-existing condition was not aggravated by this incident.</option>
                        <option :value="reportData.history.medical_histories[index].aggravation" v-if="reportData.history.medical_histories[index].aggravation !== '' && ['The pre-existing condition was aggravated by this incident.', 'The pre-existing condition was not aggravated by this incident.'].indexOf(reportData.history.medical_histories[index].aggravation) < 0"> @{{ reportData.history.medical_histories[index].aggravation }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>% attributable to the index event.</label>
                    <select class="form-control select2" v-select2 v-model="medical_history.attributable">
                        <option value="In my opinion 0% of the described ongoing symptoms can be attributed to the index accident and the remainder to the pre-existing condition. In my opinion the client will return back to the pre-index accident level of discomfort within the timescale I have indicated.">In my opinion 0% of the described ongoing symptoms can be attributed to the index accident and the remainder to the pre-existing condition. In my opinion the client will return back to the pre-index accident level of discomfort within the timescale I have indicated.</option>
                        <option value="In my opinion 10% of the described ongoing symptoms can be attributed to the index accident and the remainder to the pre-existing condition. In my opinion the client will return back to the pre-index accident level of discomfort within the timescale I have indicated.">In my opinion 10% of the described ongoing symptoms can be attributed to the index accident and the remainder to the pre-existing condition. In my opinion the client will return back to the pre-index accident level of discomfort within the timescale I have indicated.</option>
                        <option :value="reportData.history.medical_histories[index].attributable" v-if="reportData.history.medical_histories[index].attributable !== '' && ['In my opinion 0% of the described ongoing symptoms can be attributed to the index accident and the remainder to the pre-existing condition. In my opinion the client will return back to the pre-index accident level of discomfort within the timescale I have indicated.', 'In my opinion 10% of the described ongoing symptoms can be attributed to the index accident and the remainder to the pre-existing condition. In my opinion the client will return back to the pre-index accident level of discomfort within the timescale I have indicated.'].indexOf(reportData.history.medical_histories[index].attributable) < 0"> @{{ reportData.history.medical_histories[index].attributable }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-if="reportData.history.medical_history === 'Yes'">
        <div class="col-md-6"></div>
        <div class="col-md-6 text-right">
            <button type="button" class="btn btn-primary" @click="addMedicalHistory">Add Another</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Previous Accident History?</label>
                <select class="form-control select2" v-select2 v-model="reportData.history.accident_history">
                    <option value="Yes"> Yes </option>
                    <option value="No"> No </option>
                    <option :value="reportData.history.accident_history" v-if="reportData.history.accident_history !== '' && ['Yes', 'No'].indexOf(reportData.history.accident_history) < 0"> @{{ reportData.history.accident_history }}</option>
                </select>
            </div>
        </div>
    </div>
    <div v-if="reportData.history.accident_history === 'Yes'" v-for="(accident_history, index) in reportData.history.accident_histories">
        <div class="row">
            <div class="col-md-6">
                <h2> Accident history @{{ index+1 }} </h2>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-danger" @click="removeAccidentHistory(index)">&times;</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Date of accident</label>
                    <input type="date" class="form-control flatpickr" v-model="accident_history.date">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Type of Accident?</label>
                    <select class="form-control select2" v-select2 v-model="accident_history.type">
                        <option :value="type" v-for="type in accidentTypes">@{{ type }}</option>
                        <option :value="reportData.history.accident_histories[index].type" v-if="reportData.history.accident_histories[index].type !== '' && accidentTypes.indexOf(reportData.history.accident_histories[index].type) < 0"> @{{ reportData.history.accident_histories[index].type }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Injury/Symptom</label>
                    <input type="text" class="form-control" v-model="accident_history.symptom">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Progress of symptoms?</label>
                    <select class="form-control select2" v-select2 v-model="accident_history.progress">
                        <option value="Resolved">Resolved</option>
                        <option value="On-going">On-going</option>
                        <option :value="reportData.history.accident_histories[index].progress" v-if="reportData.history.accident_histories[index].progress !== '' && ['Resolved', 'On-going'].indexOf(reportData.history.accident_histories[index].progress) < 0"> @{{ reportData.history.accident_histories[index].progress }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>At time of accident?</label>
                    <select class="form-control select2" v-select2 v-model="accident_history.accident">
                        <option value="This was symptomatic at the time of the accident.">This was symptomatic at the time of the accident.</option>
                        <option value="This was asymptomatic at the time of the accident.">This was asymptomatic at the time of the accident.</option>
                        <option :value="reportData.history.accident_histories[index].accident" v-if="reportData.history.accident_histories[index].accident !== '' && ['This was symptomatic at the time of the accident.', 'This was asymptomatic at the time of the accident.'].indexOf(reportData.history.accident_histories[index].accident) < 0"> @{{ reportData.history.accident_histories[index].accident }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Aggravation</label>
                    <select class="form-control select2" v-select2 v-model="accident_history.aggravation">
                        <option value="The pre-existing condition was aggravated by this incident.">The pre-existing condition was aggravated by this incident.</option>
                        <option value="The pre-existing condition was not aggravated by this incident.">The pre-existing condition was not aggravated by this incident.</option>
                        <option :value="reportData.history.accident_histories[index].aggravation" v-if="reportData.history.accident_histories[index].aggravation !== '' && ['The pre-existing condition was aggravated by this incident.', 'The pre-existing condition was not aggravated by this incident.'].indexOf(reportData.history.accident_histories[index].aggravation) < 0"> @{{ reportData.history.accident_histories[index].aggravation }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>% attributable to the index event.</label>
                    <select class="form-control select2" v-select2 v-model="accident_history.attributable">
                        <option value="In my opinion 0% of the described ongoing symptoms can be attributed to the index accident and the remainder to the pre-existing condition. In my opinion the client will return back to the pre-index accident level of discomfort within the timescale I have indicated.">In my opinion 0% of the described ongoing symptoms can be attributed to the index accident and the remainder to the pre-existing condition. In my opinion the client will return back to the pre-index accident level of discomfort within the timescale I have indicated.</option>
                        <option value="In my opinion 10% of the described ongoing symptoms can be attributed to the index accident and the remainder to the pre-existing condition. In my opinion the client will return back to the pre-index accident level of discomfort within the timescale I have indicated.">In my opinion 10% of the described ongoing symptoms can be attributed to the index accident and the remainder to the pre-existing condition. In my opinion the client will return back to the pre-index accident level of discomfort within the timescale I have indicated.</option>
                        <option :value="reportData.history.accident_histories[index].attributable" v-if="reportData.history.accident_histories[index].attributable !== '' && ['In my opinion 0% of the described ongoing symptoms can be attributed to the index accident and the remainder to the pre-existing condition. In my opinion the client will return back to the pre-index accident level of discomfort within the timescale I have indicated.', 'In my opinion 10% of the described ongoing symptoms can be attributed to the index accident and the remainder to the pre-existing condition. In my opinion the client will return back to the pre-index accident level of discomfort within the timescale I have indicated.'].indexOf(reportData.history.accident_histories[index].attributable) < 0"> @{{ reportData.history.accident_histories[index].attributable }}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-if="reportData.history.accident_history === 'Yes'">
        <div class="col-md-6"></div>
        <div class="col-md-6 text-right">
            <button type="button" class="btn btn-primary" @click="addAccidentHistory">Add Another</button>
        </div>
    </div>
</div>

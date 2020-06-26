<div v-show="renderForm === 11 && reportRender == 0">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Examination
                <small class="pull-right">Date: {{date('D, d, M, Y, H:i:s')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>General</label>
                <select class="form-control select2" v-select2 v-model="reportData.examination.general">
                    <option :value="exam" v-for="exam in examinationGeneral"> @{{ exam }} </option>
                    <option :value="reportData.examination.general" v-if="reportData.examination.general !== '' && examinationGeneral.indexOf(reportData.examination.general) < 0"> @{{ reportData.examination.general }} </option>
                </select>
            </div>
        </div>
    </div>
    <div v-show="reportData.neck.painStiffness === 'Yes'">
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <h3>Neck Pain Opinion/Prognosis</h3>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Neck</label>
                    <select class="form-control select2" v-select2 v-model="reportData.examination.neck.value" @change="setNeckSettings">
                        <option :value="neck.value" v-for="neck in examinationNeck"> @{{ neck.label }} </option>
                        <option :value="reportData.examination.neck.value" v-if="reportData.examination.neck.value !== '' && examinationNeck.some(e => e.value === reportData.examination.neck.value) === false"> @{{ reportData.examination.neck.value }} </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Sagittal Flexion & Extension</label>
                    <select class="form-control select2" v-select2 v-model="reportData.examination.neck.settings.sfe">
                        <option :value="value" v-for="value in examinationDegree"> @{{ value }} </option>
                        <option :value="reportData.examination.neck.settings.sfe" v-if="reportData.examination.neck.settings.sfe !== '' && examinationDegree.indexOf(reportData.examination.neck.settings.sfe) < 0"> @{{ reportData.examination.neck.settings.sfe }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Right Lateral Rotation</label>
                    <select class="form-control select2" v-select2 v-model="reportData.examination.neck.settings.rlr">
                        <option :value="value" v-for="value in examinationDegree"> @{{ value }} </option>
                        <option :value="reportData.examination.neck.settings.rlr" v-if="reportData.examination.neck.settings.rlr !== '' && examinationGeneral.indexOf(reportData.examination.neck.settings.rlr) < 0"> @{{ reportData.examination.neck.settings.rlr }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Right Lateral Flexion</label>
                    <select class="form-control select2" v-select2 v-model="reportData.examination.neck.settings.rlf">
                        <option :value="value" v-for="value in examinationDegree"> @{{ value }} </option>
                        <option :value="reportData.examination.neck.settings.rlf" v-if="reportData.examination.neck.settings.rlf !== '' && examinationGeneral.indexOf(reportData.examination.neck.settings.rlf) < 0"> @{{ reportData.examination.neck.settings.rlf }} </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Left Lateral Rotation</label>
                    <select class="form-control select2" v-select2 v-model="reportData.examination.neck.settings.llr">
                        <option :value="value" v-for="value in examinationDegree"> @{{ value }} </option>
                        <option :value="reportData.examination.neck.settings.llr" v-if="reportData.examination.neck.settings.llr !== '' && examinationGeneral.indexOf(reportData.examination.neck.settings.llr) < 0"> @{{ reportData.examination.neck.settings.llr }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Left Lateral Flexion</label>
                    <select class="form-control select2" v-select2 v-model="reportData.examination.neck.settings.llf">
                        <option :value="value" v-for="value in examinationDegree"> @{{ value }} </option>
                        <option :value="reportData.examination.neck.settings.llf" v-if="reportData.examination.neck.settings.llf !== '' && examinationGeneral.indexOf(reportData.examination.neck.settings.llf) < 0"> @{{ reportData.examination.neck.settings.llf }} </option>
                    </select>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <div v-show="reportData.lowerBack.painStiffness === 'Yes'">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <h3>Back</h3>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <select class="form-control select2" v-select2 v-model="reportData.examination.back">
                        <option :value="exam" v-for="exam in examinationBackList"> @{{ exam }} </option>
                        <option :value="reportData.examination.back" v-if="reportData.examination.back !== '' && examinationBackList.indexOf(reportData.examination.back) < 0"> @{{ reportData.examination.back }} </option>
                    </select>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <div v-show="reportData.anxity.symptoms === 'Yes'">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <h3>Psychological</h3>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <select class="form-control select2" v-select2 v-model="reportData.examination.psychological">
                        <option :value="examination" v-for="examination in examinationPsych"> @{{ examination }} </option>
                        <option :value="reportData.examination.psychological" v-if="reportData.examination.psychological !== '' && examinationPsych.indexOf(reportData.examination.psychological) < 0"> @{{ reportData.examination.psychological }} </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-for="(injury, index) in reportData.otherInjuries">
        <div class="col-md-12">
            <div class="form-group">
                <h3>@{{ reportData.otherInjuries[index].other_injury }}</h3>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Examination</label>
                <select class="form-control select2" v-select2 v-model="injury.examination">
                    <option :value="examination" v-for="examination in examinationOtherList"> @{{ examination }} </option>
                    <option :value="reportData.otherInjuries[index].examination" v-if="reportData.otherInjuries[index].examination !== '' && examinationOtherList.indexOf(reportData.otherInjuries[index].examination) < 0"> @{{ reportData.otherInjuries[index].examination }} </option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <h3>Soft tissue injury claim</h3>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Was the Claimant an occupant of a motor vehicle?</label>
                <select class="form-control select2" v-select2 v-model="reportData.examination.occupantOfVehicle">
                    <option value="Yes"> Yes </option>
                    <option value="No"> No</option>
                    <option :value="reportData.examination.occupantOfVehicle" v-if="reportData.examination.occupantOfVehicle !== '' && ['Yes', 'No'].indexOf(reportData.examination.occupantOfVehicle) < 0"> @{{ reportData.examination.occupantOfVehicle }}</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Does this case fall into the definition of a soft tissue injury?</label>
                <select class="form-control select2" v-select2 v-model="reportData.examination.softTissueInjury">
                    <option value="Yes"> Yes </option>
                    <option value="No"> No</option>
                    <option :value="reportData.examination.softTissueInjury" v-if="reportData.examination.softTissueInjury !== '' && ['Yes', 'No'].indexOf(reportData.examination.softTissueInjury) < 0"> @{{ reportData.examination.softTissueInjury }}</option>
                </select>
            </div>
        </div>
    </div>
</div>

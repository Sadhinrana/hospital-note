<div v-show="renderForm === 12 && reportRender == 0">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i>Prognosis
                <small class="pull-right">Date: {{date('D, d, M, Y, H:i:s')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <div v-show="reportData.neck.painStiffness === 'Yes'">
        <div class="row">
            <div class="col-xs-12">
                <h4 class="page-header">Neck Pain Opinion/Prognosis </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Opinion</label>
                    <select class="form-control select2" v-select2 v-model="reportData.prognosis.neckOpinion">
                        <option :value="opinion" v-for="opinion in prognosisNeckOpinion"> @{{ opinion }} </option>
                        <option :value="reportData.prognosis.neckOpinion" v-if="reportData.prognosis.neckOpinion !== '' && prognosisNeckOpinion.indexOf(reportData.prognosis.neckOpinion) < 0"> @{{ reportData.prognosis.neckOpinion }} </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Prognosis</label>
                    <select class="form-control select2" v-select2 v-model="reportData.neckPrognosis">
                        <option :value="prognosis" v-for="prognosis in prognosisDate"> @{{ prognosis }} </option>
                        <option :value="reportData.neckPrognosis" v-if="reportData.neckPrognosis !== '' && prognosisDate.indexOf(reportData.neckPrognosis) < 0"> @{{ reportData.neckPrognosis }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Additional treatment</label>
                    <select class="form-control select2" v-select2 v-model="reportData.prognosis.neckTreatment">
                        <option :value="adReport" v-for="adReport in additionalTreatmentListNeck"> @{{ adReport }} </option>
                        <option :value="reportData.prognosis.neckTreatment" v-if="reportData.prognosis.neckTreatment !== '' && additionalTreatmentListNeck.indexOf(reportData.prognosis.neckTreatment) < 0"> @{{ reportData.prognosis.neckTreatment }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Report from other specialist</label>
                    <select class="form-control select2" v-select2 v-model="reportData.prognosis.neckReportFromSpecialist">
                        <option :value="sReport" v-for="sReport in reportFromSpecialistListNeck"> @{{ sReport }} </option>
                        <option :value="reportData.prognosis.neckReportFromSpecialist" v-if="reportData.prognosis.neckReportFromSpecialist !== '' && reportFromSpecialistListNeck.indexOf(reportData.prognosis.neckReportFromSpecialist) < 0"> @{{ reportData.prognosis.neckReportFromSpecialist }} </option>

                    </select>
                </div>
            </div>
        </div>
    </div>
    <div v-show="reportData.lowerBack.painStiffness === 'Yes'">
        <hr>
        <div class="row">
            <div class="col-xs-12">
                <h4>Back Pain Opinion/Prognosis</h4>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Opinion</label>
                    <select class="form-control select2" v-select2 v-model="reportData.prognosis.backPainOpinion">
                        <option :value="opinion" v-for="opinion in prognosisBackOpinion"> @{{ opinion }} </option>
                        <option :value="reportData.prognosis.backPainOpinion" v-if="reportData.prognosis.backPainOpinion !== '' && prognosisBackOpinion.indexOf(reportData.prognosis.backPainOpinion) < 0"> @{{ reportData.prognosis.backPainOpinion }} </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Prognosis</label>
                    <select class="form-control select2" v-select2 v-model="reportData.backPainDuration">
                        <option :value="prognosis" v-for="prognosis in prognosisDate"> @{{ prognosis }} </option>
                        <option :value="reportData.backPainDuration" v-if="reportData.backPainDuration !== '' && prognosisDate.indexOf(reportData.backPainDuration) < 0"> @{{ reportData.backPainDuration }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Additional treatment</label>
                    <select class="form-control select2" v-select2 v-model="reportData.prognosis.backPainTreatment">
                        <option :value="adReport" v-for="adReport in additionalTreatmentListLowerBack"> @{{ adReport }} </option>
                        <option :value="reportData.prognosis.backPainTreatment" v-if="reportData.prognosis.backPainTreatment !== '' && additionalTreatmentListLowerBack.indexOf(reportData.prognosis.backPainTreatment) < 0"> @{{ reportData.prognosis.backPainTreatment }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Report from other specialist</label>
                    <select class="form-control select2" v-select2 v-model="reportData.prognosis.lowerBackReportFromSpecialist">
                        <option :value="sReport" v-for="sReport in reportFromSpecialistLowerBack"> @{{ sReport }} </option>
                        <option :value="reportData.prognosis.lowerBackReportFromSpecialist" v-if="reportData.prognosis.lowerBackReportFromSpecialist !== '' && reportFromSpecialistLowerBack.indexOf(reportData.prognosis.lowerBackReportFromSpecialist) < 0"> @{{ reportData.prognosis.lowerBackReportFromSpecialist }} </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div v-show="reportData.anxity.symptoms === 'Yes'">
        <hr>
        <div class="row">
            <div class="col-xs-12">
                <h4>Anxiety Opinion/Prognosis</h4>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Opinion</label>
                    <select class="form-control select2" v-select2 v-model="reportData.prognosis.anxietyOpinion">
                        <option :value="opinion" v-for="opinion in prognosisAnxietyOpinion"> @{{ opinion }} </option>
                        <option :value="reportData.prognosis.anxietyOpinion" v-if="reportData.prognosis.anxietyOpinion !== '' && prognosisAnxietyOpinion.indexOf(reportData.prognosis.anxietyOpinion) < 0"> @{{ reportData.prognosis.anxietyOpinion }} </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Prognosis</label>
                    <select class="form-control select2" v-select2 v-model="reportData.anxietyDuration">
                        <option :value="prognosis" v-for="prognosis in prognosisDate"> @{{ prognosis }} </option>
                        <option :value="reportData.anxietyDuration" v-if="reportData.anxietyDuration !== '' && prognosisDate.indexOf(reportData.anxietyDuration) < 0"> @{{ reportData.anxietyDuration }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Additional treatment</label>
                    <select class="form-control select2" v-select2 v-model="reportData.prognosis.anxietyTreatment">
                        <option :value="adReport" v-for="adReport in additionalTreatmentListAnxity"> @{{ adReport }} </option>
                        <option :value="reportData.prognosis.anxietyTreatment" v-if="reportData.prognosis.anxietyTreatment !== '' && additionalTreatmentListAnxity.indexOf(reportData.prognosis.anxietyTreatment) < 0"> @{{ reportData.prognosis.anxietyTreatment }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Report from other specialist</label>
                    <select class="form-control select2" v-select2 v-model="reportData.prognosis.anxityReportFromSpecialist">
                        <option :value="sReport" v-for="sReport in reportFromSpecialistListAnxity"> @{{ sReport }} </option>
                        <option :value="reportData.prognosis.anxityReportFromSpecialist" v-if="reportData.prognosis.anxityReportFromSpecialist !== '' && reportFromSpecialistListAnxity.indexOf(reportData.prognosis.anxityReportFromSpecialist) < 0"> @{{ reportData.prognosis.anxityReportFromSpecialist }} </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div v-for="(otherInjury, index) in reportData.otherInjuries">
        <hr>
        <div class="row">
            <div class="col-xs-12">
                <h4>@{{ reportData.otherInjuries[index].other_injury }}</h4>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Opinion</label>
                    <select class="form-control select2" v-select2 v-model="reportData.otherInjuries[index].opinion">
                        <option :value="opinion" v-for="opinion in prognosisOtherOpinion"> @{{ opinion }} </option>
                        <option :value="reportData.otherInjuries[index].opinion" v-if="reportData.otherInjuries[index].opinion !== '' && prognosisOtherOpinion.indexOf(reportData.otherInjuries[index].opinion) < 0"> @{{ reportData.otherInjuries[index].opinion }} </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Prognosis</label>
                    <select class="form-control select2" v-select2 v-model="reportData.otherInjuries[index].prognosis">
                        <option :value="prognosis" v-for="prognosis in prognosisDate"> @{{ prognosis }} </option>
                        <option :value="reportData.otherInjuries[index].prognosis" v-if="reportData.otherInjuries[index].prognosis !== '' && prognosisDate.indexOf(reportData.otherInjuries[index].prognosis) < 0"> @{{ reportData.otherInjuries[index].prognosis }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Additional treatment</label>
                    <select class="form-control select2" v-select2 v-model="reportData.otherInjuries[index].additionalTreatment">
                        <option :value="adReport" v-for="adReport in additionalTreatmentListOther"> @{{ adReport }} </option>
                        <option :value="reportData.otherInjuries[index].additionalTreatment" v-if="reportData.otherInjuries[index].additionalTreatment !== '' && additionalTreatmentListOther.indexOf(reportData.otherInjuries[index].additionalTreatment) < 0"> @{{ reportData.otherInjuries[index].additionalTreatment }} </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Report from other specialist</label>
                    <select class="form-control select2" v-select2 v-model="reportData.otherInjuries[index].reportFromSpecialist">
                        <option :value="sReport" v-for="sReport in reportFromSpecialistListOther"> @{{ sReport }} </option>
                        <option :value="reportData.otherInjuries[index].reportFromSpecialist" v-if="reportData.otherInjuries[index].reportFromSpecialist !== '' && reportFromSpecialistListOther.indexOf(reportData.otherInjuries[index].reportFromSpecialist) < 0"> @{{ reportData.otherInjuries[index].reportFromSpecialist }} </option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

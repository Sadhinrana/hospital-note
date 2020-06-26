<div v-show="renderForm === 5 && reportRender == 0">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Neck
                <small class="pull-right">Date: {{date('D, d, M, Y, H:i:s')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Treatment description :</label>
                <select class="form-control select2" v-model="reportData.neck.painStiffness" v-select2>
                    <option value="Yes"> Yes</option>
                    <option value="No"> No</option>
                    <option value="N/A"> N/A</option>
                    <option :value="reportData.neck.painStiffness" v-if="reportData.neck.painStiffness !== '' && ['Yes', 'No', 'N/A'].indexOf(reportData.neck.painStiffness) < 0">
                        @{{ reportData.neck.painStiffness }}
                    </option>
                </select>
            </div>
        </div>

        <div v-if="reportData.neck.painStiffness == 'Yes'">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Symptoms</label>
                    <select class="form-control select2" v-model="reportData.neck.symptoms" v-select2>
                        <option :value="symptoms" v-for="symptoms in neckSymptomsList"> @{{ symptoms }}</option>
                        <option :value="reportData.neck.symptoms" v-if="reportData.neck.symptoms !== '' && neckSymptomsList.indexOf(reportData.neck.symptoms) < 0"> @{{
                            reportData.neck.symptoms }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label> Onset in days after</label>
                    <select class="form-control select2" v-model="reportData.neck.onsetDaysAfter" v-select2>
                        <option :value="nOnset" v-for="nOnset in onsetDaysAfter"> @{{ nOnset }}</option>
                        <option :value="reportData.neck.onsetDaysAfter" v-if="reportData.neck.onsetDaysAfter !== '' && onsetDaysAfter.indexOf(reportData.neck.onsetDaysAfter) < 0"> @{{
                            reportData.neck.onsetDaysAfter }}
                        </option>
                    </select>
                </div>
            </div>
        </div>


    </div>

    <section v-if="reportData.neck.painStiffness == 'Yes'">
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Intensity</label>
                    <select class="form-control select2" v-model="reportData.neck.intensity" v-select2>
                        <option :value="severity.value" v-for="severity in severityList"> @{{ severity.label }}</option>
                        <option :value="reportData.neck.intensity"
                                v-if="reportData.neck.intensity !== '' && severityList.some(e => e.value === reportData.neck.intensity) === false">
                            @{{ reportData.neck.intensity }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Description</label>
                    <select class="form-control select2" v-model="reportData.neck.description" v-select2>
                        <option :value="nDescription" v-for="nDescription in neckDescriptionList"> @{{ nDescription }}</option>
                        <option :value="reportData.neck.description" v-if="reportData.neck.description !== '' && neckDescriptionList.indexOf(reportData.neck.description) < 0"> @{{
                            reportData.neck.description }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Neurological sequalae</label>
                    <select class="form-control select2" v-model="reportData.neck.neurologicalSequalae" multiple v-select2>
                        <option :value="nSequalaeList" v-for="nSequalaeList in neurologicalSequalaeList"> @{{ nSequalaeList }}</option>
                        <option :value="e" v-for="e in reportData.neck.neurologicalSequalae"
                                v-if="reportData.neck.neurologicalSequalae !== '' && neurologicalSequalaeList.indexOf(e) < 0"> @{{ e }}
                        </option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Headache</label>
                    <select class="form-control select2" v-model="reportData.neck.headache" v-select2>
                        <option :value="headache" v-for="headache in headacheList"> @{{ headache }}</option>
                        <option :value="reportData.neck.headache" v-if="reportData.neck.headache !== '' && headacheList.indexOf(reportData.neck.headache) < 0"> @{{
                            reportData.neck.headache }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </section>


</div>

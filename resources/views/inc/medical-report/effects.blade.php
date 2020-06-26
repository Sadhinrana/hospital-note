<div v-show="renderForm === 10 && reportRender == 0">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Effects on daily life
                <small class="pull-right">Date: {{date('D, d, M, Y, H:i:s')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Total Time Off</label>
                <select class="form-control select2" v-select2 v-model="reportData.effects.totalTimeOff">
                    <option :value="timeOff" v-for="timeOff in timeOffList"> @{{ timeOff }} </option>
                    <option :value="reportData.effects.totalTimeOff" v-if="reportData.effects.totalTimeOff !== '' && timeOffList.indexOf(reportData.effects.totalTimeOff) < 0"> @{{ reportData.effects.totalTimeOff }} </option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label> Light duties</label>
                <select class="form-control select2" v-select2 v-model="reportData.effects.lightDuties">
                    <option :value="light" v-for="light in timeOffList"> @{{ light }} </option>
                    <option :value="reportData.effects.lightDuties" v-if="reportData.effects.lightDuties !== '' && futureDiffcultiesAtWork.indexOf(reportData.effects.lightDuties) < 0"> @{{ reportData.effects.lightDuties }} </option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Work study effects</label>
                <select class="form-control select2" v-model="reportData.effects.workStudy" multiple v-select2>
                    <option :value="effList" v-for="effList in workStudyEffectList"> @{{ effList }} </option>
                    <option v-for="workStudy in reportData.effects.workStudy" :value="workStudy" v-if="workStudyEffectList.indexOf(workStudy) < 0"> @{{ workStudy }} </option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Difficulties at work or with studies</label>
                <select class="form-control select2" v-select2 v-model="reportData.effects.intensity">
                    <option :value="studies" v-for="studies in futureDiffcultiesAtWork"> @{{ studies }} </option>
                    <option :value="reportData.effects.intensity" v-if="reportData.effects.intensity !== '' && futureDiffcultiesAtWork.indexOf(reportData.effects.intensity) < 0"> @{{ reportData.effects.intensity }} </option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Domestic duties </label>
                <select class="form-control select2" v-model="reportData.effects.domesticDuties" multiple v-select2>
                    <option :value="dDuty" v-for="dDuty in domesticDuties"> @{{ dDuty }} </option>
                    <option :value="e" v-for="e in reportData.effects.domesticDuties" v-if="reportData.effects.domesticDuties !== '' && domesticDuties.indexOf(e) < 0"> @{{ e }} </option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Difficulties with domestic duties </label>
                <select class="form-control select2" v-select2 v-model="reportData.effects.lightDutiesCountType">
                    <option :value="studies" v-for="studies in futureDiffcultiesAtWork"> @{{ studies }} </option>
                    <option :value="reportData.effects.lightDutiesCountType" v-if="reportData.effects.lightDutiesCountType !== '' && futureDiffcultiesAtWork.indexOf(reportData.effects.lightDutiesCountType) < 0"> @{{ reportData.effects.lightDutiesCountType }} </option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Sport & Fitness </label>
                <select class="form-control select2" v-select2 v-model="reportData.effects.sportsFitness">
                    <option :value="sport" v-for="sport in sportFitnessLevel"> @{{ sport }} </option>
                    <option :value="reportData.effects.sportsFitness" v-if="reportData.effects.sportsFitness !== '' && sportFitnessLevel.indexOf(reportData.effects.sportsFitness) < 0"> @{{ reportData.effects.sportsFitness }} </option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>At worst </label>
                <select class="form-control select2" v-select2 v-model="reportData.effects.sportsFitnessAtWorst">
                    <option :value="percent" v-for="percent in precentageList"> @{{ percent }} </option>
                    <option :value="reportData.effects.sportsFitnessAtWorst" v-if="reportData.effects.sportsFitnessAtWorst !== '' && precentageList.indexOf(reportData.effects.sportsFitnessAtWorst) < 0"> @{{ reportData.effects.sportsFitnessAtWorst }} </option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Current </label>
                <select class="form-control select2" v-select2 v-model="reportData.effects.sportsFitnessAtCurrent">
                    <option :value="percent" v-for="percent in precentageList"> @{{ percent }} </option>
                    <option :value="reportData.effects.sportsFitnessAtCurrent" v-if="reportData.effects.sportsFitnessAtCurrent !== '' && precentageList.indexOf(reportData.effects.sportsFitnessAtCurrent) < 0"> @{{ reportData.effects.sportsFitnessAtCurrent }} </option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Specific Sporting Activities </label>
                <select class="form-control select2" v-select2 v-model="reportData.effects.specificSportingActivities">
                    <option :value="sportActivities" v-for="sportActivities in sportingActivities"> @{{ sportActivities }} </option>
                    <option :value="reportData.effects.specificSportingActivities" v-if="reportData.effects.specificSportingActivities !== '' && sportingActivities.indexOf(reportData.effects.specificSportingActivities) < 0"> @{{ reportData.effects.specificSportingActivities }} </option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Sleep Pattern </label>
                <select class="form-control select2" v-select2 v-model="reportData.effects.sleepPattern">
                    <option :value="sleep" v-for="sleep in sleepPattern"> @{{ sleep }} </option>
                    <option :value="reportData.effects.sleepPattern" v-if="reportData.effects.sleepPattern !== '' && sleepPattern.indexOf(reportData.effects.sleepPattern) < 0"> @{{ reportData.effects.sleepPattern }} </option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>At worst </label>
                <select class="form-control select2" v-select2 v-model="reportData.effects.sleepPatternAtWorst">
                    <option :value="percent" v-for="percent in precentageList"> @{{ percent }} </option>
                    <option :value="reportData.effects.sleepPatternAtWorst" v-if="reportData.effects.sleepPatternAtWorst !== '' && precentageList.indexOf(reportData.effects.sleepPatternAtWorst) < 0"> @{{ reportData.effects.sleepPatternAtWorst }} </option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Current </label>
                <select class="form-control select2" v-select2 v-model="reportData.effects.sleepPatternCurrent">
                    <option :value="percent" v-for="percent in precentageList"> @{{ percent }} </option>
                    <option :value="reportData.effects.sleepPatternCurrent" v-if="reportData.effects.sleepPatternCurrent !== '' && precentageList.indexOf(reportData.effects.sleepPatternCurrent) < 0"> @{{ reportData.effects.sleepPatternCurrent }} </option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Additional Effects</label>
                <select class="form-control select2" v-select2 v-model="reportData.effects.additionalEffects">
                    <option :value="reportData.effects.additionalEffects" v-if="reportData.effects.additionalEffects"> @{{ reportData.effects.additionalEffects }} </option>
                </select>
            </div>
        </div>
    </div>
</div>

<div v-show="renderForm === 3 && reportRender == 0">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Accident
                <small class="pull-right">Date: {{date('D, d, M, Y, H:i:s')}}</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Date</label>
                <input type="text" class="form-control flatpickr" v-model="reportData.accident.date">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Time</label>
                <select class="form-control select2" v-model="reportData.accident.time" v-select2>
                    <option :value="time" v-for="time in accidentTime"> @{{ time }} </option>
                    <option :value="reportData.accident.time" v-if="reportData.accident.time !== '' && accidentTime.indexOf(reportData.accident.time) < 0"> @{{ reportData.accident.time }}</option>
                </select>
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Protection</label>
                <select class="form-control select2" v-model="reportData.accident.protection" v-select2>
                    <option :value="protection" v-for="protection in protectionList"> @{{ protection }} </option>
                    <option :value="reportData.accident.protection" v-if="reportData.accident.protection !== '' && protectionList.indexOf(reportData.accident.protection) < 0"> @{{ reportData.accident.protection }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Vehicle</label>
                <select class="form-control select2" v-model="reportData.accident.vehicle" v-select2>
                    <option :value="vehicle" v-for="vehicle in vehicles"> @{{ vehicle }} </option>
                    <option :value="reportData.accident.vehicle" v-if="reportData.accident.vehicle !== '' && vehicles.indexOf(reportData.accident.vehicle) < 0"> @{{ reportData.accident.vehicle }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Vehicle location</label>
                <select class="form-control select2" v-model="reportData.accident.vehicleLocation" v-select2>
                    <option :value="location" v-for="location in vehiclesLocations"> @{{ location }} </option>
                    <option :value="reportData.accident.vehicleLocation" v-if="reportData.accident.vehicleLocation !== '' && vehiclesLocations.indexOf(reportData.accident.vehicleLocation) < 0"> @{{ reportData.accident.vehicleLocation }}</option>
                </select>
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Source of impact / Other vehicle</label>
                <select class="form-control select2" v-model="reportData.accident.sourceImpact" v-select2>
                    <option :value="impact" v-for="impact in sourceImpactList"> @{{ impact }} </option>
                    <option :value="reportData.accident.sourceImpact" v-if="reportData.accident.sourceImpact !== '' && sourceImpactList.indexOf(reportData.accident.sourceImpact) < 0"> @{{ reportData.accident.sourceImpact }}</option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Direction of impact</label>
                <select class="form-control select2" v-model="reportData.accident.directionOfImpact" v-select2>
                    <option :value="direction" v-for="direction in directionOfImpactList"> @{{ direction }} </option>
                    <option :value="reportData.accident.directionOfImpact" v-if="reportData.accident.directionOfImpact !== '' && directionOfImpactList.indexOf(reportData.accident.directionOfImpact) < 0"> @{{ reportData.accident.directionOfImpact }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Speed of impact</label>
                <select class="form-control select2" v-model="reportData.accident.speedOfImpact" v-select2>
                    <option :value="speed" v-for="speed in speedOfImpactList"> @{{ speed }} </option>
                    <option :value="reportData.accident.speedOfImpact" v-if="reportData.accident.speedOfImpact !== '' && speedOfImpactList.indexOf(reportData.accident.speedOfImpact) < 0"> @{{ reportData.accident.speedOfImpact }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>After the accident the Claimant went to</label>
                <select class="form-control select2" v-model="reportData.accident.after_accident" v-select2>
                    <option :value="accident" v-for="accident in afterAccidentLIst"> @{{ accident }} </option>
                    <option :value="reportData.accident.after_accident" v-if="reportData.accident.after_accident !== '' && afterAccidentLIst.indexOf(reportData.accident.after_accident) < 0"> @{{ reportData.accident.after_accident }}</option>
                </select>
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label> Vehicle Movement</label>
                <select class="form-control select2" v-model="reportData.accident.vehicleMovement" v-select2>
                    <option :value="movement" v-for="movement in vehiclesMovementList"> @{{ movement }} </option>
                    <option :value="reportData.accident.vehicleMovement" v-if="reportData.accident.vehicleMovement !== '' && vehiclesMovementList.indexOf(reportData.accident.vehicleMovement) < 0"> @{{ reportData.accident.vehicleMovement }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label> Damage to vehicle</label>
                <select class="form-control select2" v-model="reportData.accident.impactSeverity" v-select2>
                    <option :value="damage" v-for="damage in impactSevirityList"> @{{ damage }} </option>
                    <option :value="reportData.accident.impactSeverity" v-if="reportData.accident.impactSeverity !== '' && impactSevirityList.indexOf(reportData.accident.impactSeverity) < 0"> @{{ reportData.accident.impactSeverity }}</option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label> Claimant position </label>
                <select class="form-control select2" v-model="reportData.accident.position" v-select2>
                    <option :value="position" v-for="position in positionList"> @{{ position }} </option>
                    <option :value="reportData.accident.position" v-if="reportData.accident.position !== '' && positionList.indexOf(reportData.accident.position) < 0"> @{{ reportData.accident.position }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label> Body movement </label>
                <select class="form-control select2" v-model="reportData.accident.movement" v-select2>
                    <option :value="bMovement" v-for="bMovement in movements"> @{{ bMovement }} </option>
                    <option :value="reportData.accident.movement" v-if="reportData.accident.movement !== '' && movements.indexOf(reportData.accident.movement) < 0"> @{{ reportData.accident.movement }}</option>
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Accident Circumstance</label>
                <textarea name="description" class="form-control" placeholder="Accident Circumstance" v-model="reportData.accident.circumstance"></textarea>
            </div>
        </div>
    </div>
</div>

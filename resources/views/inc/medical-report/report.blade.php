<div v-show="reportRender == 1" id="report">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="text-center" style="font-size:38px; font-weight:600;"> To The Court </h2>
            <h3 class="text-center" style="font-size:28px; font-weight:500;"> Medical Report </h3>
            <h4 class="text-center" style="font-size:25px; font-weight:400;">Prepared for The Court </h4>
        </div>
        <!-- /.col -->
    </div>
    <div class="text-right hidden-print" style="margin-bottom: 20px">
        <button type="button" class="btn btn-success" onclick="javascript:print()"><i class="fa fa-print"></i> Print</button>
    </div>
    <div class="alert alert-info">Client</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr>
            <th>Name</th>
            <td>@{{ reportData.claimant.title + ' ' + reportData.claimant.firstName + ' ' + reportData.claimant.lastName }}</td>
        </tr>
        <tr v-if="reportData.claimant.dob">
            <th>Date of Birth</th>
            <td>@{{ reportData.claimant.dob ? new Date(reportData.claimant.dob).toDateString() : '' }}</td>
        </tr>
        <tr>
            <th>Address</th>
            <td>@{{ reportData.claimant.address }}<br>@{{ reportData.claimant.city + ', ' + reportData.claimant.country + ', ' + reportData.claimant.postcode }}</td>
        </tr>
        <tr v-if="reportData.accident.date">
            <th>Date of Accident</th>
            <td>@{{ reportData.accident.date ? new Date(reportData.accident.date).toDateString() : '' }}</td>
        </tr>
        <tr v-if="reportData.admin.dateOfExam">
            <th>Date of Examination</th>
            <td>@{{ reportData.admin.dateOfExam ? new Date(reportData.admin.dateOfExam).toDateString() : '' }}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div class="alert alert-info">Medical Expert</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr>
            <th>Name:</th>
            <td>
                Dr {{ isset($medicalReport) ? $medicalReport->user->firstname . ' ' . $medicalReport->user->lastname : auth()->user()->firstname . ' ' . auth()->user()->lastname }}</td>
        </tr>
        <tr>
            <th>Specialism:</th>
            <td>{{ isset($medicalReport) ? $medicalReport->user->specialism : auth()->user()->specialism }}</td>
        </tr>
        <tr>
            <th>Qualifications</th>
            <td>{{ isset($medicalReport) ? $medicalReport->user->qualifications : auth()->user()->qualifications }}</td>
        </tr>
        <tr>
            <th>GMC No:</th>
            <td>{{ isset($medicalReport) ? $medicalReport->user->gmc_no : auth()->user()->gmc_no }}</td>
        </tr>
        <tr>
            <th>MedCo No</th>
            <td>{{ isset($medicalReport) ? $medicalReport->user->med_co_no : auth()->user()->med_co_no }}</td>
        </tr>
        <tr v-if="reportData.admin.dateOfReport">
            <th>Date of report</th>
            <td>@{{ reportData.admin.dateOfReport ? new Date(reportData.admin.dateOfReport).toDateString() : '' }}</td>
        </tr>
        </tbody>
    </table>


    <hr>
    <div class="alert alert-info">Instructing Party</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr v-if="reportData.admin.primaryReferrerName && reportData.admin.primaryReferrerName != 'N/A' && reportData.admin.primaryReferrerName != 'None.'">
            <th>Name:</th>
            <td>@{{ reportData.admin.primaryReferrerName{{-- ? reportData.admin.primaryReferrerName : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.admin.instructingPartyRef && reportData.admin.instructingPartyRef != 'N/A' && reportData.admin.instructingPartyRef != 'None.'">
            <th>Reference:</th>
            <td>@{{ reportData.admin.instructingPartyRef{{-- ? reportData.admin.instructingPartyRef : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.admin.medcoId && reportData.admin.medcoId != 'N/A' && reportData.admin.medcoId != 'None.'">
            <th>MEDCO ID:</th>
            <td>@{{ reportData.admin.medcoId{{-- ? reportData.admin.medcoId : 'N/A'--}} }}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div class="alert alert-info">CONTENTS</div>
    <table class="table table-striped table-hover ">
        <p>Section - 1 Claimant Details</p><br>
        <p>Section - 2 Report Summary</p><br>
        <p>Section - 3 Methodology</p><br>
        <p>Section - 4 Introduction & Documents</p><br>
        <p>Section - 5 Visual Analogue Pain Score</p><br>
        <p>Section - 6 Personal Details</p><br>
        <p>Section - 7 Incident Details</p><br>
        <p>Section - 8 Treatment Details</p><br>
        <p>Section - 9 Injury Details</p><br>
        <p>Section - 10 Effects on Daily Life</p><br>
        <p>Section - 11 Future Treatment and Reporting</p><br>
        <p>Section - 12 Future Job Prospects</p><br>
        <p>Section - 13 Agreement of report</p><br>
        <p>Section - 14 Case Classification and Declaration</p><br>
        <p>Section - 15 Duration of Examination</p><br>
        <p>Section - 16 Resumé</p><br>
        <p>Section - 17 Declaration of Independence</p><br>
        <p>Section - 18 Statement of truth</p><br>
        <p>Section - 19 References</p><br>
    </table>
    <div class="alert alert-info">Section 1 - @{{ reportData.claimant.title + ' ' + reportData.claimant.firstName + ' ' + reportData.claimant.lastName }}</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr v-if="reportData.claimant.address || reportData.claimant.city || reportData.claimant.country || reportData.claimant.postcode">
            <th>Address</th>
            <td>@{{ reportData.claimant.address }}<br>@{{ reportData.claimant.city + ', ' + reportData.claimant.country + ', ' + reportData.claimant.postcode }}</td>
        </tr>
        <tr v-if="reportData.claimant.dob">
            <th>Date of Birth</th>
            <td>@{{ reportData.claimant.dob ? new Date(reportData.claimant.dob).toDateString() : '' }}</td>
        </tr>
        <tr v-if="reportData.accident.date">
            <th>Date of Accident</th>
            <td>@{{ reportData.accident.date ? new Date(reportData.accident.date).toDateString() : '' }}</td>
        </tr>
        <tr v-if="reportData.accident.date">
            <th>Time Since Accident</th>
            <td>@{{ reportData.accident.date ? dateDiffInDays(reportData.accident.date, new Date()) + ' days' : '' }}</td>
        </tr>
        <tr v-if="reportData.admin.dateOfExam">
            <th>Date of Examination</th>
            <td>@{{ reportData.admin.dateOfExam ? new Date(reportData.admin.dateOfExam).toDateString() : '' }}</td>
        </tr>
        <tr v-if="reportData.admin.placeOfExam && reportData.admin.placeOfExam != 'N/A' && reportData.admin.placeOfExam != 'None.'">
            <th>Place of Examination</th>
            <td>@{{ reportData.admin.placeOfExam{{-- ? reportData.admin.placeOfExam : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.admin.caseRef && reportData.admin.caseRef != 'N/A' && reportData.admin.caseRef != 'None.'">
            <th>Case Reference</th>
            <td>@{{ reportData.admin.caseRef{{-- ? reportData.admin.caseRef : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.admin.dateOfReport">
            <th>Date of report</th>
            <td>@{{ reportData.admin.dateOfReport ? new Date(reportData.admin.dateOfReport).toDateString() : '' }}</td>
        </tr>
        <tr v-if="reportData.admin.medcoId && reportData.admin.medcoId != 'N/A' && reportData.admin.medcoId != 'None.'">
            <th>MedCo ID</th>
            <td>@{{ reportData.admin.medcoId{{-- ? reportData.admin.medcoId : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.admin.primaryReferrerName && reportData.admin.primaryReferrerName != 'N/A' && reportData.admin.primaryReferrerName != 'None.'">
            <th>Name of Instructing Party:</th>
            <td>@{{ reportData.admin.primaryReferrerName{{-- ? reportData.admin.primaryReferrerName : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.admin.instructingPartyRef && reportData.admin.instructingPartyRef != 'N/A' && reportData.admin.instructingPartyRef != 'None.'">
            <th>Instructing Party Reference:</th>
            <td>@{{ reportData.admin.instructingPartyRef{{-- ? reportData.admin.instructingPartyRef : 'N/A'--}} }}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div class="alert alert-info">Section 2 - Report summary</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr style="color: black; background: #ffc107">
            <th>Injury</th>
            <th>Prognosis</th>
        </tr>
        <tr v-if="reportData.neck.painStiffness === 'Yes'">
            <td>@{{ reportData.neck.symptoms{{-- ? reportData.neck.symptoms : 'N/A'--}} }}</td>
            <td>@{{ reportData.neckPrognosis{{-- ? reportData.neckPrognosis : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.lowerBack.painStiffness === 'Yes'">
            <td>@{{ reportData.lowerBack.symptoms{{-- ? reportData.lowerBack.symptoms : 'N/A'--}} }}</td>
            <td>@{{ reportData.backPainDuration{{-- ? reportData.backPainDuration : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.anxity.symptoms === 'Yes'">
            <td>@{{ reportData.anxity.symptomsDescription{{-- ? reportData.anxity.symptomsDescription : 'N/A'--}} }}</td>
            <td>@{{ reportData.anxietyDuration{{-- ? reportData.anxietyDuration : 'N/A'--}} }}</td>
        </tr>
        <tr v-for="(injury, index) in reportData.otherInjuries">
            <td>@{{ reportData.otherInjuries[index].other_injury{{-- ? reportData.otherInjuries[index].other_injury : 'N/A'--}} }}</td>
            <td>@{{ reportData.otherInjuries[index].prognosis{{-- ? reportData.otherInjuries[index].prognosis : 'N/A'--}} }}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div class="alert alert-info">Section 3 - Methodology</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr>
            <td>
                <ol>
                    <li>
                        This report is entirely independent and is based on instructions received from the instructing party.
                    </li>
                    <li>
                        The instructing party has requested an examination to be conducted with a report to include the nature and extent of the client’s injuries/symptoms,
                        treatment received, effects on lifestyle and whether any further treatment is appropriate.
                    </li>
                    <li>
                        The report is produced for Court purposes and prepared on the basis of information provided by the client, my examination, any relevant documentation at the
                        time of the examination (including any special instructions) and my own professional medical opinion.
                    </li>
                </ol>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="alert alert-info">Section 4 - Introduction & Documents</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr v-if="reportData.admin.gpRecord && reportData.admin.gpRecord != 'N/A' && reportData.admin.gpRecord != 'None.'">
            <th>GP Records</th>
            <td>@{{ reportData.admin.gpRecord{{-- ? reportData.admin.gpRecord : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.admin.hospitalRecords && reportData.admin.hospitalRecords != 'N/A' && reportData.admin.hospitalRecords != 'None.'">
            <th>Hospital Records</th>
            <td>@{{ reportData.admin.hospitalRecords{{-- ? reportData.admin.hospitalRecords : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.admin.rehabilitationRecords && reportData.admin.rehabilitationRecords != 'N/A' && reportData.admin.rehabilitationRecords != 'None.'">
            <th>Rehabilitation Records</th>
            <td>@{{ reportData.admin.rehabilitationRecords{{-- ? reportData.admin.rehabilitationRecords : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.claimant.id && reportData.claimant.id != 'N/A' && reportData.claimant.id != 'None.'">
            <th>Identification</th>
            <td>@{{ reportData.claimant.id{{-- ? reportData.claimant.id : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.admin.accompaniedBy && reportData.admin.accompaniedBy != 'N/A' && reportData.admin.accompaniedBy != 'None.'">
            <th>Accompanied by</th>
            <td>@{{ reportData.admin.accompaniedBy{{-- ? reportData.admin.accompaniedBy : 'N/A'--}} }}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div class="alert alert-info">Section 5 - Visual Analogue Pain Score</div>
    <table class="table table-striped table-hover">
        <tr>
            <td>
                <img style="width: 100%;" src="{{asset('/img/painScale.e7f19208.jpg')}}" alt="">
            </td>
        </tr>
    </table>
    <hr>
    <div class="alert alert-info">Section 6 - Personal Details</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr v-if="reportData.claimant.gender && reportData.claimant.gender != 'N/A' && reportData.claimant.gender != 'None.'">
            <th>Gender</th>
            <td>
                <span v-if="reportData.claimant.gender === 'M'">Male</span>
                <span v-else-if="reportData.claimant.gender === 'F'">Female</span>
            </td>
        </tr>
        <tr v-if="reportData.claimant.handed && reportData.claimant.handed != 'N/A' && reportData.claimant.handed != 'None.'">
            <th>Dominant Hand</th>
            <td>@{{ reportData.claimant.handed{{-- ? reportData.claimant.handed : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.claimant.domesticStatus && reportData.claimant.domesticStatus != 'N/A' && reportData.claimant.domesticStatus != 'None.'">
            <th>Domestic Status</th>
            <td>@{{ reportData.claimant.domesticStatus{{-- ? reportData.claimant.domesticStatus : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.claimant.job && reportData.claimant.job != 'N/A' && reportData.claimant.job != 'None.'">
            <th>Work/Education</th>
            <td>@{{ reportData.claimant.job{{-- ? reportData.claimant.job : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.claimant.jobEductionStatus && reportData.claimant.jobEductionStatus != 'N/A' && reportData.claimant.jobEductionStatus != 'None.'">
            <th>Status</th>
            <td>@{{ reportData.claimant.jobEductionStatus{{-- ? reportData.claimant.jobEductionStatus : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.claimant.sicknessRecord && reportData.claimant.sicknessRecord != 'N/A' && reportData.claimant.sicknessRecord != 'None.'">
            <th>General health</th>
            <td>@{{ reportData.claimant.sicknessRecord{{-- ? reportData.claimant.sicknessRecord : 'N/A'--}} }}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div class="alert alert-info">Section 7 - Incident Details</div>
    <table class="table table-striped table-hover">
        <tbody v-if="reportData.accident.circumstance === ''">
        <tr v-if="reportData.accident.date">
            <th>Accident Date</th>
            <td>@{{ reportData.accident.date ? new Date(reportData.accident.date).toDateString() : '' }}</td>
        </tr>
        <tr v-if="reportData.accident.time && reportData.accident.time != 'N/A' && reportData.accident.time != 'None'">
            <th>Time of day</th>
            <td>@{{ reportData.accident.time{{-- ? reportData.accident.time : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.accident.vehicle && reportData.accident.vehicle != 'N/A' && reportData.accident.vehicle != 'None'">
            <th>Vehicle</th>
            <td>@{{ reportData.accident.vehicle{{-- ? reportData.accident.vehicle : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.accident.position && reportData.accident.position != 'N/A' && reportData.accident.position != 'None'">
            <th>Claimant position</th>
            <td>@{{ reportData.accident.position{{-- ? reportData.accident.position : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.accident.protection && reportData.accident.protection != 'N/A' && reportData.accident.protection != 'None'">
            <th>Protection</th>
            <td>@{{ reportData.accident.protection{{-- ? reportData.accident.protection : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.accident.vehicleLocation && reportData.accident.vehicleLocation != 'N/A' && reportData.accident.vehicleLocation != 'None'">
            <th>Vehicle location</th>
            <td>@{{ reportData.accident.vehicleLocation{{-- ? reportData.accident.vehicleLocation : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.accident.sourceImpact && reportData.accident.sourceImpact != 'N/A' && reportData.accident.sourceImpact != 'None'">
            <th>Source of impact</th>
            <td>@{{ reportData.accident.sourceImpact{{-- ? reportData.accident.sourceImpact : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.accident.directionOfImpact && reportData.accident.directionOfImpact != 'N/A' && reportData.accident.directionOfImpact != 'None'">
            <th>Direction of impact</th>
            <td>@{{ reportData.accident.directionOfImpact{{-- ? reportData.accident.directionOfImpact : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.accident.vehicleMovement && reportData.accident.vehicleMovement != 'N/A' && reportData.accident.vehicleMovement != 'None'">
            <th>Vehicle Movement</th>
            <td>@{{ reportData.accident.vehicleMovement{{-- ? reportData.accident.vehicleMovement : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.accident.speedOfImpact && reportData.accident.speedOfImpact != 'N/A' && reportData.accident.speedOfImpact != 'None'">
            <th>Speed of impact</th>
            <td>@{{ reportData.accident.speedOfImpact{{-- ? reportData.accident.speedOfImpact : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.accident.impactSeverity && reportData.accident.impactSeverity != 'N/A' && reportData.accident.impactSeverity != 'None'">
            <th>Damage to vehicle</th>
            <td>@{{ reportData.accident.impactSeverity{{-- ? reportData.accident.impactSeverity : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.accident.movement && reportData.accident.movement != 'N/A' && reportData.accident.movement != 'None'">
            <th>Body movement</th>
            <td>@{{ reportData.accident.movement{{-- ? reportData.accident.movement : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.accident.after_accident && reportData.accident.after_accident != 'N/A' && reportData.accident.after_accident != 'None'">
            <th>After the accident</th>
            <td>@{{ reportData.accident.after_accident{{-- ? reportData.accident.after_accident : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.accident.circumstance && reportData.accident.circumstance != 'N/A' && reportData.accident.circumstance != 'None'">
            <th>Accident Circumstance</th>
            <td>@{{ reportData.accident.circumstance{{-- ? reportData.accident.circumstance : 'N/A'--}} }}</td>
        </tr>
        </tbody>

        <tbody v-if="reportData.accident.circumstance !== ''">
        <tr v-if="reportData.accident.circumstance && reportData.accident.circumstance != 'N/A' && reportData.accident.circumstance != 'None'">
            <th>Accident Circumstance</th>
            <td>@{{ reportData.accident.circumstance{{-- ? reportData.accident.circumstance : 'N/A'--}} }}</td>
        </tr>
        </tbody>
    </table>
    <hr>

    <div class="alert alert-info">Section 8 - Treatment Details</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr v-if="reportData.treatment.immediateTreatment && reportData.treatment.immediateTreatment != 'N/A' && reportData.treatment.immediateTreatment != 'None.'">
            <th>Immediate Medical Attendance</th>
            <td>@{{ reportData.treatment.immediateTreatment{{-- ? reportData.treatment.immediateTreatment : 'N/A'--}} }}</td>
        </tr>
        <tr>
            <th>Subsequent Medical Treatment</th>
            <td>GP visits: <strong>@{{ reportData.treatment.primaryCareVisits{{-- ? reportData.treatment.primaryCareVisits : 'N/A'--}} }}</strong> <br> Out of hours visits:
                <strong>@{{ reportData.treatment.hospitalVisits{{-- ? reportData.treatment.hospitalVisits : 'N/A'--}} }}</strong> <br> Accident & Emergency visits : <strong>@{{
                    reportData.treatment.aeVisits{{-- ? reportData.treatment.aeVisits : 'N/A'--}} }}.</strong> <br> Hospital/Consultant Visits : <strong>@{{
                    reportData.treatment.consultantVisits{{-- ? reportData.treatment.consultantVisits : 'N/A'--}} }}.</strong></td>
        </tr>
        <tr v-if="reportData.treatment.medication && reportData.treatment.medication != 'N/A' && reportData.treatment.medication != 'None.'">
            <th>Medication</th>
            <td>@{{ reportData.treatment.medication{{-- ? reportData.treatment.medication : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.treatment.furtherTreatment && reportData.treatment.furtherTreatment != 'N/A' && reportData.treatment.furtherTreatment != 'None.'">
            <th>Rehabilitation session</th>
            <td>@{{ reportData.treatment.furtherTreatment{{-- ? reportData.treatment.furtherTreatment : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.treatment.rehabProvider && reportData.treatment.treatmentDescription != 'N/A' && reportData.treatment.treatmentDescription != 'None.'">
            <th>Rehabilitation provider</th>
            <td>@{{ reportData.treatment.rehabProvider{{-- ? reportData.treatment.rehabProvider : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.treatment.treatmentDescription && reportData.treatment.treatmentDescription != 'N/A' && reportData.treatment.treatmentDescription != 'None.'">
            <th>Treatment review</th>
            <td>@{{ reportData.treatment.treatmentDescription{{-- ? reportData.treatment.treatmentDescription : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.treatment.homeExercise && reportData.treatment.homeExercise != 'N/A' && reportData.treatment.homeExercise != 'None.'">
            <th>Home exercise</th>
            <td>@{{ reportData.treatment.homeExercise{{-- ? reportData.treatment.homeExercise : 'N/A'--}} }}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div class="alert alert-info">Section 9 - Injury Details</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr v-if="reportData.examination.general && reportData.examination.general != 'N/A' && reportData.examination.general != 'None.'">
            <td>
                <h3>General Observations</h3>
                @{{ reportData.examination.general{{-- ? reportData.examination.general : 'N/A'--}} }}
                <br>
            </td>
        </tr>
        </tbody>
    </table>
    <div></div>
    <table class="table table-striped table-hover" v-if="reportData.neck.painStiffness === 'Yes'">
        <tbody>
        <tr style="color: black; background: #ffc107">
            <th colspan="2">Neck Injury</th>
        </tr>
        <tr v-if="reportData.neck.onsetDaysAfter && reportData.neck.onsetDaysAfter != 'N/A' && reportData.neck.onsetDaysAfter != 'None.'">
            <th>Onset</th>
            <td>@{{ reportData.neck.onsetDaysAfter{{-- ? reportData.neck.onsetDaysAfter : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.neck.description && reportData.neck.description != 'N/A' && reportData.neck.description != 'None.'">
            <th>Description</th>
            <td>@{{ reportData.neck.description{{-- ? reportData.neck.description : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.neck.intensity">
            <th>Intensity</th>
            <td>@{{ reportData.neck.intensity ? severityListText.some(e => e.id == reportData.neck.intensity) ? severityListText.find(e => e.id == reportData.neck.intensity).text :
                reportData.neck.intensity : '' }}
            </td>
        </tr>
        <tr v-if="reportData.neck.headache && reportData.neck.headache != 'N/A' && reportData.neck.headache != 'None.'">
            <th>Headache</th>
            <td>@{{ reportData.neck.headache{{-- ? reportData.neck.headache : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.neck.neurologicalSequalae.length > 0">
            <th>Neurological sequelae</th>
            <td>@{{ {{--reportData.neck.neurologicalSequalae.length ? --}}reportData.neck.neurologicalSequalae.join(', '){{-- : 'N/A'--}} }}</td>
        </tr>
        <tr>
            <th>Neck Examination</th>
            <td>
                @{{ reportData.examination.neck.value ? examinationNeck.find(exNeck => exNeck.value == reportData.examination.neck.value).label : '' }}
                <table class="table table-striped table-hover">
                    <tr>
                        <th class="bg-warning-custom">Neck Movement</th>
                        <th class="bg-warning-custom">Degrees</th>
                        <th class="bg-warning-custom">Normal</th>
                    </tr>
                    <tr>
                        <td>Saggital flexion and extension combined.</td>
                        <td>@{{ reportData.examination.neck.settings.sfe{{-- ? reportData.examination.neck.settings.sfe : 'N/A'--}} }}</td>
                        <td>120°</td>
                    </tr>
                    <tr>
                        <td>Right lateral rotation</td>
                        <td>@{{ reportData.examination.neck.settings.rlr{{-- ? reportData.examination.neck.settings.rlr : 'N/A'--}} }}</td>
                        <td>80°</td>
                    </tr>
                    <tr>
                        <td>Right lateral flexion</td>
                        <td>@{{ reportData.examination.neck.settings.rlf{{-- ? reportData.examination.neck.settings.rlf : 'N/A'--}} }}</td>
                        <td>45°</td>
                    </tr>
                    <tr>
                        <td>Left lateral rotation</td>
                        <td>@{{ reportData.examination.neck.settings.llr{{-- ? reportData.examination.neck.settings.llr : 'N/A'--}} }}</td>
                        <td>80°</td>
                    </tr>
                    <tr>
                        <td>Left lateral flexion</td>
                        <td>@{{ reportData.examination.neck.settings.llf{{-- ? reportData.examination.neck.settings.llf : 'N/A'--}} }}</td>
                        <td>450°</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr v-if="reportData.prognosis.neckOpinion && reportData.prognosis.neckOpinion != 'N/A' && reportData.prognosis.neckOpinion != 'None.'">
            <th>Opinion</th>
            <td>@{{ reportData.prognosis.neckOpinion{{-- ? reportData.prognosis.neckOpinion : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.neckPrognosis && reportData.neckPrognosis != 'N/A' && reportData.neckPrognosis != 'None.'">
            <th>Prognosis</th>
            <td>@{{ reportData.neckPrognosis{{-- ? reportData.neckPrognosis : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.prognosis.neckTreatment && reportData.prognosis.neckTreatment != 'N/A' && reportData.prognosis.neckTreatment != 'None.'">
            <th>Additional treatment</th>
            <td>@{{ reportData.prognosis.neckTreatment{{-- ? reportData.prognosis.neckTreatment : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.prognosis.neckReportFromSpecialist && reportData.prognosis.neckReportFromSpecialist != 'N/A'  && reportData.prognosis.neckReportFromSpecialist != 'None.'">
            <th>Additional Report</th>
            <td>@{{ reportData.prognosis.neckReportFromSpecialist{{-- ? reportData.prognosis.neckReportFromSpecialist : 'N/A'--}} }}</td>
        </tr>
        </tbody>
    </table>
    <div></div>
    <table class="table table-striped table-hover" v-if="reportData.lowerBack.painStiffness === 'Yes'">
        <tbody>
        <tr style="color: black; background: #ffc107">
            <th colspan="2">Back injury</th>
        </tr>
        <tr v-if="reportData.lowerBack.symptoms && reportData.lowerBack.symptoms != 'N/A' && reportData.lowerBack.symptoms != 'None.'">
            <th>Symptoms</th>
            <td>@{{ reportData.lowerBack.symptoms{{-- ? reportData.lowerBack.symptoms : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.lowerBack.onsetDaysAfter && reportData.lowerBack.onsetDaysAfter != 'N/A' && reportData.lowerBack.onsetDaysAfter != 'None.' ">
            <th>Onset</th>
            <td>@{{ reportData.lowerBack.onsetDaysAfter{{-- ? reportData.lowerBack.onsetDaysAfter : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.lowerBack.description && reportData.lowerBack.description != 'N/A' && reportData.lowerBack.description != 'None.'">
            <th>Description</th>
            <td>@{{ reportData.lowerBack.description{{-- ? reportData.lowerBack.description : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.lowerBack.intensity">
            <th>Intensity</th>
            <td>@{{ reportData.lowerBack.intensity ? severityListText.some(e => e.id == reportData.lowerBack.intensity) ? severityListText.find(e => e.id ==
                reportData.lowerBack.intensity).text : reportData.lowerBack.intensity : '' }}
            </td>
        </tr>
        <tr v-if="reportData.lowerBack.neurologicalSequalae.length > 0">
            <th>Neurological sequelae</th>
            <td>@{{ {{--reportData.lowerBack.neurologicalSequalae.length ? --}}reportData.lowerBack.neurologicalSequalae.join(', '){{-- : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.examination.back && reportData.examination.back != 'N/A' && reportData.examination.back != 'None.'">
            <th>Thoraco-lumbar Spine Examination</th>
            <td>@{{ reportData.examination.back{{-- ? reportData.examination.back : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.prognosis.backPainOpinion && reportData.prognosis.backPainOpinion != 'N/A' && reportData.prognosis.backPainOpinion != 'None.'">
            <th>Opinion</th>
            <td>@{{ reportData.prognosis.backPainOpinion{{-- ? reportData.prognosis.backPainOpinion : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.backPainDuration && reportData.backPainDuration != 'N/A' && reportData.backPainDuration != 'None.'">
            <th>Prognosis</th>
            <td>@{{ reportData.backPainDuration{{-- ? reportData.backPainDuration : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.prognosis.backPainTreatment && reportData.prognosis.backPainTreatment != 'N/A' && reportData.prognosis.backPainTreatment != 'None.'">
            <th>Additional treatment</th>
            <td>@{{ reportData.prognosis.backPainTreatment{{-- ? reportData.prognosis.backPainTreatment : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.prognosis.lowerBackReportFromSpecialist && reportData.prognosis.lowerBackReportFromSpecialist != 'N/A' && reportData.prognosis.lowerBackReportFromSpecialist != 'None.'">
            <th>Additional Report</th>
            <td>@{{ reportData.prognosis.lowerBackReportFromSpecialist{{-- ? reportData.prognosis.lowerBackReportFromSpecialist : 'N/A'--}} }}</td>
        </tr>
        </tbody>
    </table>
    <div></div>
    <table class="table table-striped table-hover" v-if="reportData.anxity.symptoms === 'Yes'">
        <tbody>
        <tr style="color: black; background: #ffc107">
            <th colspan="2">Psychological injury</th>
        </tr>
        <tr v-if="reportData.anxity.symptomsDescription && reportData.anxity.symptomsDescription != 'N/A' && reportData.anxity.symptomsDescription != 'None.'">
            <th>Symptoms</th>
            <td>@{{ reportData.anxity.symptomsDescription{{-- ? reportData.anxity.symptomsDescription : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.anxity.manifestAs.length > 0">
            <th>Manifest as</th>
            <td>@{{ {{--reportData.anxity.manifestAs.length ? --}}reportData.anxity.manifestAs.join(', '){{-- : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.anxity.onsetDaysAfter && reportData.anxity.onsetDaysAfter != 'N/A' && reportData.anxity.onsetDaysAfter != 'None.'">
            <th>Onset</th>
            <td>@{{ reportData.anxity.onsetDaysAfter{{-- ? reportData.anxity.onsetDaysAfter : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.anxity.intensity">
            <th>Intensity</th>
            <td>@{{ reportData.anxity.intensity ? severityListText.some(e => e.id == reportData.anxity.intensity) ? severityListText.find(e => e.id ==
                reportData.anxity.intensity).text : reportData.anxity.intensity : '' }}
            </td>
        </tr>
        <tr>
            <th>Psychological <br> Assessment</th>
            <td>@{{ reportData.examination.psychological{{-- ? reportData.examination.psychological : 'N/A'--}} }}</td>
        </tr>
        <tr>
            <th>Opinion</th>
            <td>@{{ reportData.prognosis.anxietyOpinion{{-- ? reportData.prognosis.anxietyOpinion : 'N/A'--}} }}</td>
        </tr>
        <tr>
            <th>Prognosis</th>
            <td>@{{ reportData.anxietyDuration{{-- ? reportData.anxietyDuration : 'N/A'--}} }}</td>
        </tr>
        <tr>
            <th>Additional treatment</th>
            <td>@{{ reportData.prognosis.anxietyTreatment{{-- ? reportData.prognosis.anxietyTreatment : 'N/A'--}} }}</td>
        </tr>
        <tr>
            <th>Additional Report</th>
            <td>@{{ reportData.prognosis.anxityReportFromSpecialist{{-- ? reportData.prognosis.anxityReportFromSpecialist : 'N/A'--}} }}</td>
        </tr>
        </tbody>
    </table>
    <div></div>
    <table class="table table-striped table-hover" v-if="reportData.otherInjuries.length > 0" v-for="(otherInjury, index) in reportData.otherInjuries">
        <tbody>

        <tr style="color: black; background: #ffc107">
            <th colspan="2">@{{ otherInjury.other_injury }}</th>
        </tr>
        <tr>
            <th v-if="otherInjury.onset">Onset</th>
            <td>@{{ otherInjury.onset{{-- ? reportData.otherInjuries[index].onset : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="otherInjury.intensity">
            <th>Intensity</th>
            <td>@{{ otherInjury.intensity ? severityListText.some(e => e.id == reportData.otherInjuries[index].intensity) ? severityListText.find(e => e.id ==
                reportData.otherInjuries[index].intensity).text : reportData.otherInjuries[index].intensity : '' }}
            </td>
        </tr>
        <tr v-if="otherInjury.current_status">
            <th>Current status</th>
            <td>@{{ otherInjury.current_status{{-- ? reportData.otherInjuries[index].current_status : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="otherInjury.initial_treatment && otherInjury.initial_treatment != 'N/A' && otherInjury.initial_treatment != 'None.'">
            <th>Initial Treatment</th>
            <td>@{{ otherInjury.initial_treatment{{-- ? reportData.otherInjuries[index].initial_treatment : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="otherInjury.subsequent_tx  && otherInjury.subsequent_tx != 'N/A' && otherInjury.subsequent_tx != 'None.'">
            <th>Subsequent Treatment</th>
            <td>@{{ otherInjury.subsequent_tx{{-- ? reportData.otherInjuries[index].subsequent_tx : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="otherInjury.examination  && otherInjury.examination != 'N/A' && otherInjury.examination != 'None.'">
            <th>Examination</th>
            <td>@{{ otherInjury.examination{{-- ? reportData.otherInjuries[index].examination : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="otherInjury.opinion  && otherInjury.opinion != 'N/A' && otherInjury.opinion != 'None.'">
            <th>Opinion</th>
            <td>@{{ otherInjury.opinion{{-- ? reportData.otherInjuries[index].opinion : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="otherInjury.prognosis  && otherInjury.prognosis != 'N/A' && otherInjury.prognosis != 'None.'">
            <th>Prognosis</th>
            <td>@{{ otherInjury.prognosis{{-- ? reportData.otherInjuries[index].prognosis : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="otherInjury.additionalTreatment  && otherInjury.additionalTreatment != 'N/A' && otherInjury.additionalTreatment != 'None.'">
            <th>Additional treatment</th>
            <td>@{{ otherInjury.additionalTreatment{{-- ? reportData.otherInjuries[index].additionalTreatment : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="otherInjury.reportFromSpecialist  && otherInjury.reportFromSpecialist != 'N/A' && otherInjury.reportFromSpecialist != 'None.'">
            <th>Additional Report</th>
            <td>@{{ otherInjury.reportFromSpecialist{{-- ? reportData.otherInjuries[index].reportFromSpecialist : 'N/A'--}} }}</td>
        </tr>
        </tbody>
    </table>

    <div></div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr>
            <th colspan="2">Previous Medical History</th>
        </tr>
        <tr>
            <td v-if="reportData.history.medical_history === 'No'">The Claimant denied having suffered any previous medical / surgical problems in the areas affected by the index
                accident.
            </td>
            <td v-else>
                <table class="table table-striped table-hover">
                    <tbody v-for="(medical_history, index) in reportData.history.medical_histories">
                    <tr style="color: black; background: #ffc107">
                        <th colspan="2">History @{{ index + 1 }}</th>
                    </tr>
                    <tr v-if="medical_history.medical_history_symptom">
                        <th>Injury/Symptom</th>
                        <td>@{{ medical_history.medical_history_symptom}}
                        </td>
                    </tr>
                    <tr v-if="medical_history.progress">
                        <th>Progress of symptoms</th>
                        <td>@{{ medical_history.progress }}</td>
                    </tr>
                    <tr v-if="medical_history.accident">
                        <th>At time of accident?</th>
                        <td>@{{ medical_history.accident}}</td>
                    </tr>
                    <tr v-if="medical_history.aggravation">
                        <th>Aggravation</th>
                        <td>@{{ medical_history.aggravation}}</td>
                    </tr>
                    <tr v-if="medical_history.attributable">
                        <th>% attributable to the index event.</th>
                        <td>@{{ reportData.history.medical_histories[index].attributable{{-- ? reportData.history.medical_histories[index].attributable : 'N/A'--}} }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <div></div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr>
            <th colspan="2">Previous Accident History</th>
        </tr>
        <tr>
            <td v-if="reportData.history.accident_history === 'No'">The Claimant denied any involvement in previous accidents resulting in injury.</td>
            <td v-else>
                <table class="table table-striped table-hover">
                    <tbody v-for="(accident_history, index) of reportData.history.accident_histories">

                    <tr style="color: black; background: #ffc107">
                        <th colspan="2">History @{{ index + 1 }}</th>
                    </tr>
                    <tr v-if="accident_history.date">
                        <th>Date of accident</th>
                        <td>@{{ accident_history.date ? new Date(accident_history.date).toDateString() : '' }}</td>
                    </tr>
                    <tr v-if="accident_history.type">
                        <th>Type of Accident</th>
                        <td>@{{ accident_history.type}}</td>
                    </tr>
                    <tr v-if="accident_history.symptom">
                        <th>Injury/Symptom</th>
                        <td>@{{ accident_history.symptom}}</td>
                    </tr>
                    <tr v-if="accident_history.progress">
                        <th>Progress of symptoms</th>
                        <td>@{{ accident_history.progress}}</td>
                    </tr>
                    <tr v-if="accident_history.accident">
                        <th>At time of accident?</th>
                        <td>@{{ accident_history.accident}}</td>
                    </tr>
                    <tr v-if="accident_history.aggravation">
                        <th>Aggravation</th>
                        <td>@{{ accident_history.aggravation{{-- ? reportData.history.accident_histories[index].aggravation : 'N/A'--}} }}</td>
                    </tr>
                    <tr v-if="accident_history.attributable">
                        <th>% attributable to the index event.</th>
                        <td>@{{ accident_history.attributable{{-- ? reportData.history.accident_histories[index].attributable : 'N/A'--}} }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="alert alert-info">Section 10 - Effects on Daily Life</div>
    <table class="table table-striped table-hover">

        <tbody>

        <tr v-if="reportData.effects.totalTimeOff && reportData.effects.totalTimeOff != 'None.' && reportData.effects.totalTimeOff != 'N/A'">
            <th>Total time off</th>
            <td>@{{ reportData.effects.totalTimeOff{{-- ? reportData.effects.totalTimeOff : 'N/A'--}} }}</td>
        </tr>

        <tr v-if="reportData.effects.lightDuties && reportData.effects.lightDuties != 'N/A' && reportData.effects.lightDuties != 'None.'">
            <th>Light duties</th>
            <td>@{{ reportData.effects.lightDuties{{-- ? reportData.effects.lightDuties : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.effects.workStudy.length && reportData.effects.workStudy != 'N/A' && reportData.effects.workStudy != 'None.'">
            <th>Work Related Duties</th>
            <td>Difficulties experienced at work: @{{ {{--reportData.effects.workStudy.length ? --}}reportData.effects.workStudy.join(', '){{-- : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.effects.intensity && reportData.effects.intensity != 'N/A' && reportData.effects.intensity != 'None.'">
            <th>Difficulties at work or with studies</th>
            <td>@{{ reportData.effects.intensity{{-- ? reportData.effects.intensity : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.effects.domesticDuties.length && reportData.effects.domesticDuties != 'N/A' && reportData.effects.domesticDuties != 'None.'">
            <th>Effects on Domestic Duties</th>
            <td>The injuries sustained in this accident had a negative impact in the client's life. The following activities subsequently became more difficult:
                @{{ {{--reportData.effects.domesticDuties.length ? --}}reportData.effects.domesticDuties.join(', '){{-- : 'N/A'--}} }}
            </td>
        </tr>
        <tr v-if="reportData.effects.lightDutiesCountType && reportData.effects.lightDutiesCountType != 'N/A' && reportData.effects.lightDutiesCountType != 'None.'">
            <th>Difficulties with domestic duties</th>
            <td>@{{ reportData.effects.lightDutiesCountType{{-- ? reportData.effects.lightDutiesCountType : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.effects.sportsFitness && reportData.effects.sportsFitness !== 'N/R'">
            <th>Effects on Sport & Leisure</th>
            <td>
                <span v-if="reportData.effects.sportsFitness === 'Never'">The Claimant does not take part in any regular leisure activities.</span>
                <span v-else>The Claimant normally takes part in leisure activities. @{{ reportData.effects.sportsFitnessAtWorst === '0%' ? 'At worst these were prevented by the Claimant\'s symptoms' : 'At worst these activities were reduced to about ' + reportData.effects.sportsFitnessAtWorst + ' of normal' }}. @{{ reportData.effects.sportsFitnessAtCurrent === '100%' ? 'It has now returned to normal' : 'The Claimant estimates that leisure activities is currently ' + reportData.effects.sportsFitnessAtCurrent + ' of normal' }}. Activities particularly affected: @{{ reportData.effects.specificSportingActivities }}</span>
            </td>
        </tr>
        <tr v-if="reportData.effects.sleepPattern && reportData.effects.sleepPattern !== 'N/R'">
            <th>Effects on Sleep</th>
            <td>
                <span v-if="reportData.effects.sleepPatternAtWorst === '100%'">The Claimant is normally @{{ reportData.effects.sleepPattern }}. This has not been significantly affected by their symptoms.</span>
                <span v-else>The Claimant is normally @{{ reportData.effects.sleepPattern }}. @{{ reportData.effects.sleepPatternAtWorst === '0%' ? 'At worst these were prevented by the Claimant\'s symptoms' : 'At worst this was reduced to ' + reportData.effects.sleepPatternAtWorst + ' of normal' }}. @{{ reportData.effects.sleepPatternCurrent === '100%' ? 'It has now returned to normal' : 'The Claimant estimates that sleep is currently ' + reportData.effects.sleepPatternCurrent + ' of normal' }}.</span>
            </td>
        </tr>
        <tr v-if="reportData.effects.additionalEffects && reportData.effects.additionalEffects != 'N/A' && reportData.effects.additionalEffects != 'None.'">
            <th>Additional Effects</th>
            <td>@{{ reportData.effects.additionalEffects{{-- ? reportData.effects.additionalEffects : 'N/A'--}} }}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div class="alert alert-info">Section 11 - Future Treatment and Reporting</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr v-if="reportData.future.investigations">
            <th>Investigations</th>
            <td>@{{ reportData.future.investigations{{-- ? reportData.future.investigations : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.future.longTermSequelae">
            <th>Long term sequelae</th>
            <td>@{{ reportData.future.longTermSequelae{{-- ? reportData.future.longTermSequelae : 'N/A'--}} }}</td>
        </tr>
        <tr v-if="reportData.future.otherComments">
            <th>Other comments</th>
            <td>@{{ reportData.future.otherComments{{-- ? reportData.future.otherComments : 'N/A'--}} }}</td>
        </tr>
        <tr>
            <th>Future Reporting Requirements</th>
            <td>Additional medical evidence may be required if any of the Claimant's symptoms, attributed to the accident, do not resolve in line with my stated prognosis.</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div v-if="reportData.future.jobProspects && reportData.future.jobProspects != 'N/A' && reportData.future.jobProspects != 'None.'">
        <div class="alert alert-info">Section 12 - Future Job Prospects</div>
        <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <td>@{{ reportData.future.jobProspects{{-- ? reportData.future.jobProspects : 'N/A'--}} }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <hr>
    <div v-if="reportData.admin.agreementOfReport && reportData.admin.agreementOfReport != 'N/A' && reportData.admin.agreementOfReport != 'None.'">
        <div class="alert alert-info">Section 13 - Agreement of report</div>
        <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <td>
                    <p>@{{ reportData.admin.agreementOfReport{{-- ? reportData.admin.agreementOfReport : 'N/A'--}} }}</p>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <hr>
    <div class="alert alert-info">Section 14 - CASE CLASSIFICATION AND DECLARATION</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr class="alert alert-info">
            <td colspan="2">Soft tissue injury claim</td>
        </tr>
        <tr v-if="reportData.examination.occupantOfVehicle && reportData.examination.occupantOfVehicle != 'N/A' && reportData.examination.occupantOfVehicle != 'None.'">
            <td>Was the Claimant an occupant of a motor vehicle?</td>
            <td>
                @{{ reportData.examination.occupantOfVehicle{{-- ? reportData.examination.occupantOfVehicle : 'N/A'--}} }}
            </td>
        </tr>
        <tr v-if="reportData.examination.softTissueInjury && reportData.examination.softTissueInjury != 'N/A' && reportData.examination.softTissueInjury != 'None.'">
            <td>Does this case fall into the definition of a soft tissue injury?</td>
            <td>
                @{{ reportData.examination.softTissueInjury{{-- ? reportData.examination.softTissueInjury : 'N/A'--}} }}
            </td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div v-if="reportData.admin.durationOfExamination && reportData.admin.durationOfExamination != 'N/A' && reportData.admin.durationOfExamination != 'None.'">
        <div class="alert alert-info">Section 15 - Duration of examination</div>
        <table class="table table-striped table-hover">
            <tbody>
            <tr>
                <td>
                    <ul>
                        <li>@{{ reportData.admin.durationOfExamination{{-- ? reportData.admin.durationOfExamination : 'N/A'--}} }}</li>
                    </ul>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <hr>
    <div class="alert alert-info">Section 16 - Resumé</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr>
            <th>Name</th>
            <td>
                Dr {{ isset($medicalReport) ? $medicalReport->user->firstname . ' ' . $medicalReport->user->lastname : auth()->user()->firstname . ' ' . auth()->user()->lastname }}</td>
        </tr>

        <tr>
            <th>GMC registration type:</th>
            <td>Full GMC number: {{ isset($medicalReport) ? $medicalReport->user->gmc_no : auth()->user()->gmc_no }}</td>
        </tr>


        <tr>
            <th>MDU / MPS number:</th>
            <td>{{ isset($medicalReport) ? $medicalReport->user->mdu_no : auth()->user()->mdu_no }}</td>
        </tr>

        <tr>
            <th>MedCo Number:</th>
            <td>{{ isset($medicalReport) ? $medicalReport->user->med_co_no : auth()->user()->med_co_no }}</td>
        </tr>


        <tr>
            <th>Qualifications:</th>
            <td>
                {!! isset($medicalReport) ? $medicalReport->user->qualifications_details : auth()->user()->qualifications_details !!}
            </td>
        </tr>


        <tr>
            <th>GP Medico-Legal Experience:</th>
            <td>{!! isset($medicalReport) ? $medicalReport->user->gp_med_co_legal_experience : auth()->user()->gp_med_co_legal_experience !!}</td>
        </tr>


        <tr>
            <th>Medico-Legal Experience:</th>
            <td>{!! isset($medicalReport) ? $medicalReport->user->med_co_legal_experience : auth()->user()->med_co_legal_experience !!}</td>
        </tr>

        </tbody>
    </table>
    <hr>
    <div class="alert alert-info">Section 17 - Declaration of Independence</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr>
            <td>
                <ul>
                    <li>I have not provided treatment to the claimant.</li>
                    <li>I am not associated with any person who has provided treatment.</li>
                    <li>I have not recommended any particular treatment provider.</li>
                </ul>
            </td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div class="alert alert-info">Section 18 - Statement of truth</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr>
            <td colspan="2">
                <p>I understand my duty to the court and have complied with that duty. I am aware of the requirements of Part 35 of the Civil Procedure Rules, Practice Direction 35
                    (which supplements Part 35, of the Civil Procedure Rules), and the Guidance for the Instruction of Experts in Civil Claims 2014. I confirm that I have made
                    clear which facts and matters referred to in this report are within my own knowledge and which are not. Those that are within my own knowledge I confirm to be
                    true. The opinions I have expressed represent my true and complete professional opinions on the matters to which they refer.</p>
            </td>
        </tr>
        <tr>
            <td>Signature:
                @if((isset($medicalReport) && $medicalReport->user->signature) || (!isset($medicalReport) && auth()->user()->signature))
                    <img src="{{ asset(isset($medicalReport) ? 'storage/' . $medicalReport->user->signature : 'storage/' . auth()->user()->signature) }}" style="width: 300px;"
                         alt="N/A">
                @endif
            </td>
            <td class="text-center">Date: @{{ reportData.admin.dateOfReport ? new Date(reportData.admin.dateOfReport).toDateString() : '' }}</td>
        </tr>
        <tr>
            <td colspan="2">
                Dr {{ isset($medicalReport) ? $medicalReport->user->firstname . ' ' . $medicalReport->user->lastname : auth()->user()->firstname . ' ' . auth()->user()->lastname }}
                MedCo No. {{ isset($medicalReport) ? $medicalReport->user->med_co_no : auth()->user()->med_co_no }} GMC
                No. {{ isset($medicalReport) ? $medicalReport->user->gmc_no : auth()->user()->gmc_no }}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div class="alert alert-info">Section 19 - References</div>
    <table class="table table-striped table-hover">
        <tbody>
        <tr>
            <td>
                <ol>
                    <li>NHS Health. Whiplash https://www.nhs.uk/conditions/whiplash/ (accessed 12/01/2019)</li>
                    <li>BMJ (2018) Assessment of neck pain. BMJ Best Practice.</li>
                    <li>NICE-Clinical Knowledge Summaries. https://cks.nice.org.uk/neck-pain-whiplash-injury#!topicsummary. (accessed 12/01/2019).</li>
                    <li>Whiplash injury and chronic neck pain. N Engl. J med 1994; 330:1083-4</li>
                    <li>Flashbacks and post-traumatic stress disorder: the genesis of a 20th-century diagnosis. The British Journal of Psychiatry (2003) 182: 158-163. The Royal
                        College of Psychiatrists.
                    </li>
                    <li>Fagg, Foy, Medicolegal Reporting in Orthopaedic Trauma, 2001.</li>
                    <li>Medco Accreditation Training Module 1-8. (accessed 09/08/2018).</li>
                </ol>
            </td>
        </tr>
        </tbody>
    </table>
    <hr>
    <div class="text-center"><h2>END OF REPORT</h2></div>
</div>

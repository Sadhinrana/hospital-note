@extends('adminlte::page')

@section('css')
    <style>
        .bg-warning-custom {
            background-color: #ffc107 !important;
        }
    </style>
@endsection

@section('content')
    <div class="row" id="report-wrapper">
        <div class="col-sm-2 hidden-print">
            <ul class="medical_report_menu">
                @if(auth()->user()->role_id != 5)
                    <li @click="updateForm(1)" :class="{active: renderForm == 1 ? true : false}">Admin</li>
                @endif
                <li @click="updateForm(2)" :class="{active: renderForm == 2 ? true : false}">Claimant</li>
                <li @click="updateForm(3)" :class="{active: renderForm == 3 ? true : false}">Accident</li>
                <li @click="updateForm(4)" :class="{active: renderForm == 4 ? true : false}">Treatment</li>
                <li @click="updateForm(5)" :class="{active: renderForm == 5 ? true : false}">Neck</li>
                <li @click="updateForm(6)" :class="{active: renderForm == 6 ? true : false}">Lower Back</li>
                <li @click="updateForm(7)" :class="{active: renderForm == 7 ? true : false}">Other</li>
                <li @click="updateForm(8)" :class="{active: renderForm == 8 ? true : false}">Past History</li>
                <li @click="updateForm(9)" :class="{active: renderForm == 9 ? true : false}">Anxiety</li>
                <li @click="updateForm(10)" :class="{active: renderForm == 10 ? true : false}">Effects</li>
                @if(auth()->user()->role_id != 5)
                    <li @click="updateForm(11)" :class="{active: renderForm == 11 ? true : false}">Examination</li>
                    <li @click="updateForm(12)" :class="{active: renderForm == 12 ? true : false}">Prognosis</li>
                    <li @click="updateForm(13)" :class="{active: renderForm == 13 ? true : false}">Future</li>
                     <li @click="updateForm(14)" :class="{active: renderForm == 14 ? true : false}">Report</li>
                @endif
            </ul>
        </div>
        <div class="col-sm-10">
            <div class="panel panel-success">
                <div class="panel-heading hidden-print">
                    <div class="row">
                        <div class="col-md-4">
                            <button onclick="goBack()" class="btn btn-sm btn-success"><i class="fa fa-arrow-left"></i> Back</button>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('medical-reports.index') }}" class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> Back to list</a>
                        </div>
                    </div>
                </div>

                <div id="report-wrapper-forms" class="panel-body">
                    <form action="{{ isset($medicalReport) ? route('medical-reports.update', $medicalReport->id) : route('medical-reports.store') }}" method="post">
                        @csrf

                        @if(isset($medicalReport))
                            @method('put')
                        @endif

                        @if(auth()->user()->role_id != 5 )
                            @include('inc.medical-report.admin')
                        @endif

                        @include('inc.medical-report.claimant')

                        @include('inc.medical-report.accident')

                        @include('inc.medical-report.treatment')

                        @include('inc.medical-report.neck')

                        @include('inc.medical-report.lower-back')

                        @include('inc.medical-report.other')

                        @include('inc.medical-report.past-history')

                        @include('inc.medical-report.anxiety')

                        @include('inc.medical-report.effects')

                        @include('inc.medical-report.examination')

                        @include('inc.medical-report.prognosis')

                        @include('inc.medical-report.future')

                        @include('inc.medical-report.report')

                        <input name="data" type="hidden"/>

                         <div class="row hidden-print" v-if="patient">
                            <div class="col-md-1" v-if="renderForm != 2">
                                <input type="button" value="<< Previous" class="btn btn-warning"
                                       @click="updateForm(renderForm == 10 ? renderForm = 9 : renderForm-1)">
                            </div>
                            <div class="col-md-1" v-if="renderForm != 10">
                                <input type="button" value="Next >>" class="btn btn-warning"
                                       @click="updateForm(renderForm == 9 ? renderForm = 10 : renderForm+1)">
                            </div>
                            <div class="col-md-1" v-if="renderForm == 10"><input type="submit" value="Save" class="btn btn-success"></div>
                        </div>

                      {{--  <div class="row hidden-print" v-if="patient">
                            <div class="col-md-1" v-if="renderForm != 2">
                                <input type="button" value="<< Previous" class="btn btn-warning"
                                       @click="updateForm(renderForm == 14 ? renderForm = 10 : renderForm-1)">
                            </div>
                            <div class="col-md-1" v-if="renderForm != 14">
                                <input type="button" value="Next >>" class="btn btn-warning"
                                       @click="updateForm(renderForm == 10 ? renderForm = 14 : renderForm+1)">
                            </div>
                            <div class="col-md-1" v-if="renderForm == 14"><input type="submit" value="Save" class="btn btn-success"></div>
                        </div> --}}

                        <div class="row hidden-print" v-else>
                            <div class="col-md-1" v-if="renderForm != 1">
                                <input type="button" value="<< Previous" class="btn btn-warning"
                                       @click="updateForm(renderForm-1)">
                            </div>
                            <div class="col-md-1" v-if="renderForm != 14">
                                <input type="button" value="Next >>" class="btn btn-warning"
                                       @click="updateForm(renderForm+1)">
                            </div>
                            <div class="col-md-1" v-if="renderForm == 14"><input type="submit" value="Save" class="btn btn-success"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')

    <script src="{{ asset('/js/vue.min.js') }}"></script>
    <script>
        let reportOptions = {
            "history": {
                "medical_history": "No",
                "medical_histories": [],
                "accident_history": "No",
                "accident_histories": [],
            },
            "otherInjuries": [],
            "admin": {
                "gpRecord": "No",
                "hospitalRecords": "No",
                "rehabilitationRecords": "No",
                "agreementOfReport": "I confirm that the factual content of this report has been read and agreed by the client.",
                "medcoId": "",
                "dateOfReport": "",
                "accompaniedBy": "The client was unaccompanied at this assessment.",
                "caseRef": "",
                "dateOfExam": "",
                "durationOfExamination": "15 minutes.",
                "placeOfExam": "",
                "instructingPartyRef": "",
                "primaryReferrerName": ""
            },
            "topics": [],
            "claimant": {
                "patient_id": "N/A",
                "title": "Mr",
                "firstName": "",
                "lastName": "XXX",
                "domesticStatus": "",
                "gender": "",
                "dob": "",
                "handed": "Right Handed",
                "address": "",
                "address2": "  ",
                "city": "",
                "country": "United Kingdom",
                "postcode": "",
                "job": "",
                "id": "",
                "jobEductionStatus": "Full Time.",
                "sicknessRecord": "The client tells me that $he-she$ has always enjoyed good health."
            },
            "accident": {
                "time": "",
                "vehicleLocation": "",
                "after_accident": "",
                "sourceImpact": "",
                "protection": "",
                "impactSeverity": "",
                "circumstance": "",
                "movement": "",
                "position": "",
                "vehicleMovement": "",
                "directionOfImpact": "",
                "speedOfImpact": "",
                "vehicle": "",
                "date": ""
            },
            "prognosis": {
                "neckOpinion": "In my opinion the Claimant's symptoms are related to a soft tissue, whiplash injury affecting the neck region. On the balance of probability they are attributable to the accident. This injury involves muscles and ligaments. There is no evidence of any damage to nerves, vertebrae, or spinal cord.",
                "prognosis": "8 months",
                "neckReportFromSpecialist": "I do not believe a report is required from a specialist from any other medical discipline.",
                "lowerBackReportFromSpecialist": "I do not believe a report is required from a specialist from any other medical discipline.",
                "anxietyTreatment": "Having assessed the client, I do not believe that any additional treatments are necessary for the described psychological signs and symptoms.",
                "anxityReportFromSpecialist": "No additional reports are required at this time.",
                "backPainTreatment": "I would recommend a course of physiotherapy, the number of sessions to be determined by the practitioner following assessment. The reasoning for this recommendation is to facilitate recovery.",
                "neckTreatment": "I would recommend a course of physiotherapy, the number of sessions to be determined by the practitioner following assessment. The reasoning for this recommendation is to facilitate recovery.",
                "anxietyOpinion": "On the balance of probability the psychological symptoms from which the Claimant is suffering are related to the events of the accident. They do not represent Post Traumatic Stress Disorder.",
                "backPainOpinion": "In my opinion the Claimant's symptoms are related to a soft tissue injury affecting the lumbar spine. On the balance of probability they are attributable to the accident. This injury involves muscles and ligaments. There is no evidence of any damage to nerves, vertebrae, or spinal cord or cauda equina."
            },
            "backPainOpinion": "In my opinion the claimant's symptoms are related to a soft tissue injury affecting the lumbar spine. On the balance of probability they are attributable to the accident. This injury involves muscles and ligaments. There is no evidence of any damage to nerves, vertebrae, or spinal cord or cauda equina.",
            "backPainDuration": "8 months",
            "anxietyOpinion": "On the balance of probability the psychological symptoms from which the claimant is suffering are related to the events of the accident. They do not represent Post Traumatic Stress Disorder.",
            "anxietyDuration": "6 months",
            "anxietyTreatment": "Already in progress",
            "neckPrognosis": "6 months",
            "effects": {
                "totalTimeOff": "",
                "workStudy": [],
                "domesticDuties": [],
                "sportsFitness": "regular (once or twice each week)",
                "sleepPattern": "a good sleeper",
                "sleepPatternAtWorst": "40%",
                "sportsFitnessAtWorst": "0%",
                "sportsFitnessAtCurrent": "0%",
                "sleepPatternCurrent": "80%",
                "specificSportingActivities": "Keep fit/home exercise",
                "lightDuties": "",
                "lightDutiesCountType": "2 Weeks",
                "additionalEffects": "",
            },
            "treatment": {
                "hospitalVisits": "None.",
                "hospital": "",
                "rehabProvider": "",
                "medication": "Painkillers and self-home care.",
                "homeExercise": "The Claimant has not been given any home exercises.",
                "immediateTreatment": "I understand $he-she$ did not receive any treatment at the scene of the incident",
                "treatmentDescription": "Whilst I have not been provided with the claimant's medical records to confirm or refute these claims, the above history appears to be consistent with the nature and extent of the claimant's injuries.",
                "aeVisits": "None",
                "consultantVisits": "None",
                "primaryCareVisits": "None.",
                "furtherTreatment": "None."
            },
            "future": {
                "diffcultiesHousehold": "Ongoing",
                "diffcultiesDomestic": "",
                "diffcultiesWorkStudies": "",
                "investigations": "I do not believe any investigation is required to substantiate the conclusions reached in this report.",
                "longTermSequelae": "I do not expect there to be any long term medical sequelae as a direct result of the material incident.",
                "jobProspects": "I would not expect the injuries sustained in the accident to have any future affect on the claimant's job prospects.",
                "otherComments": "In my opinion and on the balance of probabilities, I would confirm that the incapacities claimed, treatments received and consequential losses described are consistent with the index accident."
            },
            "guidelineSessions": "8",
            "provider": "Physiotherapist",
            "recomendation": "I would recommend a course of XXX driving lessons.",
            "jobProspects": "I would not expect the injuries sustained in the accident to have any future affect on the claimant's education or job prospects.",
            "investigations": "I do not believe any investigation is required to substantiate the conclusions reached in this report.",
            "longTermSequelae": "I do not expect there to be any long term medical sequelae as a direct result of the material incident.",
            "otherComments": "Additional medical evidence may be required if any of the Claimant's symptoms, attributed to the accident, do not resolve in line with my stated prognosis.",
            "neck": {
                "painStiffness": "No",
                "symptoms": "",
                "onsetDaysAfter": "Immediately.",
                "pastMedicalHistory": "The claimant states that there is no significant history of neck pain prior to the accident.",
                "description": "",
                "intensity": "",
                "neurologicalSequalae": [],
                "headache": "The Claimant did not suffer from any significant headaches associated with their neck injury.",
                "reportFromSpecialist": "I do not believe a report is required from a specialist from any other medical discipline.",
            },
            "examination": {
                "general": "The claimant was well presented and co operative.",
                "sagittalFlexionExtension": 110,
                "rightLateralRotation": 70,
                "neck": {
                    "value": "",
                    "settings": {
                        "sfe": "",
                        "rlr": "",
                        "rlf": "",
                        "llr": "",
                        "llf": ""
                    }
                },
                "leftLateralRotation": 70,
                "leftLateralFlexion": 40,
                "psychological": "The Claimant appeared well adjusted. There were no signs of any overt psychological or psychiatric illness.",
                "back": "Examination revealed a moderate restriction in movement due to pain at the limits of movement.",
                "occupantOfVehicle": "Yes",
                "softTissueInjury": "Yes",
                "rightLateralFlexion": 40
            },
            "anxity": {
                "symptoms": "No",
                "intensity": 2,
                "manifestAs": [],
                "description": "The claimant has been a nervous driver since the accident. This has not prevented driving but makes him/her a great deal more wary.",
                "onsetDaysAfter": "Immediately",
                "symptomsDescription": "Travel anxiety.",
                "pastMedicalHx": "The claimant states that there is no significant history of mental illnesses prior to the accident."
            },
            "lowerBack": {
                "symptoms": "Pain and stiffness in the lower back.",
                "painStiffness": "No",
                "pastMedicalHistory": "The claimant states that there is no significant history of lower back pain prior to the accident.",
                "intensity": "",
                "description": "The Claimant describes central back pain, made worse by prolonged standing, sitting and especially painful when bending and lifting.",
                "onsetDaysAfter": "Immediately.",
                "neurologicalSequalae": []
            },
            "description": "The claimant describes central back pain, made worse by prolonged standing, sitting and especially painful when bending and lifting.",
            "intensity": 2,
            "complications": "Headache",
            "reportFromSpecialist": "Aggravation of pre-existing thoracic spondylosis - symptomatic - not treated prior to accident",
            "additionalTreatment": "Having assessed the client, I would recommend physiotherapy treatment for this injury. The number of sessions is to be recommended by the treating practioner. The reasoning for this recommendation is to facilitate recovery.",
            "invoice": {}
        };

        @if(isset($medicalReport))
            reportOptions = {!! $medicalReport->data !!};
        @endif

        Vue.directive('select2', {
            inserted(el) {
                $(el).on('select2:select', () => {
                    const event = new Event('change', {bubbles: true, cancelable: true});
                    el.dispatchEvent(event);
                });

                $(el).on('select2:unselect', () => {
                    const event = new Event('change', {bubbles: true, cancelable: true})
                    el.dispatchEvent(event)
                })
            },
        });

        // New vue instance
        new Vue({
            el: '#report-wrapper',
            data: {
                patient: {{ auth()->user()->role_id == 5 ? 1 : 0 }},
                reportRender: 0,
                renderForm: {{ auth()->user()->role_id == 5 ? 2 : 1 }},
                injuryCount: 0,
                reportData: reportOptions,
                accidentTypes: [
                    "N/A.",
                    "Road traffic accident.",
                    "Pedestrian accident.",
                    "Private liability accident.",
                    "Employer's liability accident.",
                    "Fall.",
                    "Resolved.",
                ],
                accidentTime: [
                    "N/A",
                    "Early morning.",
                    "Morning.",
                    "Lunchtime.",
                    "Afternoon.",
                    "Teatime.",
                    "Evening.",
                    "Night.",
                    "Exact time is unknown.",
                    "Other",
                ],
                titles: [
                    {
                        value: "Mr",
                        label: "Mr"
                    },
                    {
                        value: "Mrs",
                        label: "Mrs"
                    },
                    {
                        value: "Ms",
                        label: "Ms"
                    },
                    {
                        value: "Master",
                        label: "Master"
                    },
                    {
                        value: "Miss",
                        label: "Miss"
                    },
                    {
                        value: "Prof",
                        label: "Prof"
                    },
                    {
                        value: "Dr",
                        label: "Dr"
                    }
                ],
                gender: [
                    {
                        value: "M",
                        label: "Male."
                    },
                    {
                        value: "F",
                        label: "Female."
                    }
                ],
                handed: [
                    {
                        value: "Right Handed.",
                        label: "Right Handed."
                    },
                    {
                        value: "Left Handed.",
                        label: "Left Handed."
                    },
                    {
                        value: "Ambidextrous.",
                        label: "Ambidextrous."
                    },
                    {
                        value: "Not Known.",
                        label: "Not Known."
                    }
                ],
                jobs: [
                    "N/A",
                    "Retired.",
                    "Housewife.",
                    "Council officer.",
                    "Sales Representative.",
                    "Unemployed.",
                    "Driver.",
                    "Manager.",
                    "Care worker.",
                    "Carer.",
                    "Sales assistant.",
                    "Retail.",
                    "Teacher.",
                    "Hairdresser.",
                    "Coach.",
                    "Science teacher.",
                    "Hospitality.",
                    "Chef.",
                    "Council Officer.",
                    "Accountant.",
                    "Pharmacist.",
                    "Office worker.",
                    "Support worker.",
                    "Fraud Investigator.",
                    "Factory worker.",
                    "Labourer.",
                    "Various (through agency).",
                    "Builder.",
                    "Site manager.",
                    "Shop assistant.",
                    "Sale assistant.",
                    "Information Technology.",
                    "Chef.",
                    "Customer services representative.",
                    "Administrator.",
                    "Taxi driver.",
                    "Heavy Good Driver.",
                    "Truck Driver.",
                    "Engineering.",
                    "Gas engineering.",
                    "Solicitor.",
                    "Doctor.",
                    "Salesman.",
                    "Customer service.",
                    "Company director.",
                    "Recruitment.",
                    "Nursery worker.",
                    "Police Officer.",
                    "Childminder.",
                    "Retail.",
                    "Teacher.",
                    "Housewife.",
                    "Housewife and mother.",
                    "Schoolchild.",
                    "Student.",
                    "Baby.",
                    "Toddler.",
                    "Unemployed.",
                    "On long term sickness.",
                    "Chartered surveyor.",
                    "Therapist.",
                    "Cashier.",
                    "Retired.",
                    "Pest Control technician.",
                    "Delivery.",
                    "Cleaner.",
                    "Warehouse.",
                    "Commercial Manager.",
                    "Nurse.",
                    "Lawyer.",
                    "Full time employed.",
                    "Security.",
                    "Builder."
                ],
                vehicles: [
                    "N/A",
                    "Saloon car.",
                    "3 door hatchback car.",
                    "5 door hatchback car.",
                    "People carrier.",
                    "MPV.",
                    "4X4 vehicle.",
                    "Car.",
                    "Estate car.",
                    "Cabriolet.",
                    "Small van.",
                    "Medium sized van.",
                    "Large van.",
                    "Minibus.",
                    "Bus.",
                    "Coupe.",
                    "Smart car.",
                    "Taxi.",
                    "A bicycle.",
                    "A motorcycle.",
                    "A moped.",
                    "A horse.",
                    "The pavement.",
                    "Pedestrian.",
                    "Hatchback car."
                ],
                vehiclesMovementList: [
                    "N/A",
                    "Stationary.",
                    "Moving.",
                    "Coming to a stop.",
                    "Reversing.",
                    "Slowing down.",
                    "Travelling forwards.",
                    "Turning left.",
                    "Turning right."
                ],
                rehabProviderList: [
                    "N/A",
                    "Physiotherapist.",
                    "Chiropractor.",
                    "Osteopath.",
                    "Other therapist."
                ],
                immediateTreatmentList: [
                    "N/A",
                    "I understand $he-she$ did not receive any treatment at the scene of the incident.",
                    "The client  was attended to by a paramedic.",
                    "The client  was attended to by a police officer.",
                    "The client  was attended to by a paramedic and police officer.",
                    "The client  was attended to by a paramedic, police officer and fire fighters.",
                    "The client  was attended to by a paramedic. Following the incident, $he-she$ went to A&E. The client  made the journey by ambulance.",
                    "The client  was attended to by a paramedic and a doctor."
                ],
                neckSymptomsList: [
                    "N/A",
                    "Neck pain and stiffness.",
                    "Pain to the neck.",
                    "Pain and stiffness in the neck and shoulders.",
                    "Pain and stiffness in the neck and left shoulder.",
                    "Pain and stiffness in the neck and right shoulder.",
                    "Pain and stiffness in the neck and upper back.",
                    "Pain and stiffness in the neck, across the shoulders and upper back.",
                    "Pain and stiffness in the neck, left shoulder and upper back.",
                    "Pain and stiffness in the neck, right shoulder and upper back."
                ],
                anxitySymptomsList: [
                    "N/A",
                    "Travel anxiety.",
                    "Situational Anxiety and Travel Anxiety.",
                    "Fear of travel.",
                    "Situational Anxiety.",
                    "General Psychological Symptoms."
                ],
                backSymptomsList: [
                    "N/A",
                    "Pain in the thoraco-lumbar spine.",
                    "Pain and stiffness in the lower back.",
                    "Pain in the lower back.",
                    "Pain and stiffness in the left lower back.",
                    "Pain and stiffness in the right lower back.",
                    "Pain in the middle of the back."
                ],
                vehiclesLocations: [
                    "N/A",
                    "On a straight road.",
                    "On a main road.",
                    "On a minor road.",
                    "On a roundabout.",
                    "On a ramp in a car park.",
                    "On a motorway.",
                    "In a row of traffic.",
                    "At traffic lights.",
                    "At a zebra crossing.",
                    "At a slip road.",
                    "At a side road.",
                    "At a roundabout.",
                    "At a mini-roundabout.",
                    "At a crossroad.",
                    "At a corner.",
                    "Around a corner.",
                    "Around a bend.",
                    "Aproaching traffic lights."
                ],
                sourceImpactList: [
                    "N/A",
                    "Saloon car.",
                    "3 door hatchback car.",
                    "5 door hatchback car.",
                    "People carrier.",
                    "4X4 vehicle.",
                    "Car.",
                    "Estate car.",
                    "Cabriolet.",
                    "Small van.",
                    "Medium sized van.",
                    "Large van.",
                    "Van.",
                    "Minibus.",
                    "Bus.",
                    "Coupe.",
                    "Smart car.",
                    "Taxi.",
                    "A bicycle.",
                    "A motorcycle.",
                    "A moped.",
                    "A horse.",
                    "The pavement.",
                    "Pedestrian.",
                    "Hatchback car."
                ],
                protectionList: [
                    "N/A.",
                    "The vehicle was fitted with air bags and these were properly adjusted and fastened at the time of the accident. The airbag was not activated. The client  was wearing a seatbelt.",
                    "The client  was wearing a seatbelt.",
                    "The client  was wearing a seat belt and the airbag discharged in the accident.",
                    "The client  was wearing a seatbelt at the time of the accident.",
                    "The client  was not wearing a seat belt and the airbag discharged in the accident.",
                    "The client  was wearing a seatbelt.",
                    "The vehicle was fitted with air bags and seat belts and these were properly adjusted and fastened at the time of the accident. The airbag was activated.",
                    "The client  was not wearing a seatbelt because $he-she$ was stationary at the time of the accident.",
                    "The client  was not wearing a seatbelt as he/she was driving a taxi at the time of the accident.",
                    "The client  was strapped into a child seat.",
                    "The client  was wearing a seatbelt and sat in a booster seat.",
                    "The client  was wearing the following protective equipment: protective headwear and protective suit.",
                    "The client  was wearing a crash helmet and protective clothing.",
                    "The client  was wearing a crash helmet.",
                    "The client  was not wearing a crash helmet.",
                    "There were no seatbelts fitted.",
                    "The client  was not wearing a seatbelt as had a valid legal exemption, being a taxi driver with passengers at the time of the index accident."
                ],
                directionOfImpactList: [
                    "N/A",
                    "The impact came from the front.",
                    "The impact came from the front driver side.",
                    "The impact came from the front passenger side.",
                    "The impact came from the rear.",
                    "The impact came from the rear passenger side.",
                    "The impact came from the rear driver side.",
                    "The impact came from the passenger side.",
                    "The impact came from the driver side.",
                    "The impact came from the right side.",
                    "The impact came from the left side.",
                    "Braked violently to avoid impact."
                ],
                speedOfImpactList: [
                    "Minor.",
                    "Moderate.",
                    "Severe.",
                    "Unknown speed.",
                    "Low.",
                    "Medium.",
                    "High.",
                ],
                afterAccidentLIst: [
                    "N/A",
                    "After the accident the client continued their journey.",
                    "Attended accident and emergency.",
                    "Attended the GP surgery.",
                    "Attended hospital but could not wait to be seen due to long waiting.",
                    "After the accident $he-she$ attended the Walk-in centre.",
                    "After the accident $he-she$ went home.",
                    "After the accident $he-she$ was given a lift home.",
                    "After the accident $he-she$ went to work and then went home.",
                    "After the accident $he-she$ went to the police station.",
                    "After the accident $he-she$ went to a relative's house."
                ],
                impacts: [
                    "N/A",
                    "The force impact caused extensive damage (and was written off).",
                    "The force impact caused extensive damage.",
                    "The force impact caused moderate damage.",
                    "The force impact caused minor damage.",
                    "The force impact caused no damage."
                ],
                impactSevirityList: [
                    "N/A",
                    "There was no damage to the vehicle.",
                    "There was minor damage to the vehicle.",
                    "There was a moderate amount of damage to the vehicle.",
                    "There was extensive damage to the vehicle.",
                    "Their vehicle was later declared a write off.",
                    "The Claimant does not know how extensive the damage to the vehicle was.",
                    "There was a severe damage to the bicycle.",
                    "There was a moderate damage to the bicycle.",
                    "There was a minor damage to the bicycle.",
                ],
                movements: [
                    "N/A",
                    "The client  remembers being thrown forwards and backwards in the vehicle.",
                    "The client  remembers being thrown forwards and backwards in the vehicle.",
                    "The client  remembers being thrown backwards and forwards in the vehicle.",
                    "The client  remembers being thrown from side to side.",
                    "The client  remembers being thrown forward, $his-her$ head hitting the steering wheel.",
                    "The client  case was thrown forwards and to the side.",
                    "The client  can't remember.",
                    "The client  was thrown to the ground and landed on the right side.",
                    "The client  was thrown to the ground and landed on the left side.",
                    "The client  was thrown to the ground and landed on the back.",
                    "The client  was thrown to the ground and landed on the front.",
                    "The client  was thrown around the vehicle."
                ],
                hospitalVisits: [
                    "None.",
                    "Awaiting.",
                    "1",
                    "2",
                    "3",
                    "4",
                    "5",
                    "6",
                    "7",
                    "8",
                    "9",
                    "10",
                    "11",
                    "12",
                    "13",
                    "14",
                    "15",
                ],
                hospitals: [
                    "N/A",
                    "Hospital, A&E Department.",
                    "Airedale (Keighley)",
                    "Alexandra Hospital",
                    "Ashford Hospital & Royal Free Hopsital",
                    "Bassetlaw Hospital (Nottinghamshire)",
                    "Birmingham Heartland's Hospital",
                    "Bradford Royal Infirmary",
                    "Burnley General Hospital",
                    "Burton Queens Hospital",
                    "Calderdale Royal",
                    "Chapeltown Health Centre",
                    "Chase farm hospital",
                    "City Hospital",
                    "Dewsbury District Hospital",
                    "Dovert Court, Sheffield",
                    "Ealing Hospital",
                    "Finchley Memorial Hospital",
                    "George Eliot Hospital",
                    "Good Hope Hospital",
                    "Halifax",
                    "Harrogate District Hospital",
                    "Homerton Hospital.",
                    "Hospital, A&E Department",
                    "Huddersfield Royal Infirmary",
                    "Leeds General Infirmary",
                    "New Cross Hospital, Wolverhampton",
                    "North Middlesex Hospital.",
                    "Peterborough Hospital",
                    "Princess Alexander Hospital",
                    "Princess Royal Hospital",
                    "Queen Elizabeth Hospital",
                    "Royal Victoria Infirmary Newcastle",
                    "Russels Hall Hospital",
                    "Sandwell hospital",
                    "Selly Oak Hospital",
                    "Sir Robert Peel Hospital",
                    "Solihull Hospital",
                    "St James's University Hospital",
                    "St. Cross Hospital Rugby",
                    "UCL hospital",
                    "University Hospital ,North Staffordshire",
                    "Wakefield",
                    "Walsall Manor Hospital",
                    "Walsgrave Hospital",
                    "Warwick Hospital",
                    "Wythenshawe Hospital",
                    "York District Hospital",
                    "edit",
                    "edit",
                    "other",
                    "other",
                    "pontefract General Infirmary "
                ],
                medication: [
                    "N/A",
                    "The Claimant has been taking simple analgesics such as Paracetamol and Ibuprofen as required.",
                    "Painkillers.",
                    "Painkillers and self-home care.",
                    "None.",
                    "OTC ibuprofen.",
                    "OTC Paracetamol.",
                    "oral analgesia",
                    "Ibuprofen 400mg, three times daily and CoCodamol.",
                    "The Claimant does not like taking medication, so took nothing for the symptoms.",
                    "Paracetamol and Ibuprofen.",
                    "Morphine and co codamol.",
                    "Naproxen.",
                    "Codydramol & naproxen.",
                    "OTC Nurofen.",
                    "Self home care.",
                    "Painkillers.",
                    "Co-dydramol.",
                    "Paracetamol and co codamol.",
                    "Paracetamol, 500 mg.",
                    "Calpol.",
                    "Ibuprofen 400mg.",
                    "Ibuprofen 400mg, as required.",
                    "Ibuprofen 400mg, three times daily.",
                    "Ibuprofen 600mg, as required.",
                    "Ibuprofen 600mg, three times daily.",
                    "Diclofenac 50mg, three times daily.",
                    "Tramadol 100mg, four times daily.",
                    "Ibuprofen as required.",
                    "Diclofenac 50 mg three times daily.",
                    "Co-dydramol tablets as required.",
                    "Co-codamol 2 tablets as required.",
                    "Co-codamol and Ibuprofen around twice a day.",
                    "The C attended $his-her$ local pharmacist and was recommended to take Ibuprofen 400mg.",
                    "The Claimant attended $his-her$ local pharmacist and was recommended to take painkillers.",
                    "The Claimant's mother gave him/her Paracetamol for $his-her$ symptoms.",
                    "The Claimant's father gave him/her Paracetamol for $his-her$ symptoms.",
                    "Amitriptyline, Citalopram, Cocodamol and paracetamol.",
                    "Codeine phosphate 15mg twice daily.",
                    " paracetamol, propanol 10mg, ibuprofen.",
                    "cocodamol and another analgesia which $he-she$ couldn't remember the name.",
                    "Burn cream, unable to remember the name.",
                    "Chloramphenicol.",
                    "topical treatment such as hot water bottle.",
                    "One preparation only or more than one prescription lasting not more than two months.",
                ],
                treatmentDescription: [
                    "N/A",
                    "Whilst I have not been provided with the Claimant's medical records to confirm or refute these claims, the above history appears to be consistent with the nature and extent of the Claimant's injuries.",
                    "Medical records confirm the Claimant's attendance, investigative findings and record a diagnosis of soft tissue injury.",
                    "Medical records do not corroborate the Claimant's history of attendance as described.",
                    "Medical records confirm the Claimant's attendance history as described.",
                    "Medical records confirm the Claimant did not seek medical attention from the GP following the accident."
                ],
                HomeExercise: [
                    "The Claimant has been given home exercise advice and has been following a home exercise regime.",
                    "The Claimant has been given home exercise advice.",
                    "The Claimant has not been given any home exercises.",
                    "Yes.",
                    "No."
                ],
                onsetDaysAfter: [
                    "N/A",
                    "Immediately.",
                    "Within the first 2 hours of the accident.",
                    "Within the first 4 hours of the accident.",
                    "Within the first 6 hours of the accident.",
                    "Within the first 8 hours of the accident.",
                    "Within the first 24 hours of the accident.",
                    "Within the first 48 hours of the accident.",
                    "One to two days following the accident.",
                    "One day after the accident.",
                    "Two days after the accident.",
                    "Three days following the accident.",
                    "Between 3 and 7 days following the accident.",
                    "Gradually worsening over the firstweek after the accident.",
                    "Between 1 and 2 weeks after the accident.",
                    "Between 2 and 4 weeks after the accident.",
                    "Over one month following accident.",
                ],
                neurologicalSequalaeList: [
                    "N/A",
                    "The Claimant did not experience any paraesthesia, limb pain or sensory loss.",
                    "The Claimant did not experience any neurological sequalae.",
                    "Right arm pain",
                    "Right arm sensory loss",
                    "Right arm paraesthesia",
                    "Right leg pain",
                    "Right leg paraesthesia",
                    "Right leg sensory loss",
                    "Left arm paraesthesia",
                    "Left arm pain",
                    "Left arm sensory loss",
                    "Left leg paraesthesia",
                    "Left leg pain",
                    "Left leg sensory loss",
                    "Headache"
                ],
                headacheList: [
                    "N/A",
                    "The Claimant did not suffer from any significant headaches associated with their neck injury.",
                    "The Claimant suffered from headache following the accident.",
                    "The Claimant has suffered from generalised headache associated with their neck pain following the accident.",
                    "None.",

                ],
                neckDescriptionList: [
                    "N/A",
                    "The pain radiated down the right hand side of the neck and into the right shoulder region.",
                    "The pain radiated down the left hand side of the neck and into the left shoulder region.",
                    "The pain radiated down the back of the neck in the middle.",
                    "The pain affected the whole of the neck region and radiated out towards the shoulders and down the upper part of the back.",
                ],
                accompaniedByList: [
                    "N/A",
                    "The client was unaccompanied at this assessment.",
                    "The client was accompanied by an interpreter.",
                    "The client was accompanied by his brother.",
                    "The client was accompanied by her brother.",
                    "The client was accompanied by her friend.",
                    "The client was accompanied by his friend.",
                    "The client was accompanied by his son.",
                    "The client was accompanied by her son.",
                    "The client was accompanied by his parents.",
                    "The client was accompanied by her parents.",
                    "The client was accompanied by his father.",
                    "The client was accompanied by her father.",
                    "The client was accompanied by his mother.",
                    "The client was accompanied by her mother.",
                    "The client was accompanied by his partner.",
                    "The client was accompanied by her partner.",
                    "The client was accompanied by his spouse.",
                    "The client was accompanied by her spouse.",
                    "The client was accompanied by his parents and siblings.",
                    "The client was accompanied by her parents and siblings."
                ],
                durationOfExaminationList: [
                    "N/A",
                    "10 minutes.",
                    "15 minutes.",
                    "20 minutes.",
                    "25 minutes.",
                    "30 minutes.",
                    "40 minutes.",
                    "45 minutes.",
                    "50 minutes.",
                    "60 minutes."
                ],
                neckPastMedicalList: [
                    "N/A",
                    "The Claimant states that there is no significant history of neck pain prior to the accident.",
                    "The Claimant's litigation friend states that there is no significant history of neck pain prior to the accident.",
                    "The Claimant states that $he-she$ has suffered from neck injury over one year prior to the accident.",
                    "The Claimant states that $he-she$ suffered from neck injury following a road traffic accident prior to the accident. The Claimant reports that $he-she$ fully recovered from the symptoms and has been symptoms free for at least last 12 months.",
                    "The Claimant states that $he-she$ suffered from neck injury following a road traffic accident prior to the accident. The Claimant reports that $he-she$ fully recovered from the symptoms and has been symptoms free for at least last 2 years.",
                    "The Claimant states that $he-she$ suffered from neck injury following a road traffic accident prior to the accident. The Claimant reports that $he-she$ fully recovered from the symptoms and has been symptoms free for at least last 3 years",
                    "Medical records confirm no significant history of neck pain.",
                    "Medical records confirm no significant history of neck pain within the previous 12 months.",
                    "The Claimant's parent states that there is no signifiicant history of neck pain prior to the accident.",
                    "The Claimant has suffered from intermittent back pain in the past.",
                    "The Claimant states that there is no significant history of neck pain prior to the accident.",
                    "The Claimant states that $he-she$ has suffered from a previous neck injury over one year prior to the accident.",
                    "Medical records confirm no significant history of neck pain.",
                    "Medical records confirm no significant history of neck pain within the previous 12 months.",
                    "The Claimant's parent states that there is no significant history of neck pain prior to the accident.",
                    "There is no significant history of relevant musculoskeletal or psychological problems.",
                    "The Claimant denied any involvement in previous accidents resulting in injury. The Client also denied having suffered any previous medical / surgical problems in the areas affected by the index accident.",
                ],
                otherInjiryStatusList: [
                    "N/A",
                    "Resolved.",
                    "Ongoing severe.",
                    "Ongoing moderate.",
                    "Ongoing minor."
                ],
                timeUnderMedicalCareList: [],
                ids: [
                    "N/A",
                    "Photo ID in the form of a driving licence: The photographic ID provided was a true likeness of the Client and I am happy to confirm the Client's identity.",
                    "Photo ID in the form of a passport: The photographic ID provided was a true likeness of the Client and I am happy to confirm the Client's identity.",
                    "Photo ID in the form of a photo ID: The photographic ID provided was a true likeness of the Client and I am happy to confirm the Client's identity.",
                    "Photo ID in the form of a work photo ID: The photographic ID provided was a true likeness of the Client and I am happy to confirm the Client's identity.",
                    "The Claimant's identity was checked with the following: credit card. The Claimant did not have any form of identity and so this could not be formally confirmed.",
                    "The Claimant's parent provided adequate identification.",
                    "Photo ID.",
                    "The Claimant was unable to identify themselves.",
                    "The Claimant provided an appointment letter, Bank Card and Photo ID.",
                    "The Claimant provided adequate means of identifying themselves.",
                    "The Claimant's parent provided adequate identification.",
                    "Driving Licence and appointment letter.",
                    "Passport and utility bill.",
                    "Photo ID and appointment letter",
                    "Photo ID and supporting documents.",
                    "Utility bill.",
                    "Credit Card.",
                    "Birth certificate.",
                    "The Claimant provided an appointment letter and photo taken."
                ],
                anxityList: [
                    "N/A",
                    "Panic Attack.",
                    "Fear of travel",
                    "Shock & Shaken",
                    "Neurotic depression",
                    "General fatigue",
                    "Gastrointestinal disorders due to stress",
                    "Insomnia",
                    "Nightmares",
                    "Enuresis",
                    "Flashbacks",
                    "Aggressive outbursts",
                    "Social withdrawal",
                    "Excessive sweating",
                    "Palpitations",
                    "Generalised anxiety",
                    "Situational anxiety",
                    "The Claimant has been a nervous passenger since the accident. This has not prevented travel but makes him a great deal more wary.",
                    "The Claimant has been a nervous passenger since the accident. This has not prevented travel but makes him/her a great deal more wary."
                ],
                anxityPastMedicalHxList: [
                    "None.",
                    "The Claimant states that there is no significant history of mental illnesses prior to the accident.",
                    "The Claimant's litigation friend states that there is no significant history of mental illnesses prior to the accident.",
                    "The Claimant states that $he-she$ has no past medical history of significant psychological or psychiatric illness.",
                    "Medical records confirm that the Claimant has no past medical history of significant psychological or psychiatric illness."
                ],
                workStudyEffectList: [
                    "None.",
                    "N/A",
                    "Loss of mobility/stability",
                    "Fatigue",
                    "Postural difficulties",
                    "Anxiety or depression",
                    "Reduced concentration",
                    "Pain"
                ],
                domesticDuties: [
                    "N/A",
                    "Housework",
                    "Heavy domestic chores",
                    "Cleaning",
                    "Vacuuming",
                    "Ironing",
                    "Cooking",
                    "Looking after the children",
                    "Self-care",
                    "Shopping",
                    "Gardening",
                    "DIY",
                    "Picking up the children",
                    "Driving.",
                    "Activities involving bending, stretching or lifting."
                ],
                sportFitnessLevel: [
                    "N/A",
                    "Never",
                    "occasional (less than once per week)",
                    "regular (once or twice each week)",
                    "regular (twice per week)",
                    "regular (2-3 times each week)",
                    "regular (3 times each week)",
                    "frequent (3-4 times each week)",
                    "very regular (more than 4 times each week)"
                ],
                precentageList: [
                    "N/A",
                    "0%",
                    "10%",
                    "20%",
                    "30%",
                    "40%",
                    "50%",
                    "60%",
                    "70%",
                    "80%",
                    "90%",
                    "100%"
                ],
                sportingActivities: [
                    "N/A",
                    "Keep fit/ home exercise",
                    "Football",
                    "Gym and exercise",
                    "Football & training at the gym",
                    "Cricket",
                    "Swimming",
                    "Skiing",
                    "Football, cricket and training at the gym",
                    "Sports activities",
                    "Gym and ballet",
                    "PE",
                    "PE and games",
                    "Walking",
                    "Jogging",
                    "Running",
                    "Going to the gym",
                    "Cycling",
                    "Basketball",
                    "Badminton",
                    "Tennis",
                    "Dancing.",
                    "Yoga",
                    "Boxing",
                    "Golf",
                    "Snooker",
                    "Cycling and gym"
                ],
                sleepPattern: [
                    "N/A",
                    "an excellent sleeper",
                    "a good sleeper",
                    "a moderate sleeper",
                    "a poor sleeper",
                    "an insomniac"
                ],
                examinationGeneral: [
                    "N/A",
                    "The Claimant was well presented and co operative.",
                    "The Claimant is a pleasant and co-operative. The client  is right handed.",
                    "The Claimant is a pleasant and co-operative. The client  is left handed."
                ],
                examinationNeck: [
                    {
                        label:
                            "Examination revealed a moderate restriction in movement due to pain at the limits of movement. Distraction testing was negative.",
                        value: '81',
                        settings: {sfe: 110, rlr: 70, rlf: 40, llr: 70, llf: 40}
                    },
                    {
                        label: "Not Examined.",
                        value: '2'
                    },
                    {
                        label:
                            "Neck examination showed a normal range of movement in movement with no tenderness to palpation or pain on movement.",
                        value: '3',
                        settings: {sfe: 120, rlr: 80, rlf: 45, llr: 80, llf: 45}
                    },
                    {
                        label: "Neck examination showed a normal range of movement in movement.",
                        value: '4'
                    },
                    {
                        label: "Full range of movement with pain at limits.",
                        value: '5'
                    },
                    {
                        label:
                            "Neck examination showed a slight restriction in movement with associated trapezius tenderness, equal on both sides. Axial loading was negative. Distraction testing was negative.",
                        value: '6',
                        settings: {sfe: 110, rlr: 75, rlf: 40, llr: 75, llf: 40}
                    },
                    {
                        label:
                            "Neck examination showed a slight restriction in movement with associated trapezius tenderness, especially on the left. Axial loading was negative. Distraction testing was negative. ",
                        value: '7',
                        settings: {sfe: 110, rlr: 75, rlf: 40, llr: 80, llf: 45}
                    },
                    {
                        label:
                            "Neck examination showed a slight restriction in movement with associated trapezius tenderness, especially on the right. Axial loading was negative. Distraction testing was negative. ",
                        value: '8',
                        settings: {sfe: 110, rlr: 80, rlf: 45, llr: 75, llf: 40}
                    },
                    {
                        label:
                            "Neck examination showed a moderate restriction in movement with associated trapezius tenderness, equal on both sides. Axial loading was negative. Distraction testing was negative. ",
                        value: '9',
                        settings: {sfe: 110, rlr: 70, rlf: 40, llr: 70, llf: 40}
                    },
                    {
                        label:
                            "Neck examination showed a moderate restriction in movement with associated trapezius tenderness, especially on the left.",
                        value: '10',
                        settings: {sfe: 120, rlr: 70, rlf: 40, llr: 80, llf: 45}
                    },
                    {
                        label:
                            "Neck examination showed a moderate restriction in movement with associated trapezius tenderness, especially on the right. Axial loading was negative. Distraction testing was negative.",
                        value: '11',
                        settings: {sfe: 110, rlr: 80, rlf: 45, llr: 70, llf: 40}
                    },
                    {
                        label:
                            "Neck examination showed a severe restriction in movement with associated trapezius tenderness, equal on both sides. Axial loading was negative. Distraction testing was negative.",
                        value: '12',
                        settings: {sfe: 110, rlr: 65, rlf: 35, llr: 65, llf: 35}
                    },
                    {
                        label:
                            "Neck examination showed a severe restriction in in movement with associated trapezius tenderness, especially on the left. Axial loading was negative. Distraction testing was negative.",
                        value: '13',
                        settings: {sfe: 120, rlr: 65, rlf: 35, llr: 80, llf: 45}
                    },
                    {
                        label:
                            "Neck examination showed a severe restriction in in movement with associated trapezius tenderness, especially on the right. Axial loading was negative. Distraction testing was negative.",
                        value: '14',
                        settings: {sfe: 110, rlr: 80, rlf: 45, llr: 65, llf: 35}
                    },

                    {
                        label:
                            "Neck examination showed a moderate restriction in movement. Axial loading was negative. Distraction testing was negative. ",
                        value: '15',
                        settings: {sfe: 110, rlr: 70, rlf: 40, llr: 70, llf: 40}
                    },
                    {
                        label: "Neck examination showed a severe restriction in movement.",
                        value: '16',
                        settings: {sfe: 90, rlr: 65, rlf: 35, llr: 65, llf: 35}
                    }
                ],
                severityListText: [
                    {
                        id: 1,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be severe. The current severity of the symptom is described as severe. The symptom has therefore not changed from it's initial severity."
                    },
                    {
                        id: 2,
                        text:
                            "The onset of this symptom was immediately after the material incident. The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be severe. The current severity of the symptom is described as moderate. The symptom has therefore improved over time. "
                    },
                    {
                        id: 3,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be severe. The current severity of the symptom is described as mild. The symptom has therefore improved over time."
                    },
                    {
                        id: 4,
                        text:
                            "The onset of this symptom was immediately after the material incident. The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be severe. The current severity of the symptom is nil. This symptom has resolved."
                    },
                    {
                        id: 5,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be moderate. The current severity of the symptom is described as severe. The symptom has therefore deteriorated over time."
                    },
                    {
                        id: 6,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be moderate. The current severity of the symptom is described as moderate. The symptom has therefore not changed from it's initial severity."
                    },
                    {
                        id: 7,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be moderate. The current severity of the symptom is described as mild. The symptom has therefore improved over time."
                    },
                    {
                        id: 8,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be moderate. The current severity of the symptom is described as nil. The symptom has therefore resolved over time."
                    },
                    {
                        id: 9,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be mild. The current severity of the symptom is described as severe. The symptom has therefore deteriorated over time."
                    },
                    {
                        id: 10,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be mild. The current severity of the symptom is described as moderate. The symptom has therefore deteriorated over time."
                    },
                    {
                        id: 11,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be mild. The current severity of the symptom is described as mild. The symptom has therefore not changed from it's initial severity."
                    },
                    {
                        id: 12,
                        text:
                            "The initial level of severity, on a scale of mild-moderate-severe, the symptom was considered by the patient to be mild. The current severity of the symptom is described as nil. The symptom has therefore resolved over time."
                    }
                ],
                reportFromSpecialistListNeck: [
                    "N/A",
                    "No additional reports are required at this time.",
                    "I do not believe a report is required from a specialist from any other medical discipline.",
                    "Having assessed the client, I would recommend that a referral to an orthopaedic surgeon takes place. The reasoning for this recommendation is because the described injury is beyond the scope of my expertise.",
                    "I would recommend a further report from an orthopaedic surgoen.",
                    "I would recommend a further report from an ENT surgeon.",
                    "I would recommend a further report from a rheumatologist.",
                    "I would recommend a further report from a urologist.",
                    "I would recommend a further report from a spinal surgeon.",
                    "I would recommend a further report from a neurosurgeon.",
                    "I would recommend a further report from a neurologist.",
                    "I would recommend a further report from a pain expert.",
                    "I would recommend a further report from a plastic surgeon.",
                    "I would recommend a further report from an A&E specialist."
                ],
                reportFromSpecialistLowerBack: [
                    "N/A",
                    "No additional reports are required at this time.",
                    "I do not believe a report is required from a specialist from any other medical discipline.",
                    "Having assessed the client, I would recommend that a referral to an orthopaedic surgeon takes place. The reasoning for this recommendation is because the described injury is beyond the scope of my expertise.",
                    "I would recommend a further report from an orthopaedic surgoen.",
                    "I would recommend a further report from an ENT surgeon.",
                    "I would recommend a further report from a rheumatologist.",
                    "I would recommend a further report from a urologist.",
                    "I would recommend a further report from a spinal surgeon.",
                    "I would recommend a further report from a neurosurgeon.",
                    "I would recommend a further report from a neurologist.",
                    "I would recommend a further report from a pain expert.",
                    "I would recommend a further report from a plastic surgeon.",
                    "I would recommend a further report from an A&E specialist."
                ],
                reportFromSpecialistListAnxity: [
                    "N/A",
                    "No additional reports are required at this time.",
                    "Having assessed the client, I would recommend that a referral to a clinical psychologist takes place for the psychological injury. The reasoning for this recommendation is because the described injury is beyond the scope of my expertise.",
                    "I do not believe a report is required from a specialist from any other medical discipline.",
                    "I would recommend a further report from a pschologist.",
                    "I would recommend a further report from a psychiatrist."
                ],
                reportFromSpecialistListOther: [
                    "N/A",
                    "No additional reports are required at this time.",
                    "I do not believe a report is required from a specialist from any other medical discipline.",
                    "Having assessed the client, I would recommend that a referral to an orthopaedic surgeon takes place. The reasoning for this recommendation is because the described injury is beyond the scope of my expertise.",
                    "I would recommend a further report from an orthopaedic surgoen.",
                    "I would recommend a further report from an ENT surgeon.",
                    "I would recommend a further report from a rheumatologist.",
                    "I would recommend a further report from a urologist.",
                    "I would recommend a further report from a spinal surgeon.",
                    "I would recommend a further report from a neurosurgeon.",
                    "I would recommend a further report from a neurologist.",
                    "I would recommend a further report from a pain expert.",
                    "I would recommend a further report from a plastic surgeon.",
                    "I would recommend a further report from an A&E specialist."
                ],
                additionalTreatmentListNeck: [
                    "N/A",
                    "I would recommend a course of physiotherapy, the number of sessions to be determined by the practitioner following assessment.",
                    "No additional treatment is required.",
                    "No additional treatment, other than that which is currently planned or in progress, is required at this time.",
                    "Having assessed the client, I do not believe that any additional treatments are necessary for the described physical signs and symptoms.",
                    "I would recommend a course of osteopathy.",
                    "I would recommend a course of chiropractor treatment.",
                    "I would recommend an MRI scan of the affected region."
                ],
                additionalTreatmentListLowerBack: [
                    "N/A",
                    "I would recommend a course of physiotherapy, the number of sessions to be determined by the practitioner following assessment. The reasoning for this recommendation is to facilitate recovery.",
                    "No additional treatment, other than that which is currently planned or in progress, is required at this time.",
                    "Having assessed the client, I do not believe that any additional treatments are necessary for the described physical signs and symptoms.",
                    "I would recommend a course of osteopathy. The number of sessions to be determined following assessment by the specialist practitioner.",
                    "I would recommend a course of chiropractor treatment. The number of sessions to be determined following assessment by the specialist practitioner.",
                    "I would recommend an MRI scan of the affected region."
                ],
                additionalTreatmentListOther: [
                    "N/A",
                    "No additional treatment is required.",
                    "No additional treatment, other than that which is currently planned or in progress, is required at this time.",
                    "Having assessed the client, I do not believe that any additional treatments are necessary for the described physical signs and symptoms.",
                    "I would recommend a course of physiotherapy, the number of sessions to be determined by the practitioner following assessment. The reasoning for this recommendation is to facilitate recovery.",
                    "I would recommend a course of osteopathy.",
                    "I would recommend a course of chiropractor treatment.",
                    "I would recommend an MRI scan of the affected region."
                ],
                investigationsList: [
                    "N/A",
                    "I do not believe any investigation is required to substantiate the conclusions reached in this report.",
                    "Having assessed the client, I do not believe that any additional investigations are necessary for the described physical signs and symptoms."
                ],
                longTermSequelaeList: [
                    "N/A",
                    "I do not expect there to be any long term medical sequelae as a direct result of the material incident.",
                    "On the balance of probabilities, no future complications are anticipated for the client as a consequence of the index accident.",
                    "I am of the opinion that an assessment of future physical/psychological complications is beyond the scope of my expertise in this case.",
                    "I am of the opinion that an assessment of future psychological complications is beyond the scope of my expertise in this case.",
                    "I am of the opinion that an assessment of future physical complications is beyond the scope of my expertise in this case."
                ],
                severityList: [
                    {
                        label: "Severe -> Severe",
                        value: 1
                    },
                    {
                        label: "Severe -> Moderate",
                        value: 2
                    },
                    {
                        label: "Severe -> Mild",
                        value: 3
                    },
                    {
                        label: "Severe -> Nil",
                        value: 4
                    },
                    {
                        label: "Moderate -> Severe",
                        value: 5
                    },
                    {
                        label: "Moderate -> Moderate",
                        value: 6
                    },
                    {
                        label: "Moderate -> Mild",
                        value: 7
                    },
                    {
                        label: "Moderate -> Nil",
                        value: 8
                    },

                    {
                        label: "Mild -> Severe",
                        value: 9
                    },
                    {
                        label: "Mild -> Moderate",
                        value: 10
                    },
                    {
                        label: "Mild -> Mild",
                        value: 11
                    },
                    {
                        label: "Mild -> Nil",
                        value: 12
                    }
                ],
                examinationDegree: [
                    "N/A",
                    0,
                    5,
                    10,
                    15,
                    20,
                    25,
                    30,
                    35,
                    40,
                    45,
                    50,
                    55,
                    60,
                    65,
                    70,
                    75,
                    80,
                    85,
                    90,
                    95,
                    100,
                    105,
                    110,
                    115,
                    120,
                    125,
                    130,
                    135,
                    140,
                    145,
                    150,
                    155,
                    160,
                    165,
                    170,
                    175,
                    180
                ],
                examinationBackList: [
                    "N/A",
                    "Examination of the lower back revealed a normal range of movement with slight pain on forward flexion and some paravertebral tenderness, equal on both sides.",
                    "Examination of the lower back revealed a normal range of movement with slight pain on forward flexion and some paravertebral tenderness, especially on the right side.",
                    "Examination of the lower back revealed a normal range of movement with slight pain on forward flexion and some paravertebral tenderness, especially on the left side.",
                    "Examination of the lower back revealed a normal range of movement with moderate pain on forward flexion and paravertebral tenderness, equal on both sides.",
                    "Examination of the lower back revealed a normal range of movement with moderate pain on forward flexion and paravertebral tenderness, especially on the right side.",
                    "Examination of the lower back revealed a normal range of movement with moderate pain on forward flexion and paravertebral tenderness, especially on the left side.",
                    "Examination of the lower back revealed a normal range of movement with severe pain on forward flexion and significant paravertebral tenderness, equal on both sides.",
                    "Examination of the lower back revealed a normal range of movement with moderate pain on forward flexion and significant paravertebral tenderness, especially on the right side.",
                    "Examination of the lower back revealed a normal range of movement with moderate pain on forward flexion and significant paravertebral tenderness, especially on the left side.",
                    "Examination of the lower back revealed a normal range of movement with moderate pain on forward flexion, extension, right throncal rotation and significant paravertebral tenderness, especially on left side.",
                    "Examination of the lower back revealed a normal range of movement with slight pain on forward flexion, right lateral & throncal rotation.",
                    "Examination revealed a moderate restriction in movement due to pain at the limits of movement.",
                    "Back movements were 60% of normal and appeared to cause pain and discomfort. There was no clinical evidence of any neurovascular deficit.",
                    "Back movements were 70% of normal and appeared to cause pain and discomfort. There was no clinical evidence of any neurovascular deficit.",
                    "Back movements were 80% of normal and appeared to cause pain and discomfort. There was no clinical evidence of any neurovascular deficit.",
                    "Back movements were 90% of normal and appeared to cause pain and discomfort. There was no clinical evidence of any neurovascular deficit.",
                    "Back movements were 95% of normal and appeared to cause pain and discomfort. There was no clinical evidence of any neurovascular deficit.",
                    "Back movements were 65% of normal and appeared to cause pain and discomfort. There was no clinical evidence of any neurovascular deficit.",
                    "Back movements were 50% of normal and appeared to cause pain and discomfort. There was no clinical evidence of any neurovascular deficit.",
                    "Examination revealed a severe restriction in movement with no tenderness to palpation.",
                    "Examination revealed a slight restriction in movement with no tenderness to palpation.",
                    "Examination revealed full range of movement with pain at the limits.",
                    "Examination revealed restricted range of movement by approx 5- 10% due to pain at the limits of movement.",
                    "Examination revealed restricted range of movement by approx 10-15% due to pain at the limits of movement.",
                    "Examination revealed restricted range of movement by approx 15-20% due to pain at the limits of movement.",
                ],
                examinationOtherList: [
                    "N/A",
                    "Examination revealed a moderate restriction in movement due to pain at the limits of movement.",
                    "There was some tenderness to palpation and pain on extreme movements.",
                    "Examination revealed a normal range of movement with slight pain on extreme movements.",
                    "Examination revealed a normal range of movement with moderate pain on extreme movements.",
                    "Examination revealed a normal range of movement with severe pain on extreme movements.",
                    "Examination revealed a moderate restriction in movement due to pain at the limits of movement.",
                    "Examination revealed a severe restriction in movement with no tenderness to palpation.",
                    "Examination revealed a slight restriction in movement with no tenderness to palpation.",
                    "Examination revealed full range of movement with pain at the limits.",
                    "Examination revealed restricted range of movement by approx 5- 10% due to pain at the limits of movement.",
                    "Examination revealed restricted range of movement by approx 10-15% due to pain at the limits of movement.",
                    "Examination revealed restricted range of movement by approx 15-20% due to pain at the limits of movement.",
                    "Examination revealed range of movements were 60% of normal and appeared to cause pain and discomfort. There was no clinical evidence of any neurovascular deficit.",
                    "Examination revealed range of movements were 70% of normal and appeared to cause pain and discomfort. There was no clinical evidence of any neurovascular deficit.",
                    "Examination revealed range of movements were 80% of normal and appeared to cause pain and discomfort. There was no clinical evidence of any neurovascular deficit.",
                    "Examination revealed range of movements were 90% of normal and appeared to cause pain and discomfort. There was no clinical evidence of any neurovascular deficit.",
                    "Examination revealed range of movements were 95% of normal and appeared to cause pain and discomfort. There was no clinical evidence of any neurovascular deficit.",
                    "Examination revealed range of movements were 50% of normal and appeared to cause pain and discomfort. There was no clinical evidence of any neurovascular deficit.",
                ],
                prognosisNeckOpinion: [
                    "N/A",
                    "In my opinion the Claimant's symptoms are related to a soft tissue, whiplash injury affecting the neck region. On the balance of probability they are attributable to the accident. This injury involves muscles and ligaments. There is no evidence of any damage to nerves, vertebrae, or spinal cord.",
                    "In my opinion the Claimant's symptoms were related to a soft tissue, whiplash injury affecting the neck region. On the balance of probability they were attributable to the accident. This injury involved muscles and ligaments. There is no evidence of any damage to nerves, vertebrae, or spinal cord.",
                    "An opinion and prognosis cannot be established at this time for any of the described injuries.",
                    "In my opinion the Claimant's symptoms are related to the physical and emotional trauma of the accident. Symptoms in children of this age are often a lot vaguer than in adults, but on the balance of probability they are attributable to the accident."
                ],
                prognosisDate: [
                    "N/A",
                    "Not Attributable.",
                    "Partially Attributable.",
                    "Reserved",
                    "Refer.",
                    "Referral is required.",
                    "Permanent.",
                    "1 day from the date of the accident.",
                    "2 days from the date of the accident.",
                    "3 days from the date of the accident.",
                    "4 days from the date of the accident.",
                    "5 days from the date of the accident.",
                    "6 days from the date of the accident.",
                    "7 days from the date of the accident.",
                    "8 days from the date of the accident.",
                    "9 days from the date of the accident.",
                    "10 days from the date of the accident.",
                    "1 week from the date of the accident.",
                    "2 weeks from the date of the accident.",
                    "3 weeks from the date of the accident.",
                    "4 weeks from the date of the accident.",
                    "5 weeks from the date of the accident.",
                    "6 weeks from the date of the accident.",
                    "7 weeks from the date of the accident.",
                    "8 weeks from the date of the accident.",
                    "9 weeks from the date of the accident.",
                    "10 weeks from the date of the accident.",
                    "11 weeks from the date of the accident.",
                    "1 month from the date of the accident.",
                    "2 months from the date of the accident.",
                    "3 months from the date of the accident.",
                    "4 months from the date of the accident.",
                    "5 months from the date of the accident.",
                    "6 months from the date of the accident.",
                    "7 months from the date of the accident.",
                    "8 months from the date of the accident.",
                    "9 months from the date of the accident.",
                    "10 months from the date of the accident.",
                    "11 months from the date of the accident.",
                    "12 months from the date of the accident.",
                    "13 months from the date of the accident.",
                    "14 months from the date of the accident.",
                    "15 months from the date of the accident.",
                    "16 months from the date of the accident.",
                    "17 months from the date of the accident.",
                    "18 months from the date of the accident.",
                    "An opinion and prognosis cannot be established at this time for any of the described injuries.",
                ],
                prognosisBackOpinion: [
                    "N/A",
                    "In my opinion the Claimant's symptoms are related to a soft tissue injury affecting the lumbar spine. On the balance of probability they are attributable to the accident. This injury involves muscles and ligaments. There is no evidence of any damage to nerves, vertebrae, or spinal cord or cauda equina.",
                    "An opinion and prognosis cannot be established at this time for any of the described injuries.",
                    "In my opinion the Claimant's symptoms were related to a soft tissue injury affecting the lumbar spine. On the balance of probability they were attributable to the accident. This injury involved muscles and ligaments. There is no evidence of any damage to nerves, vertebrae, or spinal cord or cauda equina.",
                    "There is a clear history of ongoing moderate degenerative back pain at the time of the accident. This is normal for age. On the balance of probability, I would attribute an aggravation of this condition to the index accident for up to 10 months following it. I do not believe that the natural history of this condition will be affected by the soft tissue injuries sustained as a result of this accident."
                ],
                prognosisOtherOpinion: [
                    "N/A",
                    "In my opinion the Claimant's symptoms are related to a soft tissue. On the balance of probability they are attributable to the accident. This injury involves muscles and ligaments. There is no evidence of any damage to nerves or bone.",
                    "In my opinion these symptoms are related to a self limiting soft tissue injury and are consistent with the accident as described to me.",
                    "An opinion and prognosis cannot be established at this time for any of the described injuries."
                ],
                prognosisAnxietyOpinion: [
                    "N/A",
                    "On the balance of probability the psychological symptoms from which the Claimant is suffering are related to the events of the accident. They do not represent Post Traumatic Stress Disorder.",
                    "On the balance of probability the psychological symptoms from which the Claimant was suffering were related to the events of the accident. They do not represent Post Traumatic Stress Disorder.",
                    "On the balance of probability the psychological symptoms from which the Claimant is suffering are related to the events of the accident.",
                    "In my opinion and on the balance of probabilities, the clinical diagnosis of the symptom described above is traumatic shock.",
                    "An opinion and prognosis cannot be established at this time for any of the described injuries."
                ],
                futureDiffcultiesAtWork: [
                    "N/A",
                    "Ongoing.",
                    "None.",
                    "1 day.",
                    "2 days.",
                    "3 days.",
                    "4 days.",
                    "5 days.",
                    "6 days.",
                    "1 week.",
                    "2 weeks.",
                    "3 weeks.",
                    "4 weeks.",
                    "5 weeks.",
                    "6 weeks.",
                    "7 weeks.",
                    "8 weeks.",
                    "9 weeks.",
                    "10 weeks.",
                    "11 weeks.",
                    "1 month.",
                    "2 months.",
                    "3 months.",
                    "4 months.",
                    "5 months.",
                    "6 months.",
                    "7 months.",
                    "8 months.",
                    "9 months.",
                    "10 months.",
                    "11 months.",
                    "12 months.",
                ],
                futureProvidorList: [
                    "N/A",
                    "Chiropractor.",
                    "Physiotherapist.",
                    "Registered Osteopath.",
                    "Other Therapist."
                ],
                futureJobProspectsList: [
                    "N/A",
                    "I would not expect the injuries sustained in the accident to have any future affect on the Claimant's job prospects.",
                    "The Claimant's time off work is reasonable following an injury of this nature. I would not expect the injuries sustained in the accident to have any future affect on the Claimant's job prospects.",
                    "I would not expect the injuries sustained in the accident to have any future affect on the Claimant's education or job prospects.",
                    "The Claimant is a minor. I do not believe that any of the injuries sustained in the accident will have any affect on $his-her$ normal development, both physically and psychological, $his-her$ education or future job prospects.",
                    "The Claimant is retired.",
                    "An opinion and prognosis cannot be established at this time for any of the described injuries."
                ],
                timeOffList: [
                    "N/A",
                    "Ongoing.",
                    "None.",
                    "1 day.",
                    "2 days.",
                    "3 days.",
                    "4 days.",
                    "5 days.",
                    "6 days.",
                    "1 week.",
                    "2 weeks.",
                    "3 weeks.",
                    "4 weeks.",
                    "5 weeks.",
                    "6 weeks.",
                    "7 weeks.",
                    "8 weeks.",
                    "9 weeks.",
                    "10 weeks.",
                    "11 weeks.",
                    "1 month.",
                    "2 months.",
                    "3 months.",
                    "4 months.",
                    "5 months.",
                    "6 months.",
                    "7 months",
                    "8 months",
                    "9 months",
                    "10 months",
                    "11 months",
                    "12 months",
                ],
                domesticStatusList: [
                    "N/A",
                    "The Claimant has spouse/partner and children at home.",
                    "The Claimant has spouse/partner only.",
                    "The Claimant is a single parent with children at home.",
                    "Married.",
                    "The Claimant is single.",
                    "The Claimant is a widow.",
                    "The Claimant is a widower.",
                    "The Claimant is a minor above the age of 11.",
                    "The Claimant is a minor of school age under 11.",
                    "The Claimant is a minor under school age."
                ],
                sicknessRecord: [
                    "N/A",
                    "The client  tells me that $he-she$ has always enjoyed good health.",
                    "The client  tells me that $he-she$ has always enjoyed good health and has never had any significant symptoms of the type that followed this accident.",
                    "The client  tells me that $he-she$ was generally fit and well prior to the accident, with only a minimal amount of time off sick for coughs and colds etc.",
                    "The client  has always enjoyed good health except for XXX.",
                    "The client  has long term disability."
                ],
                jobEductionStatusList: [
                    "N/A",
                    "Full-time.",
                    "Part-time.",
                    "Casual.",
                    "Seasonal.",
                    "Not employed.",
                    "Retired.",
                    "Correspodence course.",
                    "Part-time university.",
                    "Full-time university.",
                    "Apprenticeship studies.",
                    "Part-time college student.",
                    "Full-time college student.",
                    "High school student.",
                    "Primary school pupil.",
                    "Nursery school pupil.",
                    "Beneath school age."
                ],
                positionList: [
                    "N/A",
                    "Driver.",
                    "Front seat passenger.",
                    "Rear seat passenger.",
                    "Driver's side rear passenger.",
                    "Near side, passenger.",
                    "Rear seat middle passenger.",
                    "Passenger.",
                    "Pedestrian.",
                    "Seated.",
                    "Riding."
                ],
                neuroLimbPainList: [
                    "N/A",
                    "left arm paraesthesia",
                    "left arm pain",
                    "left arm sensory loss",
                    "right arm paraesthesia",
                    "right arm pain",
                    "right arm sensory loss"
                ],
                initialTreatmentList: [
                    "N/A",
                    "None.",
                    "Medication.",
                    "Medication and self-home care.",
                    "Medication, Suturing, dressing and woundcare.",
                    "Admission, woundcare and suturing",
                    "Immobilisation and medication.",
                    "External Suturing.",
                    "Internal Suturing.",
                    "Dressing.",
                    "Removal of foreign body."
                ],
                subsequentTxList: [
                    "N/A",
                    "None.",
                    "Medication.",
                    "Painkillers and self-home care.",
                    "Medication and self-home care.",
                    "Medication, Suturing, dressing and woundcare.",
                    "Admission, woundcare and suturing.",
                    "Bedrest and medication.",
                    "Immobilisation and medication.",
                    "External Suturing.",
                    "Internal Suturing.",
                    "Dressing.",
                    "Removal of foreign body."
                ],
                otherCommentsList: [],
                examinationPsych: [
                    "N/A",
                    "The Claimant appeared well adjusted. There were no signs of any overt psychological or psychiatric illness. The client  was clearly upset when talking about the events of the accident.",
                    "The Claimant appeared well adjusted. There were no signs of any overt psychological or psychiatric illness.",
                    "Psychological examination is normal.",
                    "The Claimant had good eye contact, rapport and smiled appropriately. There were no psychotic features, delusional ideas or thought disorders. The client  answered my questions intelligently. The client  had normal speech and was oriented in time and place. The client  had no tearfulness, agitation or associated hand tremors."
                ],
                additionalTreatmentListAnxity: [
                    "N/A",
                    "Having assessed the client, I do not believe that any additional treatments are necessary for the described psychological signs and symptoms.",
                    "No additional treatment, other than that which is currently planned or in progress, is required at this time.",
                    "I would recommend a course of counselling, the number of sessions to be determined following assessment by the specialist practitioner.",
                    "I would recommend a course of Cognitive Behavioural Therapy, the number of sessions to be determined following assessment by the specialist practitioner."
                ],
                effectsDescription: [],
                effectList: [],
                placeOfExam: [
                    "N/A",
                    "MediWell Clinic, Tottenham, N17, London.",
                    "Rosewood Practice, Stamford Hill, N16, London.",
                    "Private Walk-In Clinic, Goldhawk, W12, London.",
                    "ExpertDoctors, Wenta Centre, Enfield.",
                    "London Dermatology Clinic, Peak House, London.",
                    "ExpertDoctors, London.",
                    "ExpertDoctors, Jhumat House 160 London Rd, Barking, IG11 8BB."
                ],
                lowerBackPastMedicalHistory: [
                    "N/A",
                    "The Claimant states that there is no significant history of lower back pain prior to the accident.",
                    "The Claimant's litigation friend states that there is no significant history of lower back pain prior to the accident.",
                    "The Claimant denied having suffered any previous medical / surgical problems in the areas affected by the index accident.",
                    "The Claimant states that $he-she$ suffered from back injury following a road traffic accident prior to the accident. The Claimant reports that $he-she$ fully recovered from the symptoms and has been symptoms free for at least last 12 months.",
                    "The Claimant states that $he-she$ suffered from back injury following a road traffic accident prior to the accident. The Claimant reports that $he-she$ fully recovered from the symptoms and has been symptoms free for at least last 2 years.",
                    "The Claimant states that $he-she$ suffered from back injury following a road traffic accident prior to the accident. The Claimant reports that $he-she$ fully recovered from the symptoms and has been symptoms free for at least last 3 years",
                    "Medical records confirm no significant history of lower back pain.",
                    "Medical records confirm no significant history of back pain within the previous 12 months.",
                    "The Claimant stated that she has back pain history prior to the accident",
                ],
                lowerBackDesctiption: [
                    "N/A",
                    "The Claimant says that $he-she$ has suffered from pain across the lower back. This has been worse when sitting at work and also whenever $he-she$ bends or lifts.",
                    "The Claimant describes central back pain, made worse by prolonged standing, sitting and especially painful when bending and lifting.",
                    "The Claimant describes pain that is particularly bad when $he-she$ has been sat for any length of time or first thing in the morning on waking.",
                ],
                otherPastMedicalList: [
                    "N/A",
                    "The Claimant denies any previous significant related symptoms.",
                    "The Claimant states that $he-she$ suffered from physical injuries following a road traffic accident prior to the accident. The Claimant reports that $he-she$ fully recovered from the symptoms and has been symptoms free for at least last 12 months.",
                    "The Claimant states that $he-she$ suffered from physical injuries following a road traffic accident prior to the accident. The Claimant reports that $he-she$ fully recovered from the symptoms and has been symptoms free for at least last 2 years.",
                    "The Claimant states that $he-she$ suffered from physical injuries following a road traffic accident prior to the accident. The Claimant reports that $he-she$ fully recovered from the symptoms and has been symptoms free for at least last 3 years",
                    "The Claimant denied having suffered any previous medical / surgical problems in the areas affected by the index accident.",
                    "Medical records confirm no significant history in the areas affected by the index accident.",
                    "Medical records confirm no significant history in the areas affected by the index accident within the previous 12 months.",
                    "Medical records confirm that there is no significant related past history to this injury.",
                ],
                jobEducationStatus: [],
                patients: @json($patients)
            },

            methods: {

                selectPatient() {
                    let patient = this.patients.filter(patient => patient.id == this.reportData.claimant.patient_id);
                    console.log(patient);
                    if (patient.length > 0) {
                        this.reportData.claimant.title = patient[0].cap_title;
                        this.reportData.claimant.firstName = patient[0].firstname;
                        this.reportData.claimant.lastName = patient[0].lastname;
                        this.reportData.claimant.gender = patient[0].gender;
                        this.reportData.claimant.address = patient[0].address;
                        this.reportData.claimant.dob = patient[0].date_of_birth;
                        setTimeout(function () {
                            flatpickr('#dob', {
                                altInput: true,
                                altFormat: "d M, Y",
                                dateFormat: "Y-m-d",
                                defaultDate: patient[0].date_of_birth
                            });
                        }, 1)
                    } else {
                        this.reportData.claimant.title = '';
                        this.reportData.claimant.firstName = '';
                        this.reportData.claimant.lastName = '';
                        this.reportData.claimant.gender = '';
                        this.reportData.claimant.address = '';
                        this.reportData.claimant.dob = '';
                        setTimeout(function () {
                            flatpickr('#dob', {
                                altInput: true,
                                altFormat: "d M, Y",
                                dateFormat: "Y-m-d",
                                defaultDate: ''
                            });
                        }, 1)
                    }
                },

                setNeckSettings: function () {
                    let _this = this;
                    let neckId = this.reportData.examination.neck.value;
                    const index = _this.examinationNeck.map(e => e.value).indexOf(neckId);
                    if (index > -1) {
                        let exam_neck = _this.examinationNeck[index];
                        this.reportData.examination.neck.settings = exam_neck.settings;
                    }

                    setTimeout(function () {
                        $('.select2').select2({
                            placeholder: "-- Select --",
                            width: '100%',
                            allowClear: true,
                            tags: true
                        });
                    }, 1);
                },
                addInjuries: function () {
                    this.reportData.otherInjuries.push({
                        other_injury: "",
                        current_status: "",
                        onset: "",
                        intensity: "",
                        initial_treatment: "",
                        subsequent_tx: "",
                    });

                    setTimeout(function () {
                        $('.select2').select2({
                            placeholder: "-- Select --",
                            width: '100%',
                            allowClear: true,
                            tags: true
                        });
                        $('.select2').on('select2:unselecting', function (e) {
                            $(this).val('');
                        })
                    }, 1);
                },
                removeInjuries: function (index) {
                    this.reportData.otherInjuries.splice(index, 1);
                },
                addMedicalHistory: function () {
                    this.reportData.history.medical_histories.push({
                        medical_history_symptom: "",
                        progress: "",
                        accident: "",
                        aggravation: "",
                        attributable: "",
                    });

                    setTimeout(function () {
                        $('.select2').select2({
                            placeholder: "-- Select --",
                            width: '100%',
                            allowClear: true,
                            tags: true
                        });
                        $('.select2').on('select2:unselecting', function (e) {
                            $(this).val('');
                        })
                    }, 1);
                },
                removeMedicalHistory: function (index) {
                    this.reportData.history.medical_histories.splice(index, 1);
                },
                addAccidentHistory: function () {
                    this.reportData.history.accident_histories.push({
                        date: "",
                        type: "",
                        symptom: "",
                        progress: "",
                        accident: "",
                        aggravation: "",
                        attributable: "",
                    });

                    setTimeout(function () {
                        flatpickr('.flatpickr', {
                            altInput: true,
                            altFormat: "d M, Y",
                            dateFormat: "Y-m-d",
                            placeholder: "Choose date",
                        });
                        $('.select2').select2({
                            placeholder: "-- Select --",
                            width: '100%',
                            allowClear: true,
                            tags: true
                        });
                        $('.select2').on('select2:unselecting', function (e) {
                            $(this).val('');
                        })
                    }, 1);
                },
                removeAccidentHistory: function (index) {
                    this.reportData.history.accident_histories.splice(index, 1);
                },
                updateForm: function (step) {
                    this.reportRender = 2;
                    this.renderForm = step;
                    $('input[name="data"]').val(JSON.stringify(this.reportData));

                    if (step == 14 && this.reportData.claimant.gender !== '') {
                        var rrData = JSON.stringify(this.reportData);
                        var G = this.reportData.claimant.gender === 'M' ? 'he' : 'she';
                        var GM = this.reportData.claimant.gender === 'M' ? 'his' : 'her';
                        rrData = rrData.replace(/\$he-she\$/g, G);
                        rrData = rrData.replace(/\$his-her\$/g, GM);
                        this.reportData = JSON.parse(rrData);
                        setTimeout(() => {
                            this.reportRender = 1;
                        }, 1)
                    } else {
                        var rrData = JSON.stringify(this.reportData);
                        rrData = rrData.replace(/ he /g, ' $he-she$ ');
                        rrData = rrData.replace(/ she /g, ' $he-she$ ');
                        rrData = rrData.replace(/ his /g, ' $his-her$ ');
                        rrData = rrData.replace(/ her /g, ' $his-her$ ');
                        this.reportData = JSON.parse(rrData);
                        setTimeout(() => {
                            this.reportRender = 0;
                        }, 1)
                    }
                }
            },
            mounted: function () {
                $('.select2').select2({
                    placeholder: "-- Select --",
                    width: '100%',
                    allowClear: true,
                    tags: true
                });

                $('.select2').on('select2:unselecting', function (e) {
                    $(this).val('');
                })
            }
        });
    </script>
@endsection

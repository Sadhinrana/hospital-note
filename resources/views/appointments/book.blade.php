<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment Book</title>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <style>
        .date.morning {
            width: 10px;
            height: 10px;
            top: 37px;
            content: " ";
            display: block;
            background: #6ED0F6;
            margin-left: 46%;
        }

        .date.afternoon {
            width: 10px;
            height: 10px;
            border-radius: 100%;
            top: 37px;
            content: " ";
            display: block;
            background: #F49AC1;
            margin-left: 46%;
        }

        .date.evening {
            width: 10px;
            height: 10px;
            top: 37px;
            content: " ";
            display: block;
            background: #F2DB4E;
            margin-left: 46%;
        }

        .eventBody {
            width: 100%;
            position: absolute;
            left: 0;
            bottom: -8px;
        }

        .event {
            width: 3px;
            height: 3px;
            border-radius: 150px;
            display: inline-block;
            background: #6ED0F6;
            margin: 0 2px;
        }

        .event.afternoon {
            background: #F49AC1;
        }

        .event.evening {
            background: #F2DB4E;
        }

        button.btn.btn-success {
            margin: 5px 0;
        }

        .user-info {
            display: none;
        }

        .flatpickr-calendar {
            width: 100% !important;
        }

        .date-picker {
            pointer-events: none;
            opacity: 0.5;
        }

        button.btn.btn-success.active {
            background-color: white;
            color: green;
        }

        /**
         * The CSS shown here will not be introduced in the Quickstart guide, but shows
         * how you can use CSS to style your Element's container.
         */
        .StripeElement {
            box-sizing: border-box;

            height: 40px;

            padding: 10px 12px;

            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;

            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }

        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }

        .StripeElement--invalid {
            border-color: #fa755a;
        }

        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }

        .stripe-button {
            border: none;
            border-radius: 4px;
            outline: none;
            text-decoration: none;
            color: #fff;
            background: #32325d;
            white-space: nowrap;
            display: inline-block;
            height: 40px;
            line-height: 40px;
            padding: 0 14px;
            box-shadow: 0 4px 6px rgba(50, 50, 93, .11), 0 1px 3px rgba(0, 0, 0, .08);
            border-radius: 4px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.025em;
            text-decoration: none;
            -webkit-transition: all 150ms ease;
            transition: all 150ms ease;
            float: left;
            margin-top: 25px;
        }

        #card-errors {
            height: 20px;
            padding: 4px 0;
            color: #fa755a;
        }

        .stripe-disabled {
            pointer-events: none;
            cursor: not-allowed;
            opacity: 0.5;
        }

        .service-charge {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="well">
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> {{ Session::get('success') }}
            </div>
            <a href="{{ url('/') }}" class="btn btn-success">Back to site</a>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <h2 class="text-center">Appointment Book</h2><br>

        <form class="form-horizontal" action="{{route('appointment.book')}}" method="post" id="payment-form">

            {{csrf_field()}}

            <div class="appointment">
                <div class="row" style="padding: 1%;">
                    <div class="col-md-6">
                        <div class="form-group" style="margin-left: 0;margin-right: 0;">
                            <label>Select Service <span class="text-danger">*</span></label>
                            @if($services->count() > 0)
                                <select @if(request('id')) onchange="getDoctor({{ request('id') }})" @else onchange="getDoctor();validateFormData()" @endif name="service_id" id="service_id" class="form-control" required>
                                    <option selected disabled>Select service</option>
                                    @foreach ($services as $service)
                                        <option value="{{$service->id}}" data-price="{{$service->price}}" data-payment="{{$service->is_payment}}">{{$service->name}}</option>
                                    @endforeach
                                </select>
                            @else
                                <p>No Service Available.</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group" style="margin-left: 0;margin-right: 0;">
                            <label>Select Doctor <span class="text-danger">*</span></label>
                            <select name="doctor_id" id="doctor_id" class="form-control"
                                    onchange="createNewFlatpickr();validateFormData()" required>
                                <option selected disabled>Select service first</option>
                                {{--@foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->firstname}} {{$user->lastname}}</option>
                                @endforeach--}}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="box border-info">
                            <div class="panel">
                                <div class="panel-body">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="date-picker col-md-5">
                                                <input type="hidden" name="from" id="from">
                                                <input class="form-control flatpickr flatpickr-input" type="text"
                                                       id="appointment_date" name="appointment_date"
                                                       onchange="validateFormData()" value="{{old('appointment_date')}}"
                                                       placeholder="Select Appointment Date" data-id="inline"
                                                       readonly="readonly" required>
                                            </div>
                                            <div class="col-md-7">
                                                <div style="padding: 7px!important;"
                                                     class="box-header bg-success text-center">
                                                    <h3 class="box-title">Date: </h3>

                                                </div>
                                                <div class="table-responsive text-center" style="width: 100%">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center"><span class="date morning"></span>Morning
                                                            </th>
                                                            <th class="text-center"><span class="date afternoon"></span>Afternoon
                                                            </th>
                                                            <th class="text-center"><span class="date evening"></span>Evening
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td colspan="3" id="morning">
                                                                <div class="text-info">Please choose a date</div>
                                                            </td>
                                                            <td id="afternoon">
                                                            </td>
                                                            <td id="evening">
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row" style="padding: 1%;">
                            <div class="form-group" style="margin-left: 0;margin-right: 0;">
                                <label>Comment </label>
                                <textarea name="description" id="description" class="form-control" rows="5" placeholder="Enter Comment...">{{old('description')}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" style="padding: 1%;">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="is_video_conference" value="1"> Video consultation
                            </label>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="stripe-disabled row" id="stripe-element-container" style="padding: 1%;">
                    <div class="col-md-12" style="background-color: #f7f8f9;">
                        <p class="service-charge text-danger">You will be charged <strong id="service-charge"></strong> for this service.</p>
                        <div>
                            <div class="form-row" style="width: 70%; float: left">
                                <label for="card-element">
                                    Credit or debit card
                                </label>
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>

                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>

                            <button style="width: 25%; float: right" type="button" onclick="getToken()" class="stripe-button">Submit Payment
                            </button>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="row" style="padding: 1%;">
                    <div class="col-md-6">

                    </div>
                    <div class="col-md-6 text-right">
                        <input type="button" id="continue-button" class="btn btn-lg btn-success" onclick="validate()" value="Continue" disabled>
                    </div>
                </div>
            </div>

            <div class="user-info">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Your Information</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="form-horizontal">
                        <div class="box-body">
                            <p style="margin-bottom: 15px!important;">
                                Please make sure you fill out all information requested. Required fields are marked *
                            </p>
                            <div class="form-group">
                                <label for="" class="col-sm-2 ">First Name <span>*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="firstname" class="form-control" placeholder="First Name"
                                           required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 ">Last Name <span>*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="lastname" class="form-control" placeholder="Last Name"
                                           required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 ">Gender <span>*</span></label>
                                <div class="col-sm-10">
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="male" checked>Male
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="female">Female
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 ">Date of Birth <span>*</span></label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <select type="text" name="dob_day" class="form-control" required>
                                                @php
                                                    for ($d=1; $d<=31; $d++) {
                                                        echo '  <option value="' . $d . '">' . $d . '</option>' . PHP_EOL;
                                                    }
                                                @endphp
                                            </select>
                                        </div>

                                        <div class="col-sm-2">
                                            <select type="text" name="dob_month" class="form-control" required>
                                                @php
                                                    for ($m=1; $m<=12; $m++) {
                                                        echo '  <option value="' . $m . '">' . date('M', mktime(0,0,0,$m)) . '</option>';
                                                    }
                                                @endphp
                                            </select>
                                        </div>

                                        <div class="col-sm-2">
                                            <select type="text" name="dob_year" class="form-control" required>
                                                @php
                                                    $cutoff = 1970;
                                                    $now = date('Y');
                                                        for ($y=$now; $y>=$cutoff; $y--) {
                                                           echo '  <option value="' . $y . '">' . $y . '</option>';
                                                       }
                                                @endphp
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12" style="border-bottom: 1px solid #D9D9E0">
                                    <h4>
                                        Your Contact Details
                                    </h4>
                                </div>
                                <div class="col-sm-12">
                                    <p>
                                        We need this to confirm your booking.
                                    </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 ">Email Address <span>*</span></label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control" placeholder="Enter Your Email"
                                           required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 ">Mobile Number <span>*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="phone" class="form-control"
                                           placeholder="Enter Mobile Number" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12" style="border-bottom: 1px solid #D9D9E0">
                                    <h4>
                                        Extra information
                                    </h4>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 ">More info</label>
                                <div class="col-sm-10">
                                    <textarea type="text" name="more_info" class="form-control"
                                              placeholder="Enter Your Comments"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <div class="checkbox">
                                        <label><input type="checkbox"> Remember me</label>
                                        <p><i>Don’t check this if you are using a public computer.</i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">Book appointment <i class="fa fa-check"></i>
                            </button>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    let Result = null;
    let fp = null;

    // Get availableDateTime for current doctor & month, year
    function getAvailableDateTime(month, year, days) {
        $.ajax({
            type: 'get',
            url: 'timings',
            data: {
                'service_id': $('#service_id option:selected').val(),
                'doctor_id': $('#doctor_id option:selected').val(),
                'month': month,
                'year': year,
                'days': days,
                'timeZone': Intl.DateTimeFormat().resolvedOptions().timeZone,
            },
            success: function (data) {
                initializeFlatpickr(data);
            }
        });
    }

    // Get availableDateTime for changed doctor
    function createNewFlatpickr() {
        $('#from').val('');

        // Clear timing
        $('#morning').replaceWith('<td colspan="3" id="morning"><div class="text-info">Please choose a date</div></td>');
        $('#afternoon').html('');
        $('#evening').html('');

        // Destroy previous flatpickr instance
        if (fp) {
            fp.destroy();
        }

        let date = new Date();
        getAvailableDateTime(date.getMonth() + 1, date.getFullYear(), new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate());
    }

    // Create a new instance of flatpkr
    function initializeFlatpickr(data) {
        Result = data;
        let disabledDates = [];

        fp = flatpickr(".flatpickr", {
            inline: true,
            minDate: 'today',
            altInput: true,
            allowInput: true,
            altFormat: 'd F, Y',
            onDayCreate: function (dObj, dStr, fp, dayElem) {
                if (formatDate($(dayElem).attr("aria-label")) in Result) {
                    var eventBody = "<span class='eventBody'>";
                    if (Result[formatDate($(dayElem).attr("aria-label"))]['morning'].length > 0) {
                        eventBody += "<span class='event'></span>";
                    }

                    if (Result[formatDate($(dayElem).attr("aria-label"))]['afternoon'].length > 0) {
                        eventBody += "<span class='event afternoon'></span>";
                    }

                    if (Result[formatDate($(dayElem).attr("aria-label"))]['evening'].length > 0) {
                        eventBody += "<span class='event evening'></span>";
                    }

                    eventBody += "</span>";
                    dayElem.innerHTML += eventBody;
                } else {
                    disabledDates.push(formatDate($(dayElem).attr("aria-label")));
                }
            },
            onMonthChange: function (selectedDates, dateStr, instance) {
                disabledDates = [];
                $('.date-picker').css({"pointer-events": "none", "opacity": "0.5"});
                $('#morning').replaceWith('<td colspan="3" id="morning"><div class="text-info">Please choose a date</div></td>');
                $('#afternoon').html('');
                $('#evening').html('');


                let date = new Date(instance.currentYear, instance.currentMonth);

                $.ajax({
                    type: 'get',
                    url: 'timings',
                    data: {
                        'service_id': $('#service_id option:selected').val(),
                        'doctor_id': $('#doctor_id option:selected').val(),
                        'month': date.getMonth() + 1,
                        'year': date.getFullYear(),
                        'days': new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate(),
                        'timeZone': Intl.DateTimeFormat().resolvedOptions().timeZone,
                    },
                    success: function (response) {
                        Result = response;

                        instance.redraw();
                        fp.set('disable', disabledDates);
                        $('.date-picker').css({"pointer-events": "all", "opacity": "1"});
                    }
                });
            },
            onYearChange: function (selectedDates, dateStr, instance) {
                disabledDates = [];
                $('.date-picker').css({"pointer-events": "none", "opacity": "0.5"});
                $('#morning').replaceWith('<td colspan="3" id="morning"><div class="text-info">Please choose a date</div></td>');
                $('#afternoon').html('');
                $('#evening').html('');


                let date = new Date(instance.currentYear, instance.currentMonth);

                $.ajax({
                    type: 'get',
                    url: 'timings',
                    data: {
                        'service_id': $('#service_id option:selected').val(),
                        'doctor_id': $('#doctor_id option:selected').val(),
                        'month': date.getMonth() + 1,
                        'year': date.getFullYear(),
                        'days': new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate(),
                        'timeZone': Intl.DateTimeFormat().resolvedOptions().timeZone,
                    },
                    success: function (response) {
                        Result = response;

                        instance.redraw();
                        fp.set('disable', disabledDates);
                        $('.date-picker').css({"pointer-events": "all", "opacity": "1"});
                    }
                });
            },
            onChange: function (selectedDates, dateStr, instance) {
                $('.box-title').text(dateStr);

                if (dateStr in Result) {
                    let [morning, afternoon, evening] = Array(3).fill('');

                    Result[dateStr]['morning'].forEach(function (value, index, array) {
                        morning += '<button type="button" class="btn btn-success" onclick="setFrom(this)">' + value + '</button><br>';
                    });
                    Result[dateStr]['afternoon'].forEach(function (value, index, array) {
                        afternoon += '<button type="button" class="btn btn-success" onclick="setFrom(this)">' + value + '</button><br>';
                    });
                    Result[dateStr]['evening'].forEach(function (value, index, array) {
                        evening += '<button type="button" class="btn btn-success" onclick="setFrom(this)">' + value + '</button><br>';
                    });

                    $('#morning').replaceWith('<td id="morning">' + morning + ' </td>');
                    $('#afternoon').html(afternoon);
                    $('#evening').html(evening);
                } else {
                    $('#morning').replaceWith('<td colspan="3" id="morning"><div class="text-danger">Doctor not available on selected date!</div></td>');
                    $('#afternoon').html('');
                    $('#evening').html('');
                }
            },
        });

        fp.set('disable', disabledDates);
        $('.date-picker').css({"pointer-events": "all", "opacity": "1"});
    }

    // Set from
    function setFrom(_this) {
        $('#from').val($(_this).text());

        // remove classes from all
        $("button").removeClass("active");
        // add class to the one we clicked
        $(_this).addClass("active");

        validateFormData();
    }

    // Format date
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

    // Get doctor by service
    function getDoctor(id) {
        // Set price message
        $('.service-charge').show();
        $('#service-charge').text('£ ' + $('#service_id option:selected').data('price'));

        if (id) {
            var url = window.location.origin + '/doctor-by-service/' + $('#service_id').val() + '?id=' + id;
        } else {
            var url = window.location.origin + '/doctor-by-service/' + $('#service_id').val();
        }

        // Clear timing
        $('#morning').replaceWith('<td colspan="3" id="morning"><div class="text-info">Please choose a date</div></td>');
        $('#afternoon').html('');
        $('#evening').html('');

        // Destroy previous flatpckr instance if exists
        if (fp) {
            fp.destroy();
        }

        // Make ajax call to get doctor by service
        $.ajax({
            type: 'get',
            url: url,
            success: function (response) {
                $('#doctor_id').html('');
                $('#doctor_id').append('<option selected disabled>Select doctor</option>');

                if (jQuery.isEmptyObject(response)) {
                    alert('No doctor found for this service!');
                } else {
                    for (var key in response) {
                        $('#doctor_id').append('<option value="' + response[key].id + '">' + response[key].firstname + ' ' + response[key].lastname + '</option>');
                    }
                }
            }
        });
    }

    function validate() {
        var service_id = $("#service_id option:selected").val();
        var doctor_id = $("#doctor_id option:selected").val();
        var appointment_date = $('input[name="appointment_date"]').val();
        var from = $('input[name="from"]').val();

        if ($.trim(service_id).length > 0 && $.trim(doctor_id).length > 0 &&
            $.trim(appointment_date).length > 0 &&
            $.trim(from).length > 0) {
            $('.user-info').show();
            $('.appointment').hide();
            return true;
        } else {
            alert("Please fill out all necessary fields.");
            return false;
        }
    }

    // Create a Stripe client.
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {hidePostalCode: true, style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function (event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission.
    function getToken() {
        stripe.createToken(card).then(function (result) {
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                stripeTokenHandler(result.token);
            }
        });
    }

    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById('payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        validate();
    }

    // Check if required fields are filled in or not
    function validateFormData() {
        var form = $('#payment-form');
        var service = $('#service_id option:selected').val();
        var doctor = $('#doctor_id option:selected').val();
        var is_payment = $('#service_id option:selected').data('payment');

        if(is_payment === 1){
            $('#stripe-element-container').show();
            $('#continue-button').prop('disabled', true);
        } else {
            $('#stripe-element-container').hide();
            $('#continue-button').prop('disabled', false);
        }

        var appointmentDate = form.find('input[name="appointment_date"]').val();
        var appointmentFromTime = form.find('input[name="from"]').val();

        if ($.trim(service).length > 0 && $.trim(doctor).length > 0 && $.trim(appointmentDate).length > 0 && $.trim(appointmentFromTime).length > 0) {
            $('#stripe-element-container').removeClass('stripe-disabled');
            return true;
        } else {
            $('#stripe-element-container').addClass('stripe-disabled');
            return false;
        }
    }
</script>
</body>
</html>

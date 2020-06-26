<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
@yield('title', config('adminlte.title', 'AdminLTE 2'))
@yield('title_postfix', config('adminlte.title_postfix', ''))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/vendor/Ionicons/css/ionicons.min.css') }}">

    @if(config('adminlte.plugins.select2'))
        <!-- Select2 -->
        <link rel="stylesheet" href="{{asset('css/select2.css')}}">
    @endif

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/AdminLTE.min.css') }}">

    @if(config('adminlte.plugins.datatables'))
        <!-- DataTables with bootstrap 3 style -->
        <link rel="stylesheet" href="{{asset('css/datatables.css')}}">
    @endif

    @yield('adminlte_css')

    <link href='{{ asset('fullcalendar/packages/core/main.css') }}' rel='stylesheet' />
    <link href='{{ asset('fullcalendar/packages/daygrid/main.css') }}' rel='stylesheet' />
    <link href='{{ asset('fullcalendar/packages/timegrid/main.css') }}' rel='stylesheet'/>
    <link href='{{ asset('fullcalendar/packages/list/main.css') }}' rel='stylesheet' />
    <link href='{{ asset('fullcalendar/packages/timeline/main.min.css') }}' rel='stylesheet' />
    <link href='{{ asset('fullcalendar/packages/resource-timeline/main.min.css') }}' rel='stylesheet' />

    <link rel="stylesheet" href="{{asset('flatdatepicker/flatdatepicker.css')}}">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    @toastr_css

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        @media print {
            a[href]:after {
                display: none;
                visibility: hidden;
            }
            #addchat-bubble {
                display: none;
                visibility: hidden;
            }
            .dataTables_length, .dataTables_filter, .dataTables_info, .dataTables_paginate {
                display: none;
                visibility: hidden;
            }
            .invFixed{
                table-layout: auto; width: 100%;
            }
            .invFixed th::after{
                display: none!important;
            }
        }
        .collapse.in, .collapse{
            height: 600px;
            width: 700px;
            overflow-y: scroll;
            /* max-height:200px; */
            }
        #patient-wrapper {
            display: none;
        }
        .custom-arrow{
            font-size: 30px;
            margin-right: 10px;
            cursor: pointer;
        }
        .count{
            margin: -2px 0 0 0;
            display: table;
            float: right;
            font-size: 20px;
        }
        .table-custom thead tr th {
            position: relative;
            cursor: pointer;
        }
        .table-custom-header::after {
            opacity: 0.2;
            content: "\e150";
            position: absolute;
            bottom: 8px;
            right: 8px;
            display: block;
            font-family: 'Glyphicons Halflings';
        }
        .sorting_asc::after {
            content: "\e155";
            position: absolute;
            bottom: 8px;
            right: 8px;
            display: block;
            font-family: 'Glyphicons Halflings';
            opacity: 0.5;
        }
        .sorting_desc::after {
            content: "\e156";
            position: absolute;
            bottom: 8px;
            right: 8px;
            display: block;
            font-family: 'Glyphicons Halflings';
            opacity: 0.5;
        }
        span.select2.select2-container.select2-container--default {
            width: 100% !important;
        }
    </style>

    @if(\Illuminate\Support\Facades\Auth::check() && auth()->user()->role_id != 5 && auth()->user()->role_id != 1 && auth()->user()->role_id != 2)
    <!-- 1. Addchat css -->
    <link href="<?php echo asset('assets/addchat/css/addchat.min.css') ?>" rel="stylesheet">
    @endif
</head>
<body class="hold-transition @yield('body_class')">

@yield('body')

<!-- 2. AddChat widget -->
<div id="addchat_app"
    data-baseurl="<?php echo url('') ?>"
    data-csrfname="<?php echo 'X-CSRF-Token' ?>"
    data-csrftoken="<?php echo csrf_token() ?>"
></div>

<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/jquery/dist/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('vendor/adminlte/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>


<link rel="stylesheet" href="{{asset('summernote/summernote.css')}}">
<script src="{{asset('summernote/summernote.js')}}"></script>

<script src="{{asset('js/moment.js')}}"></script>

<script src='{{asset('fullcalendar/packages/core/main.js')}}'></script>
<script src='{{asset('fullcalendar/packages/interaction/main.js')}}'></script>
<script src='{{asset('fullcalendar/packages/daygrid/main.js')}}'></script>
<script src='{{asset('fullcalendar/packages/timegrid/main.js')}}'></script>
<script src='{{asset('fullcalendar/packages/resource-common/main.min.js')}}'></script>
<script src='{{asset('fullcalendar/packages/resource-daygrid/main.min.js')}}'></script>
<script src='{{asset('fullcalendar/packages/resource-timegrid/main.min.js')}}'></script>
<script src='{{ asset('fullcalendar/packages/list/main.js') }}'></script>
<script href='{{ asset('fullcalendar/packages/timeline/main.min.js') }}'></script>
<script href='{{ asset('fullcalendar/packages/resource-timeline/main.min.js') }}'></script>

@if(config('adminlte.plugins.select2'))
    <!-- Select2 -->
    <script src="{{asset('js/select2.js')}}"></script>
@endif

@if(config('adminlte.plugins.chartjs'))
    <!-- ChartJS -->
    <script src="{{asset('js/chart.js')}}"></script>
@endif

<script src="{{asset('summernote/summer_scripts.js')}}"></script>
<script src="{{asset('flatdatepicker/flatdatepicker.js')}}"></script>

@toastr_js
@toastr_render

@if(\Illuminate\Support\Facades\Auth::check() && auth()->user()->role_id != 5 && auth()->user()->role_id != 1 && auth()->user()->role_id != 2)
<!-- 3. AddChat JS -->
<!-- Modern browsers -->
<script type="module" src="<?php echo asset('assets/addchat/js/addchat.min.js') ?>"></script>
<!-- Fallback support for Older browsers -->
<script nomodule src="<?php echo asset('assets/addchat/js/addchat-legacy.min.js') ?>"></script>
@endif

<script>
    function checkLengthOfMessage() {
        let selector = $('#message');
        let length = selector.val().length;

        if (length > 160) {
            let message = 'SMS messages use 1 credit per 160 characters. Your message exceed 160 characters. Your messages original length is ' + length + ' characters and will use ' + Math.ceil(length/160) + ' credit approximately.';
            selector.siblings('.help-block').find('strong').text(message);
            selector.closest('.form-group').addClass('has-feedback has-error');
        } else {
            selector.siblings('.help-block').find('strong').text('');
            selector.closest('.form-group').removeClass('has-feedback has-error');
        }
    }

    function goBack() {
        window.history.back();
    }

    function printContent(el){
        var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
    }

    $( document ).ready(function() {
        flatpickr("#end_time", {
            enableTime: true
        });

        flatpickr("#timing_from", {
            enableTime: true
        });

        flatpickr("#timing_to", {
            enableTime: true
        });

        flatpickr('#to');
        flatpickr('#from');
        flatpickr('#date_of_birth', {
            altInput: true,
            altFormat: "d M, Y",
            dateFormat: "Y-m-d",
        });
        flatpickr('#deadline');
        flatpickr('#due_date');

        flatpickr('.flatpickr', {
            altInput: true,
            altFormat: "d M, Y",
            dateFormat: "Y-m-d",
            placeholder: "Choose date",
        });

        $('#patients_list').select2({
            placeholder: "Select a patient",
            width: '100%',
            allowClear: true
        });

        $('#user_id_test').select2({
            placeholder: "Select a patient",
            width: '100%',
            tags: 'true',
            allowClear: true
        });

        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        $('#patient_id').select2({
            placeholder: "Select a patient",
            width: '100%',
            allowClear: true
        });

        $('#company_id').select2({
            placeholder: "Select a company",
            width: '100%',
            allowClear: true
        });

        $('#product_service').select2({
            placeholder: "Select a product or service",
            width: '100%',
            allowClear: true
        });

        $('#user_id').select2({
            placeholder: "Select a patient",
            width: '100%',
            allowClear: true
        });


       $('#doctor_id').select2({
           placeholder: "Select staff/doctor",
           width: '100%',
           allowClear: true
       });

        $('#service_id').select2({
            placeholder: "Select service",
            width: '100%',
            allowClear: true
        });

        $('#duration').select2({
            placeholder: "",
            width: '100%',
            allowClear: true
        });

        $('#place').select2({
            placeholder: "",
            width: '100%',
            allowClear: true
        });

        $('#addchat-bubble').addClass('no-print');
    });

    function changeAppointmentProgress(id, progress) {
        $("#progress > option").each(function() {
            if ($(this).val() === progress) {
                $(this).prop('selected', true);
            }
        });

        $('#appointment_progress').modal('show');
        $('#appointment_progress').find('form').attr('action', '{{ url('progress') }}/' + id);
    }

    function dateDiffInDays(firstDate, secondDate) {
        const _MS_PER_DAY = 1000 * 60 * 60 * 24;

        let fDate = new Date(firstDate);
        let sDate = new Date(secondDate);

        // Discard the time and time-zone information.
        const utc1 = Date.UTC(fDate.getFullYear(), fDate.getMonth(), fDate.getDate());
        const utc2 = Date.UTC(sDate.getFullYear(), sDate.getMonth(), sDate.getDate());

        return Math.round((utc2 - utc1) / _MS_PER_DAY);
    }
</script>

@yield('adminlte_js')

</body>
</html>

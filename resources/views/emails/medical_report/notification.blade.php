@component('mail::message')
#Hi, {{ $medical_report->patient ? $medical_report->patient->firstname : '' }}

{{ $message }}

@component('mail::button', ['url' => url("/patient-medical-report/{$encrypted_id}")])
    Go to medical document
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

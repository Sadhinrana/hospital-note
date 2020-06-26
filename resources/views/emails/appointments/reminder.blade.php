@component('mail::message')
# Appointment Reminder

{!! nl2br($body) !!}

@component('mail::button', ['url' => route('appointments.show', $appointment->id)])
View Appointment
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

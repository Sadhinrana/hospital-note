@component('mail::message')
# New Appointment Created

@component('mail::panel')
    You have a new appointment scheduled at <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M, Y') }} {{ \Carbon\Carbon::parse($appointment->from)->format('h:iA') }}-{{ \Carbon\Carbon::parse($appointment->to)->format('h:iA') }}</strong>.
@endcomponent

@component('mail::table')
|        |          |
| ------------- | ------------- |
| Appointment Description      | {!! $appointment->description !!}      |
| Appointment Status      |  @if ($appointment->status == 'close')<strong>CLOSED</strong>@else<strong>OPEN</strong>@endif |
| Appointment Date | {{\Carbon\Carbon::parse($appointment->appointment_date)->format('D, M j, Y g:i A')}} |
@if ($appointment->status == 'close')
| Slot Duration (Hours) | {{Carbon\Carbon::parse($appointment->appointment_date)->diffInHours($appointment->end_time)}} |
@endif
|Created By | {{$appointment->creator->firstname}}  |
| Created On | {{$appointment->created_at->format('Y M, jS, D,  g:i A')}} |

@endcomponent

@component('mail::button', ['url' => route('appointments.show', $appointment->id), 'color' => 'success'])
    View more
@endcomponent


Thanks, <br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
# New Appointment Created

@component('mail::panel')
You have a new appointment scheduled at <strong>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M, Y') }} {{ \Carbon\Carbon::parse($appointment->from)->format('h:iA') }}-{{ \Carbon\Carbon::parse($appointment->to)->format('h:iA') }}</strong>. This appointment is a video consultation appointment and you are requested to attend the video consultation at scheduled date time.
@endcomponent

@component('mail::panel')
Medico Legal teleconference Appointment.<br>
Due to Corona Virus This Appointment is permitted to occur via Remote Video Interview. by Agreeing and clicking below "Join Video Consultation", you confirm:<br>
<ul>
    <li>You have been advised by your legal representative.</li>
    <li>You have opted to have this interview recorded.</li>
    <li>You understand that a susbesequent face to face examination may be required.</li>
    <li>You are under no pressure to proceed and may wish to wait until government restrictions are lifted.</li>
</ul>
Please click below "Join Video Consultation" to give your consent and to proceed.
@endcomponent

@component('mail::button', ['url' => $route, 'color' => 'success'])
Join Video Consultation
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

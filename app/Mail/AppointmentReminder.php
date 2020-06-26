<?php

namespace App\Mail;

use App\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppointmentReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user, $appointment, $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $appointment, $body)
    {
        $this->user = $user;
        $this->appointment = $appointment;
        $this->body = $body;

        Appointment::where('id', $this->appointment->id)->update(['send_mail' => 2]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.appointments.reminder')
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->to($this->user->email, $this->user->firstname . ' ' . $this->user->lastname)
            ->subject('Appointment Reminder')
            ->with([ 'user' => $this->user, 'appointment' => $this->appointment, 'body' => $this->body ]);
    }
}

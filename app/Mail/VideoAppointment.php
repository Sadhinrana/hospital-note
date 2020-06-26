<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VideoAppointment extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment, $route;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($appointment, $route)
    {
        $this->appointment = $appointment;
        $this->route = $route;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.appointments.video-conference');
    }
}

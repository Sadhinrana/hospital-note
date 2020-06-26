<?php

namespace App\Jobs;

use App\Sms;
use App\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Twilio\Rest\Client;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sid, $token, $client, $user, $body, $appointment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $body, $appointment)
    {
        // Your Account SID and Auth Token from twilio.com/console
        $this->sid    = env( 'TWILIO_SID' );
        $this->token  = env( 'TWILIO_TOKEN' );
        $this->client = new Client( $this->sid, $this->token );

        $this->user = $user;
        $this->body = $body;
        $this->appointment = $appointment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->client->messages->create(
            $this->user->phone,
            [
                'from' => env('TWILIO_FROM'),
                'body' => $this->body,
            ]
        );

        // Insert into DB
        Sms::create([
                'from' => env('TWILIO_FROM'),
                'to' => $this->user->phone,
                'message' => $this->body,
                'user_id' => $this->user->id,
            ]
        );

        Appointment::where('id', $this->appointment->id)->update(['send_sms' => 2]);
    }
}

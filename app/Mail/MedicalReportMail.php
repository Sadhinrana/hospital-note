<?php

namespace App\Mail;

use App\MedicalReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MedicalReportMail extends Mailable
{
    use Queueable, SerializesModels;

    private $medical_report;
    private $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(MedicalReport $medical_report, $message)
    {
        $this->medical_report = $medical_report;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.medical_report.notification', [
            'medical_report' => $this->medical_report,
            'encrypted_id' => encrypt($this->medical_report->id),
            'message' => $this->message
        ]);
    }
}

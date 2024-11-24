<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $appoinment;
    public $available;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $appoinment, $available)
    {
        $this->user = $user;
        $this->appoinment = $appoinment;
        $this->available = $available;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Appointment Confirmation')
                    ->view('client.appoinment.appointment_confirmation');
    }
}
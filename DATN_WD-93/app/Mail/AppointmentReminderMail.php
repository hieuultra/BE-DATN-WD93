<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment; // Thông tin lịch hẹn
    public $user; // Thông tin người dùng

    /**
     * Tạo một instance mới của Mailable.
     */
    public function __construct($appointment, $user)
    {
        $this->appointment = $appointment;
        $this->user = $user;
    }

    /**
     * Xây dựng email.
     */
    public function build()
    {
        return $this->subject('Nhắc nhở lịch khám sắp tới')
                    ->view('client.appoinment.appointment_reminder');
    }
}

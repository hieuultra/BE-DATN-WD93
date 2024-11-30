<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DiscountCodeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $discountCode;

    /**
     * Create a new message instance.
     */
    public function __construct($discountCode)
    {
        $this->discountCode = $discountCode;
    }
      /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Mã giảm giá của bạn:')
                    ->view('emails.discount_code')
                    ->with('discountCode', $this->discountCode);
    }
}

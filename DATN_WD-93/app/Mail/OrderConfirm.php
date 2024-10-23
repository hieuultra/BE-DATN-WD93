<?php

namespace App\Mail;

use App\Models\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderConfirm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $bill;
    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }
    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Order Confirmation')
            ->markdown('client.orders.mail')
            ->with('bill', $this->bill);
    }
}

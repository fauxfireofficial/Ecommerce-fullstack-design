<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderFeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rate Your Order #' . $this->order->order_number . ' - Feedback',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.feedback',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

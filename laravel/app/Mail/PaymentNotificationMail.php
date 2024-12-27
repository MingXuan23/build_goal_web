<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $type;
    public $content;
    public $amount;
    public $transaction_no;
    public $created_at;
    public $name;
    public $card_quantity;
    /**
     * Create a new message instance.
     */
    public function __construct($type, $content, $amount, $transaction_no, $created_at, $name,$card_quantity)
    {
        //
        $this->type = $type;
        $this->content = $content;
        $this->amount = $amount;
        $this->transaction_no = $transaction_no;
        $this->created_at = $created_at;
        $this->name = $name;
        $this->card_quantity = $card_quantity;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Notification Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

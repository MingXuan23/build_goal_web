<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContentNotificationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $status;
    public $reject_reason;
    public $name;
    public $content_name;
    /**
     * Create a new message instance.
     */
    public function __construct($status, $reject_reason, $name, $content_name)
    {
        //
        $this->status = $status;
        $this->reject_reason = $reject_reason;
        $this->name = $name;
        $this->content_name = $content_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Content Notification Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contentNotificationEmail'
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

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $messageText;
    public $url;

    /**
     * Create a new message instance.
     */
    public function __construct($subjectText, $messageText, $url = null)
    {
        $this->subjectText = $subjectText;
        $this->messageText = $messageText;
        $this->url = $url;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admin Notification Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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

    public function build()
    {
        return $this->subject($this->subjectText)
            ->markdown('emails.admin.notification')
            ->with([
                'messageText' => $this->messageText,
                'url' => $this->url,
                'userName' => auth('user')->user()->name,
                'timestamp' => now()->translatedFormat('d F Y, H:i'),
            ]);
    }
}

<?php

namespace App\Mail;

use App\Models\Sewa;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class SewaKadaluarsaNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $sewa;

    /**
     * Create a new message instance.
     */
    public function __construct(Sewa $sewa)
    {
        $this->sewa = $sewa;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Peringatan: Masa Sewa Anda Telah Kadaluarsa',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.sewa_kadaluarsa',
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

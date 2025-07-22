<?php

namespace App\Mail;

use App\Models\Sewa;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class PengingatJatuhTempo extends Mailable
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
            subject: 'Pengingat Jatuh Tempo',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pengingat',
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
        return $this->subject('Pengingat Jatuh Tempo Sewa')
            ->view('emails.pengingat')
            ->with([
                'sewa' => $this->sewa
            ]);
    }
}

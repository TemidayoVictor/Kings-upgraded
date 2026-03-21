<?php

namespace App\Mail;

use App\Models\DropshipperStore;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StoreClonedMail extends Mailable
{
    use Queueable, SerializesModels;

    public DropshipperStore $store;

    public array $stats;

    /**
     * Create a new message instance.
     */
    public function __construct(DropshipperStore $store, array $stats)
    {
        $this->store = $store;
        $this->stats = $stats;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your KING'S Store is Ready! 🎉",
            tags: ['store-cloned'],
            metadata: [
                'store_id' => $this->store->id,
                'user_id' => $this->notifiable->id,
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.notifications.store-cloned-content',
            with: [
                'notifiable' => $this->notifiable,
                'store' => $this->store,
                'stats' => $this->stats,
                'brand' => $this->store->brand,
                'dropshipper' => $this->store->dropshipper,
                'year' => date('Y'),
            ]
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

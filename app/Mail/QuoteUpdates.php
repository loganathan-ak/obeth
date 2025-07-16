<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Orders;

class QuoteUpdates extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $quote;
    public $order;

    public function __construct($quote)
    {
        $this->quote = $quote;
        $this->user = User::find($quote->user_id);
        $this->order = Orders::find($quote->order_id);
    
        if (!$this->user) {
            throw new \Exception('User not found for quote ID: ' . $quote->id);
        }
    }
    

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Quote Update Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.quote-updates',
            with: [
                'user' => $this->user,
                'quote' => $this->quote,
                'order' => $this->order, // Add this
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

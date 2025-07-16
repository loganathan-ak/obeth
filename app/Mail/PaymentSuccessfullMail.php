<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessfullMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $plan;
    public $payment;

    public function __construct($user, $plan, $payment)
    {
        $this->user = $user;
        $this->plan = $plan;
        $this->payment = $payment;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Payment Successful');
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.payment-success-mail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

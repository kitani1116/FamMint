<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $recipient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $recipient)
    {
        $this->data = $data;
        $this->recipient = $recipient;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        
        

        if ($this->recipient === 'user') {
            return new Envelope(
                subject: 'お問い合わせ完了通知 ' . $this->data['type'] . 'の件',);
        }else{
            return new Envelope(
            subject: 'お問い合わせがありました。',
        );
        }


        
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    
    public function content()
    {
        return new Content(
            view: 'emails.contact-form',
        );
    }
    

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}

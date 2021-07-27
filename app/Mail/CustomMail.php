<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;
    public $content;
    public $subject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content, $subject)
    {
        //
        $this->content = $content;
        $this->subject = $subject;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
        ->view('CustomMail')
        ->subject($this->subject)
            ->with([
                'content' => $this->content,
            ]);
    }
}

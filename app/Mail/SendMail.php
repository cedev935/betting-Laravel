<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $from_email;
    public $site_title;
    public $subject;
    public $message;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_from, $subject, $message, $fromName = null)
    {
        $basic = (object)config('basic');
        $this->from_email = $email_from;
        $this->site_title = ($fromName) ? : $basic->site_title;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return @$this->from($this->from_email, $this->site_title)->view('layouts.mail')->with('msg', $this->message);
    }
}

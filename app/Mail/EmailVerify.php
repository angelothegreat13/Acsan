<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerify extends Mailable
{
    use Queueable, SerializesModels;

    public $firstname;
    public $verificationCode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($firstname,$verificationCode)
    {
        $this->firstname = $firstname;
        $this->verificationCode = $verificationCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email-verify')->subject('Email Verification');
    }
}

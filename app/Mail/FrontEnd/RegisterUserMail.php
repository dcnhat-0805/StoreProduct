<?php

namespace App\Mail\FrontEnd;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterUserMail extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var
     */
    protected $verificationCode;

    /**
     * RegisterUserMail constructor.
     *
     * @param $verificationCode
     */
    public function __construct($verificationCode)
    {
        $this->verificationCode = $verificationCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('frontend.pages.mail.verification_user', ['verificationCode' => $this->verificationCode])
            ->subject(EMAIL_SUBJECT_PREFIX_USER . EMAIL_SUBJECT_USER)
            ->from(EMAIL_FORM, EMAIL_NAME);
    }
}

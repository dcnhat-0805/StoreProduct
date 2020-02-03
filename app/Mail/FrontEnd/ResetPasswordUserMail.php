<?php

namespace App\Mail\FrontEnd;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordUserMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    protected $userPasswordReset;

    /**
     * Create a new message instance.
     *
     * @param $userPasswordReset
     *
     * @return void
     */
    public function __construct($userPasswordReset)
    {
        $this->userPasswordReset = $userPasswordReset;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('frontend.pages.mail.forget_password_mail', ['adminPasswordReset' => $this->userPasswordReset])
            ->subject(EMAIL_SUBJECT_PREFIX . EMAIL_SUBJECT)
            ->from(EMAIL_FORM, EMAIL_NAME);
    }
}

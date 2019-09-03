<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    protected $adminPasswordReset;

    /**
     * Create a new message instance.
     *
     * @param $adminPasswordReset
     *
     * @return void
     */
    public function __construct($adminPasswordReset)
    {
        $this->adminPasswordReset = $adminPasswordReset;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('backend.mail.forget_password_mail', ['adminPasswordReset' => $this->adminPasswordReset])
            ->subject(EMAIL_SUBJECT_PREFIX . EMAIL_SUBJECT)
            ->from(EMAIL_FORM, EMAIL_NAME);
    }
}

<?php

namespace App\Mail\FrontEnd;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShoppingMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $orderDetail = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $orderDetail)
    {
        $this->order = $order;
        $this->orderDetail = $orderDetail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('frontend.pages.mail.shopping', ['order' => $this->order, 'orderDetail' => $this->orderDetail])
            ->subject(EMAIL_SUBJECT_PREFIX_USER . EMAIL_SUBJECT_SHOPPING)
            ->from(EMAIL_FORM, EMAIL_NAME);
    }
}

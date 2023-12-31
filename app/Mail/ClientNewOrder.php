<?php

namespace App\Mail;

use App\Http\Controllers\Checkout\DataTransferObject\OrderDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientNewOrder extends Mailable
{
    use Queueable, SerializesModels;

    private string $paymentUrl;
    private OrderDTO $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OrderDTO $order, string $paymentUrl)
    {
        $this->order = $order;
        $this->paymentUrl = $paymentUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.client-new-order', ['order' => $this->order, 'paymentUrl' => $this->paymentUrl]);
    }
}

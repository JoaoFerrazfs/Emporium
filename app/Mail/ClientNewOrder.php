<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientNewOrder extends Mailable
{
    use Queueable, SerializesModels;

    private string $paymentUrl;
    private Order $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, string $paymentUrl)
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

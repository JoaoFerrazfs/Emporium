<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrder extends Mailable
{
    use Queueable, SerializesModels;

    private Order $order;

    public function __construct(Order $order)
    {
       $this->order = $order;
    }

    public function build(): self
    {
        return $this->markdown('email.new-order', ['order' => $this->order]);
    }
}

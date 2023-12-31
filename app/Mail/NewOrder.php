<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use stdClass;

class NewOrder extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly Order $order
    ) {
    }

    public function build(): self
    {
        return $this->markdown('email.new-order', ['order' => $this->order]);
    }
}

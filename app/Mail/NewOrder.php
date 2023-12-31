<?php

namespace App\Mail;

use App\Http\Controllers\Checkout\DataTransferObject\OrderDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrder extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly OrderDTO $order
    ) {
    }

    public function build(): self
    {
        return $this->markdown('email.new-order', ['order' => $this->order]);
    }
}

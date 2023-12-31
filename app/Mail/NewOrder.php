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

    private stdClass $order;

    public function __construct(array $order)
    {
        $this->order = new stdClass();
    }

    public function build(): self
    {
        return $this->markdown('email.new-order', ['order' => $this->order]);
    }
}

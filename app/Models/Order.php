<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'city',
        'street',
        'number',
        'status',
        'cart_id',
        'observation',
        'neighborhood',
        'pickUpInStore',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddress(): string
    {
        $address = implode(', ', [
            $this->city,
            $this->neighborhood,
            $this->street,
            $this->number
        ]);

        return $address;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'status',
        'stock',
        'validate',
        'ingredients',
    ];

    const REPORTS_FIELDS = [
        'name',
        'description',
        'price',
        'status',
        'stock',
        'validate',
        'ingredients',
    ];


    public function hasEnoughStock(float $quantity): bool {

        return $this->stock > $quantity;
    }
}

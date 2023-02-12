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
    ];

    public function isOrder(): bool
    {
        return $this->order == "Encomenda" ;
    }

    public function isAvailable(): bool
    {
        return $this->availability == "Disponível" ;
    }
}

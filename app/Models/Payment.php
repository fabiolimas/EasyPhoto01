<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
     protected $fillable = [
        'pedido_id',
        'payment_id',
        'type',
        'amount',
        'status',
        'payload'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}

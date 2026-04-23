<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
      protected $fillable = [
        'pedido_id',
        'data_pagamento',
        'status_pagamento',
        'valor',
        'payment_method',
        'mp_payment_id',
        'preference_id'
    ];
}

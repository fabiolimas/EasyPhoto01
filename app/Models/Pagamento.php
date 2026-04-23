<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



    class Pagamento extends Model
{
    protected $fillable = [
        'descricao',
        'valor',
        'status',
        'payment_id',
        'pix_qr_code',
        'pix_copia_cola'
    ];
}


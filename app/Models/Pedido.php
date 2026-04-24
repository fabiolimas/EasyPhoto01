<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function payments()
{
    return $this->hasMany(Payment::class);
}

public function payment()
{
    return $this->hasOne(Payment::class)->latestOfMany();
}
}

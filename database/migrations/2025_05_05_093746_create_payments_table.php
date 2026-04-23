<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained()->onDelete('cascade');
            $table->string('data_pagamento');
            $table->string('status_pagamento');
            $table->double('valor', 10,2);
            $table->string('payment_method');
            $table->string('mp_payment_id')->nullable();
            $table->string('preference_id')->nullable();

            $table->text('pix_qr_code')->nullable();
            $table->text('pix_copia_cola')->nullable();
            $table->string('boleto_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

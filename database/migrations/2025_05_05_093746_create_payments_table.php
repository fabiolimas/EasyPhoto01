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

        $table->string('payment_id')->nullable(); // ID da Cielo
        $table->string('type')->default('pix');
        $table->integer('amount'); // em centavos
        $table->string('status')->default('pendente');

        $table->json('payload')->nullable(); // resposta completa da Cielo

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

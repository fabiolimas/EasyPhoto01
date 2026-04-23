<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pagamentos', function (Blueprint $table) {
        $table->id();
        $table->string('descricao')->nullable();
        $table->decimal('valor', 10, 2);
        $table->string('status')->default('pending');
        $table->string('payment_id')->nullable();
        $table->string('pix_qr_code')->nullable();
        $table->text('pix_copia_cola')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};
